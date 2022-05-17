<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Service\UserSetting;

class BrandController extends AbstractController
{
    private $setting;
    private $paginator;
    private $productRepo;

    public function __construct(
            UserSetting $setting,
            PaginatorInterface $paginator,
            ProductRepository $productRepo
    ) {
        $this->productRepo = $productRepo;
        $this->paginator = $paginator;
        $this->setting = $setting;
    }
    
    /**
     * @Route("/brands/{url}", name="brand")
     */
    public function index(Request $request): Response
    {
        $brand = $this->setting->brandRepo()->findOneBy(['url' => $request->get('url')]);
        $qb = $this->productRepo->productsForBrand($brand->getId());
        $page = $request->query->get('page', 1);
        
        if(is_numeric($page))
        {
            $pagination = $this->paginator->paginate($qb, $page, 20);
        } else {
            return new Response("Page not found<br>Return to <a href='/'>Main</a>", 404);
        }
        
        return $this->render($this->setting->usedTheme() . '/brand.twig', [
            'keywords' => $request->request->get('keywords'),
            'categories' => $this->setting->categories()->list(),
            'brands' => $this->setting->brands(),
            'brand' => $brand,
            'products' => $pagination,
        ]);
    }
}
