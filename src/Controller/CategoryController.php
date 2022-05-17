<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Service\UserSetting;

class CategoryController extends AbstractController
{
    private $setting;
    private $paginator;
    private $productRepo;

    public function __construct(
            UserSetting $setting,
            PaginatorInterface $paginator,
            ProductRepository $productRepo
    ) {
        $this->setting = $setting;
        $this->paginator = $paginator;
        $this->productRepo = $productRepo;
    }
    
    /**
     * @Route("/catalog/{url}", name="category")
     */
    public function category(Request $request): Response
    {
        $category = $this->setting->categoryRepo()->findOneBy(['url' => $request->get('url')]);
        $qb = $this->productRepo->productsForCategory($this->setting->categories()->getSubCategories($category->getId()));
        $page = $request->query->get('page', 1);
        
        if(is_numeric($page))
        {
            $pagination = $this->paginator->paginate($qb, $page, 20);
        } else {
            return new Response("Page not found<br>Return to <a href='/'>Main</a>", 404);
        }
        
        $pagination->setTotalItemCount($this->productRepo->count($this->setting->categories()->getSubCategories($category->getId())));
        
        $pagination->setPaginatorOptions([
            'distinct' => false,
            'pageParameterName' => "page",
            "sortFieldParameterName" => "sort",
            "sortDirectionParameterName" => "direction",
            "filterFieldParameterName" => "filterField",
            "filterValueParameterName" => "filterValue",
            "distinct" => false,
            "pageOutOfRange" => "ignore",
            "defaultLimit" => 10]);
        
        return $this->render($this->setting->usedTheme() . '/category.twig', [
            'keywords' => $request->request->get('keywords'),
            'categoryBrands' => $this->setting->brandRepo()->categoryBrands($this->setting->categories()->getSubCategories($category->getId())),
            'categories' => $this->setting->categories()->list(),
            'brands' => $this->setting->brands(),
            'category' => $category,
            'products' => $pagination,
        ]);
    }
    
    /**
     * @Route("/catalog/{category}/{brand}", name="category_and_brand")
     */
    public function categoryAndBrand(Request $request): Response
    {
        $category = $this->setting->categoryRepo()->findOneBy(['url' => $request->get('category')]);
        $brand = $this->setting->brandRepo()->findOneBy(['url' => $request->get('brand')]);
        $qb = $this->productRepo->productsForCategoryAndBrand($this->setting->categories()->getSubCategories($category->getId()), $brand->getId());
        $page = $request->query->get('page', 1);
        
        if(is_numeric($page))
        {
            $pagination = $this->paginator->paginate($qb, $page, 20);
        } else {
            return new Response("Page not found<br>Return to <a href='/'>Main</a>", 404);
        }
        
        return $this->render($this->setting->usedTheme() . '/category.twig', [
            'keywords' => $request->request->get('keywords'),
            'categoryBrands' => $this->setting->brandRepo()->categoryBrands($this->setting->categories()->getSubCategories($category->getId())),
            'categories' => $this->setting->categories()->list(),
            'brands' => $this->setting->brands(),
            'category' => $category,
            'products' => $pagination,
        ]);
    }
}
