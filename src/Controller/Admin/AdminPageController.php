<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PageRepository;
use App\Entity\Page;

class AdminPageController extends AbstractController
{
    private $repository;
    
    public function __construct(
            PaginatorInterface $paginator,
            PageRepository $repository
    ) {
        $this->paginator = $paginator;
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin/page", name="admin_page")
     */
    public function index(): Response
    {
        return $this->render('@admin/pages.twig', [
            'pages' => $this->repository->findAll(),
        ]);
    }
}
