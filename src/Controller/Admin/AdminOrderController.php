<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LabelRepository;
use App\Repository\OrderRepository;
use App\Form\OrderType;
use App\Entity\Order;

class AdminOrderController extends AbstractController
{
    private $paginator;
    private $repository;
    private $labelRepo;

    public function __construct(
            PaginatorInterface $paginator,
            OrderRepository $repository,
            LabelRepository $labelRepo
    ) {
        $this->paginator = $paginator;
        $this->repository = $repository;
        $this->labelRepo = $labelRepo;
    }
    
    /**
     * @Route("/admin/order", requirements={"status": "0|1|2|3"}, name="admin_order")
     */
    public function index(Request $request): Response
    {
        if (null === $request->get('status'))
        {
            $qb = $this->repository->getQBOrderPager(null, 0);
        } else {
            $qb = $this->repository->getQBOrderPager(null, $request->get('status'));
        }
        
        if ($this->isCsrfTokenValid('admin_order_search', $request->request->get('_token')))
        {
            $qb = $this->repository->getQBOrderPager($request->request->get('search'));
        }
        
        $page = $request->query->get('page', 1);
        $pagination = $this->paginator->paginate($qb, $page, 25);
        
        return $this->render('@admin/orders.twig', [
            'pagination' => $pagination,
            'keywords' => $request->get('keywords'),
            'status' => $request->get('status')??0,
            'labels' => $this->labelRepo->allOrderByPosition(),
        ]);
    }
    
    /**
     * @Route("/admin/order_add", name="admin_order_add")
     */
    public function new(Request $request): Response
    {
        $newOrder = new Order();
        $orderForm = $this->createForm(OrderType::class, $newOrder);
        $orderForm->handleRequest($request);
        
        if ($orderForm->isSubmitted() && $orderForm->isValid())
        {
            $repository->add($newOrder);
            return $this->redirectToRoute('admin_order');
        }
        
        return $this->renderForm('@admin/order_form.twig', [
            'orderForm' => $orderForm,
            
        ]);
    }
    
    /**
     * @Route("/admin/order_edit/{id}", name="admin_order_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Order $order): Response
    {
        $orderForm = $this->createForm(OrderType::class, $order);
        $orderForm->handleRequest($request);

        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $repository->add($order);
            return $this->redirectToRoute('admin_order');
        }

        return $this->renderForm('@admin/order_form.twig', [
            'orderForm' => $orderForm,
        ]);
    }
    
    /**
     * @Route("/admin/order_delete/{id}", name="admin_order_delete", methods={"GET"})
     */
    public function delete(Order $order, OrderRepository $repository): Response
    {
        $repository->remove($order);

        return $this->redirectToRoute('admin_order');
    }
    
    /**
     * @Route("/admin/order_action", name="admin_order_action", methods={"POST"})
     */
    public function action(Request $request, OrderRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('action_checked', $request->request->get('_token')) and is_array($request->request->get('orders')))
        {
            switch ($request->request->get('action'))
            {
                case 'delete':
                    $repository->delete($request->request->get('orders'));
                    break;
            }
        }
        
        return $this->redirectToRoute('admin_order');
    }
}
