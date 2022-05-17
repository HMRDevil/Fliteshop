<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Form\CommentToBlogType;
use App\Entity\Blog;
use App\Service\UserSetting;

class BlogController extends AbstractController
{
    private $setting;
    private $doctrine;
    private $paginator;

    public function __construct(ManagerRegistry $doctrine, PaginatorInterface $paginator, UserSetting $setting)
    {
        $this->doctrine = $doctrine;
        $this->paginator = $paginator;
        $this->setting = $setting;
    }
    
    /**
     * @Route("/blog", name="blog")
     */
    public function index(Request $request): Response
    {
        $qb = $this->doctrine->getRepository(Blog::class)->getQBBlogPager();
        
        $page = $request->query->get('page', 1);
        
        if(is_numeric($page))
        {
            $pagination = $this->paginator->paginate($qb, $page, 20);
        } elseif(mb_strtolower($page) === 'all') {
            $pagination = $this->paginator->paginate($qb, 1);
        } else {
            return new Response("Page not found<br>Return to <a href='/blog'>Blog</a>", 404);
        }
        
        return $this->render($this->setting->usedTheme() . '/blog.twig', [
            'keywords' => $request->request->get('keywords'),
            'categories' => $this->setting->categories()->list(),
            'brands' => $this->setting->brands(),
            'pagination' => $pagination,
        ]);
    }
    
    /**
     * @Route("/blog/{url}", name="blog_post")
     */
    public function blogPost(Request $request, string $url): Response
    {
        $comment = new Comment();
        $blogPage = $this->doctrine->getRepository(Blog::class)->findOneBy(['url' => $url]);
        $commentForm = $this->createForm(CommentToBlogType::class, $comment);
        
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid())
        {
            $comment = $commentForm->getData();
            
            $comment->setDate(new \DateTime('NOW'));
            $comment->setType(2);
            $comment->setObjectId($blogPage->getId());
            $comment->setIp($request->getClientIp());
            $comment->setApproved(0);
            
            $this->doctrine->getRepository(Comment::class)->add($comment);
            
            return $this->redirect($url);
        }
        
        return $this->renderForm($this->setting->usedTheme() . '/blog_post.twig', [
            'page' => $blogPage,
            'commentForm' => $commentForm,
            'blogPageComments' => $this->doctrine->getRepository(Comment::class)->findBy([
                'type' => Comment::BLOG_TYPE,
                'objectId' => $blogPage->getId(),
                'approved' => true
            ]),
            'keywords' => $request->request->get('keywords'),
            'categories' => $this->setting->categories()->list(),
            'brands' => $this->setting->brands(),
        ]);
    }
}