<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\FeatureRepository;
use App\Form\FeatureType;
use App\Entity\Feature;

class AdminFeatureController extends AbstractController
{
    private $repository;
    
    public function __construct(FeatureRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin/feature", name="admin_feature")
     */
    public function index(): Response
    {
        return $this->render('@admin/features.twig', [
            'features' => $this->repository->findAll(),
        ]);
    }
    
    /**
     * @Route("/admin/feature_add", name="admin_feature_add")
     */
    public function new(Request $request, CategoryRepository $catRepo): Response
    {
        $newFeature = new Feature();
        $featureForm = $this->createForm(FeatureType::class, $newFeature);
        $featureForm->handleRequest($request);
        
        if ($featureForm->isSubmitted() && $featureForm->isValid())
        {
            $repository->add($newFeature);
            return $this->redirectToRoute('admin_feature');
        }
        
        return $this->renderForm('@admin/feature_form.twig', [
            'featureForm' => $featureForm,
            'categories' => $catRepo->findAll(),
        ]);
    }
    
    /**
     * @Route("/admin/feature_edit/{id}", name="admin_feature_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Feature $feature, CategoryRepository $catRepo): Response
    {
        $featureForm = $this->createForm(FeatureType::class, $feature);
        $featureForm->handleRequest($request);

        if ($featureForm->isSubmitted() && $featureForm->isValid()) {
            $repository->add($feature);
            return $this->redirectToRoute('admin_feature');
        }

        return $this->renderForm('@admin/feature_form.twig', [
            'featureForm' => $featureForm,
        ]);
    }
    
    /**
     * @Route("/admin/feature_delete/{id}", name="admin_feature_delete", methods={"GET"})
     */
    public function delete(Feature $feature, FeatureRepository $repository): Response
    {
        $repository->remove($feature);

        return $this->redirectToRoute('admin_feature');
    }
    
    /**
     * @Route("/admin/feature_action", name="admin_feature_action", methods={"POST"})
     */
    public function action(Request $request, FeatureRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('action_checked', $request->request->get('_token')) and is_array($request->request->get('features')))
        {
            switch ($request->request->get('action'))
            {
                case 'visible':
                    $repository->visible($request->request->get('features'));
                    break;
                case 'invisible':
                    $repository->visible($request->request->get('features'), false);
                    break;
                case 'delete':
                    $repository->delete($request->request->get('features'));
                    break;
            }
        }
        
        return $this->redirectToRoute('admin_feature');
    }
}
