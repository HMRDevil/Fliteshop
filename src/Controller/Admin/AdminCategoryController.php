<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Form\CategoryType;
use App\Entity\Category;

class AdminCategoryController extends AbstractController
{
    private $repository;
    
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index(Request $request): Response
    {
        return $this->render('@admin/categories.twig', [
            'categories' => $this->repository->findAll(),
        ]);
    }
    
    /**
     * @Route("/admin/category_add", name="admin_category_add")
     */
    public function new(Request $request): Response
    {
        $newCategory = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $newCategory);
        $categoryForm->handleRequest($request);
        
        if ($categoryForm->isSubmitted() && $categoryForm->isValid())
        {
            $repository->add($newCategory);
            return $this->redirectToRoute('admin_category');
        }
        
        return $this->renderForm('@admin/category_form.twig', [
            'categoryForm' => $categoryForm,
            
        ]);
    }
    
    /**
     * @Route("/admin/category_edit/{id}", name="admin_category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category $category): Response
    {
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $repository->add($category);
            return $this->redirectToRoute('admin_category');
        }

        return $this->renderForm('@admin/category_form.twig', [
            'categoryForm' => $categoryForm,
        ]);
    }
    
    /**
     * @Route("/admin/category_delete/{id}", name="admin_category_delete", methods={"GET"})
     */
    public function delete(Category $category, CategoryRepository $repository): Response
    {
        $repository->remove($category);

        return $this->redirectToRoute('admin_category');
    }
    
    /**
     * @Route("/admin/category_action", name="admin_category_action", methods={"POST"})
     */
    public function action(Request $request, CategoryRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('action_checked', $request->request->get('_token')) and is_array($request->request->get('categories')))
        {
            switch ($request->request->get('action'))
            {
                case 'visible':
                    $repository->visible($request->request->get('categories'));
                    break;
                case 'invisible':
                    $repository->visible($request->request->get('categories'), false);
                    break;
                case 'delete':
                    $repository->delete($request->request->get('categories'));
                    break;
            }
        }
        
        return $this->redirectToRoute('admin_category');
    }
}
