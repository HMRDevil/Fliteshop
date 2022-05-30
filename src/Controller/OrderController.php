<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Repository\PaymentMethodRepository;
use App\Repository\PurchaseRepository;
use App\Repository\CurrencyRepository;
use App\Repository\ProductRepository;
use App\Service\UserSetting;

class OrderController extends AbstractController
{
    private $setting;
    private $repository;
    private $productRepo;
    private $purchaseRepo;
    private $currencyRepo;
    private $paymentMethodRepo;

    public function __construct(
            OrderRepository $repository,
            UserSetting $setting,
            ProductRepository $productRepo,
            PurchaseRepository $purchaseRepo,
            CurrencyRepository $currencyRepo,
            PaymentMethodRepository $paymentMethodRepo
    ) {
        $this->repository = $repository;
        $this->setting = $setting;
        $this->productRepo = $productRepo;
        $this->purchaseRepo = $purchaseRepo;
        $this->currencyRepo = $currencyRepo;
        $this->paymentMethodRepo = $paymentMethodRepo;
    }
    
    /**
     * @Route("/order", name="order")
     */
    public function index(Request $request): Response
    {
        $order = $this->repository->findOneBy(['url' => $request->get('url')]);
        
        return $this->render($this->setting->usedTheme() . '/order.twig', [
            'keywords' => '',
            'recommended' => $this->productRepo->recommended(),
            'thing' => $thing = $this->productRepo->thing(),
            'stock' => $this->productRepo->stock(),
            'categories' => $this->setting->categories()->list(),
            'brands' => $this->setting->brands(),
            'order' => $order,
            'purchases' => $this->purchaseRepo->findBy(['orderId' => $order->getId()]),
            'currency' => $this->currencyRepo->find($order->getDelivery()),
            'currencies' => $this->currencyRepo->findAll(),
            'payment_methods' => $this->paymentMethodRepo->findAll(),
            'payment_method' => $this->paymentMethodRepo->find($order->getPaymentMethod()),
        ]);
    }
}
