<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Entity\Order;

class AdminOrderController extends AbstractController
{
    private $repository;
    
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin/order", requirements={"status": "0|1|2|3"}, name="admin_order")
     */
    public function index(Request $request): Response
    {
        return $this->render('@admin/orders.twig', [
            'orders' => $this->repository->findBy(['status' => $request->get('status')??Order::ORDER_STATUS_NEW]),
            'keywords' => $request->get('keywords'),
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
