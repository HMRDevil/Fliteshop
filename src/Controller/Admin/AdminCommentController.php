<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentRepository;
use App\Entity\Comment;
//
class AdminCommentController extends AbstractController
{
    private $paginator;
    
    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }
    
    /**
     * @Route("/admin/comment", name="admin_comment")
     */
    public function index(Request $request, CommentRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('admin_comment_search', $request->request->get('_token')))
        {
            $qb = $repository->getQBCommentPager(false, $request->request->get('search'));
        } else {
            $qb = $repository->getQBCommentPager(false);
        }
        $page = $request->query->get('page', 1);
        $pagination = $this->paginator->paginate($qb, $page, 25);
        
        return $this->render('@admin/comments.twig', [
            'pagination' => $pagination,
            'keywords' => $request->request->get('search'),
        ]);
    }
    
    /**
     * @Route("/admin/comment_delete/{id}", name="admin_comment_delete", methods={"GET"})
     */
    public function delete(Comment $comment, CommentRepository $repository): Response
    {
        $repository->remove($comment);

        return $this->redirectToRoute('admin_comment');
    }
    
    /**
     * @Route("/admin/comment_action", name="admin_comment_action", methods={"POST"})
     */
    public function action(Request $request, CommentRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('action_checked', $request->request->get('_token')) and is_array($request->request->get('comments')))
        {
            switch ($request->request->get('action'))
            {
                case 'approved':
                    $repository->approved($request->request->get('comments'));
                    break;
                case 'delete':
                    $repository->delete($request->request->get('comments'));
                    break;
            }
        }
        
        return $this->redirectToRoute('admin_comment');
    }
}
