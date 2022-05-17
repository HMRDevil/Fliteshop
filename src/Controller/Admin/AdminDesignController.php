<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AdminSetting;
use App\Service\TemplateService;
use App\Service\CssService;

class AdminDesignController extends AbstractController
{
    /**
     * @Route("/admin/design", name="admin_design")
     */
    public function theme_index(Request $request, AdminSetting $settings): Response
    {
        if ($this->isCsrfTokenValid('design', $request->request->get('_token')))
        {
            $settings->setTheme($this->setting->usedTheme());
        }
        
        return $this->render('@admin/design.twig', [
            'allThemes' => $settings->allThemes(),
            'installed' => $settings->usedTheme(),
        ]);
    }
    
    /**
     * @Route("/admin/template", name="admin_template")
     */
    public function template_index(Request $request, TemplateService $template, $tmplName = 'index.twig'): Response
    {
        if ($this->isCsrfTokenValid('template_save', $request->request->get('_token')))
        {
            $template->saveTemplate($request->request->get('tmplName'), $request->request->get('tmplBody'));
        }
        
        if($request->isXmlHttpRequest())
        {
            return new Response($template->getTmplBody($request->query->get('tmplName')));
        }
        
        return $this->render('@admin/templates.twig', [
            'templates' => $template->getAllTemplates(),
            'tmplName' => $tmplName,
            'tmplBody' => $template->getTmplBody($tmplName),
        ]);
    }
    
    /**
     * @Route("/admin/style", name="admin_style")
     */
    public function style_index(Request $request, CssService $style, $styleName = 'main.css'): Response
    {
        if ($this->isCsrfTokenValid('style_save', $request->request->get('_token')))
        {
            $style->saveCss($request->request->get('styleName'), $request->request->get('styleBody'));
        }
        
        if($request->isXmlHttpRequest())
        {
            return new Response($style->getStyleBody($request->query->get('styleName')));
        }
        
        return $this->render('@admin/styles.twig', [
            'styles' => $style->getAllStyles(),
            'styleName' => $styleName,
            'styleBody' => $style->getStyleBody($styleName),
        ]);
    }
}
