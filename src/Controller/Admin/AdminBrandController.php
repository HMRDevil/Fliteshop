<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BrandRepository;
use App\Form\BrandType;
use App\Entity\Brand;

class AdminBrandController extends AbstractController
{
    private $repository;
    
    public function __construct(BrandRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin/brand", name="admin_brand")
     */
    public function index(): Response
    {
        return $this->render('@admin/brands.twig', [
            'brands' => $this->repository->findAll(),
        ]);
    }
    
    /**
     * @Route("/admin/brand_add", name="admin_brand_add")
     */
    public function new(Request $request): Response
    {
        $newBrand = new Brand();
        $brandForm = $this->createForm(BrandType::class, $newBrand);
        $brandForm->handleRequest($request);
        
        if ($brandForm->isSubmitted() && $brandForm->isValid())
        {
            $repository->add($newBrand);
            return $this->redirectToRoute('admin_brand');
        }
        
        return $this->renderForm('@admin/brand_form.twig', [
            'brandForm' => $brandForm,
            
        ]);
    }
    
    /**
     * @Route("/admin/brand_edit/{id}", name="admin_brand_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Brand $brand): Response
    {
        $brandForm = $this->createForm(BrandType::class, $brand);
        $brandForm->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {
            $repository->add($brand);
            return $this->redirectToRoute('admin_brand');
        }

        return $this->renderForm('@admin/brand_form.twig', [
            'brandForm' => $brandForm,
        ]);
    }
    
    /**
     * @Route("/admin/brand_delete/{id}", name="admin_brand_delete", methods={"GET"})
     */
    public function delete(Brand $brand, BrandRepository $repository): Response
    {
        $repository->remove($brand);

        return $this->redirectToRoute('admin_brand');
    }
    
    /**
     * @Route("/admin/brand_action", name="admin_brand_action", methods={"POST"})
     */
    public function action(Request $request, BrandRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('action_checked', $request->request->get('_token')) and is_array($request->request->get('brands')))
        {
            switch ($request->request->get('action'))
            {
                case 'delete':
                    $repository->delete($request->request->get('brands'));
                    break;
            }
        }
        
        return $this->redirectToRoute('admin_brand');
    }
}
