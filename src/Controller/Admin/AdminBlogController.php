<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BlogRepository;
use App\Form\BlogType;
use App\Entity\Blog;

class AdminBlogController extends AbstractController
{
    private $paginator;
    
    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }
    
    /**
     * @Route("/admin/blog", name="admin_blog")
     */
    public function index(Request $request, BlogRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('admin_blog_search', $request->request->get('_token')))
        {
            $qb = $repository->getQBBlogPager(true, $request->request->get('search'));
        } else {
            $qb = $repository->getQBBlogPager(true);
        }
        $page = $request->query->get('page', 1);
        $pagination = $this->paginator->paginate($qb, $page, 25);
        
        return $this->render('@admin/blogs.twig', [
            'pagination' => $pagination,
            'keywords' => $request->request->get('search'),
        ]);
    }
    
    /**
     * @Route("/admin/blog_add", name="admin_blog_add")
     */
    public function new(Request $request, BlogRepository $repository): Response
    {
        $newBlogPage = new Blog();
        $blogForm = $this->createForm(BlogType::class, $newBlogPage);
        $blogForm->handleRequest($request);
        
        if ($blogForm->isSubmitted() && $blogForm->isValid())
        {
            $repository->add($newBlogPage);
            return $this->redirectToRoute('admin_blog');
        }
        
        return $this->renderForm('@admin/blog_form.twig', [
            'blogForm' => $blogForm,
            
        ]);
    }
    
    /**
     * @Route("/admin/blog_edit/{id}", name="admin_blog_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Blog $blog, BlogRepository $repository): Response
    {
        $blogForm = $this->createForm(BlogType::class, $blog);
        $blogForm->handleRequest($request);

        if ($blogForm->isSubmitted() && $blogForm->isValid()) {
            $repository->add($blog);
            return $this->redirectToRoute('admin_blog');
        }

        return $this->renderForm('@admin/blog_form.twig', [
            'blogForm' => $blogForm,
        ]);
    }
    
    /**
     * @Route("/admin/blog_delete/{id}", name="admin_blog_delete", methods={"GET"})
     */
    public function delete(Blog $blog, BlogRepository $repository): Response
    {
        $repository->remove($blog);

        return $this->redirectToRoute('admin_blog');
    }
    
    /**
     * @Route("/admin/blog_visible/{id}", name="admin_blog_visible", methods={"GET"})
     */
    public function visible(Blog $blog, BlogRepository $repository): Response
    {
        if($blog->getVisible() == true)
        {
            $repository->visible([$blog->getId()], false);
        } else {
            $repository->visible([$blog->getId()], true);
        }
        
        return $this->redirectToRoute('admin_blog');
    }
    
    /**
     * @Route("/admin/blog_action", name="admin_blog_action", methods={"POST"})
     */
    public function action(Request $request, BlogRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('action_checked', $request->request->get('_token')) and is_array($request->request->get('blogs')))
        {
            switch ($request->request->get('action'))
            {
                case 'visible':
                    $repository->visible($request->request->get('blogs'));
                    break;
                case 'invisible':
                    $repository->visible($request->request->get('blogs'), false);
                    break;
                case 'delete':
                    $repository->delete($request->request->get('blogs'));
                    break;
            }
        }
        
        return $this->redirectToRoute('admin_blog');
    }
}
