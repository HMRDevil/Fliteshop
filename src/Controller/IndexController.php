<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserSetting;
use App\Repository\ProductRepository;

class IndexController extends AbstractController
{
    private $setting;
    private $productRepo;

    public function __construct(
            ProductRepository $productRepo,
            UserSetting $setting
    ) {
        $this->productRepo = $productRepo;
        $this->setting = $setting;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render($this->setting->usedTheme() . '/index.twig', [
            'keywords' => '',
            'recommended' => $this->productRepo->recommended(),
            'thing' => $thing = $this->productRepo->thing(),
            'stock' => $this->productRepo->stock(),
            'categories' => $this->setting->categories()->list(),
            'brands' => $this->setting->brands(),
        ]);
    }
}