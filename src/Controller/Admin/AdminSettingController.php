<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AdminSetting;

class AdminSettingController extends AbstractController
{
    /**
     * @Route("/admin/setting", name="admin_setting")
     */
    public function index(Request $request, AdminSetting $settings): Response
    {
        if ($this->isCsrfTokenValid('setting_save', $request->request->get('_token')))
        {
            $settings->setSettings($request->request->all());
        }
        
        return $this->render('@admin/settings.twig', [
                'settings' => $settings->getSettings(),
            ]);
    }
}
