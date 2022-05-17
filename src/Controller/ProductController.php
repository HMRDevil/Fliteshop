<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Service\UserSetting;

class ProductController extends AbstractController
{
    private $setting;
    private $repository;
    private $paginator;

    public function __construct(
            ProductRepository $repository,
            PaginatorInterface $paginator,
            UserSetting $setting
    ) {
        $this->repository = $repository;
        $this->paginator = $paginator;
        $this->setting = $setting;
    }
    
    /**
     * @Route("/products", name="products")
     */
    public function products(Request $request): Response
    {
        if ($this->isCsrfTokenValid('product_search', $request->request->get('_token'))) {
            $qb = $this->repository->getQBProductPager($request->request->get('keywords'));
        } else {
            $qb = $this->repository->getQBProductPager();
        }
        
        $page = $request->query->get('page', 1);
        
        if(is_numeric($page))
        {
            $pagination = $this->paginator->paginate($qb, $page, 20);
        } else {
            return new Response("Page not found<br>Return to <a href='/'>Main</a>", 404);
        }
        
        return $this->render($this->setting->usedTheme() . '/products.twig', [
            'keywords' => $request->request->get('keywords'),
            'categories' => $this->setting->categories(),
            'brands' => $this->setting->brands(),
            'products' => $pagination
        ]);
    }
    
    /**
     * @Route("/products/{url}", name="product")
     */
    public function product(Request $request): Response
    {
        return $this->render($this->setting->usedTheme() . '/product.twig', [
            'product' => $this->repository->findOneBy(['url' => $request->get('url')]),
            'keywords' => $request->get('keywords'),
            'categories' => $this->setting->categories(),
            'brands' => $this->setting->brands(),
        ]);
    }
}