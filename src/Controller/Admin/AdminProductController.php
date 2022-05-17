<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use App\Entity\Product;

class AdminProductController extends AbstractController
{
    private $paginator;
    private $repository;
    
    public function __construct(PaginatorInterface $paginator, ProductRepository $repository)
    {
        $this->repository = $repository;
        $this->paginator = $paginator;
    }
    
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {
        return $this->redirectToRoute('admin_product');
    }
    
    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function index(Request $request): Response
    {
        if ($this->isCsrfTokenValid('admin_product_search', $request->request->get('_token')))
        {
            $qb = $this->repository->getSearchProductsInnerJoinVariants($request->request->get('search'));
        } else {
            $qb = $this->repository->innerJoinVariantsForProducts();
        }
        
        $page = $request->query->get('page', 1);
        $pagination = $this->paginator->paginate($qb, $page, 25);
        
        return $this->render('@admin/products.twig', [
            'pagination' => $pagination,
            'keywords' => $request->request->get('search'),
        ]);
    }
    
    /**
     * @Route("/admin/product_add", name="admin_product_add")
     */
    public function new(Request $request): Response
    {
        $newProduct = new Product();
        $productForm = $this->createForm(ProductType::class, $newProduct);
        $productForm->handleRequest($request);
        
        if ($productForm->isSubmitted() && $productForm->isValid())
        {
            $repository->add($newProduct);
            return $this->redirectToRoute('admin_product');
        }
        
        return $this->renderForm('@admin/product_form.twig', [
            'productForm' => $productForm,
            
        ]);
    }
    
    /**
     * @Route("/admin/product_edit/{id}", name="admin_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $productForm = $this->createForm(ProductType::class, $product);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $repository->add($product);
            return $this->redirectToRoute('admin_product');
        }

        return $this->renderForm('@admin/product_form.twig', [
            'productForm' => $productForm,
        ]);
    }
    
    /**
     * @Route("/admin/product_delete/{id}", name="admin_product_delete", methods={"GET"})
     */
    public function delete(Product $product, ProductRepository $repository): Response
    {
        $repository->remove($product);

        return $this->redirectToRoute('admin_product');
    }
    
    /**
     * @Route("/admin/product_action", name="admin_product_action", methods={"POST"})
     */
    public function action(Request $request, ProductRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('action_checked', $request->request->get('_token')) and is_array($request->request->get('products')))
        {
            switch ($request->request->get('action'))
            {
                case 'delete':
                    $repository->delete($request->request->get('product'));
                    break;
            }
        }
        
        return $this->redirectToRoute('admin_product');
    }
}
