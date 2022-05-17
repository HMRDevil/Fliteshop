<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CouponRepository;
use App\Form\CouponType;
use App\Entity\Coupon;

class AdminCouponController extends AbstractController
{
    /**
     * @Route("/admin/coupon", name="admin_coupon")
     */
    public function index(CouponRepository $repository): Response
    {
        return $this->render('@admin/coupons.twig', [
            'coupons' => $repository->findAll(),
            
        ]);
    }
    
    /**
     * @Route("/admin/coupon_add", name="admin_coupon_add")
     */
    public function new(Request $request, CouponRepository $repository): Response
    {
        $newCoupon = new Coupon();
        $couponForm = $this->createForm(CouponType::class, $newCoupon);
        $couponForm->handleRequest($request);
        
        if ($couponForm->isSubmitted() && $couponForm->isValid())
        {
            $newCoupon->setUsages(0);
            $repository->add($newCoupon);
            return $this->redirectToRoute('admin_coupon');
        }
        
        return $this->renderForm('@admin/coupon_form.twig', [
            'couponForm' => $couponForm,
            
        ]);
    }
    
    /**
     * @Route("/admin/coupon_edit/{id}", name="admin_coupon_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Coupon $coupon, CouponRepository $repository): Response
    {
        $couponForm = $this->createForm(CouponType::class, $coupon);
        $couponForm->handleRequest($request);

        if ($couponForm->isSubmitted() && $couponForm->isValid()) {
            $repository->add($coupon);
            return $this->redirectToRoute('admin_coupon');
        }

        return $this->renderForm('@admin/coupon_form.twig', [
            'couponForm' => $couponForm,
        ]);
    }
    
    /**
     * @Route("/admin/coupon_delete/{id}", name="admin_coupon_delete", methods={"GET"})
     */
    public function delete(Coupon $blog, CouponRepository $blogRepository): Response
    {
        $blogRepository->remove($blog);

        return $this->redirectToRoute('admin_coupon');
    }
}
