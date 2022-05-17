<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LabelRepository;
use App\Entity\Label;

class AdminLabelController extends AbstractController
{
    private $repository;
    
    public function __construct(LabelRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("admin/label", name="admin_label")
     */
    public function index(Request $request): Response
    {
        return $this->render('@admin/labels.twig', [
            'labels' => $this->repository->findAll()
        ]);
    }
    
    /**
     * @Route("/admin/label_add", name="admin_label_add")
     */
    public function new(Request $request): Response
    {
        $newLabel = new Label();
        $labelForm = $this->createForm(LabelType::class, $newLabel);
        $labelForm->handleRequest($request);
        
        if ($labelForm->isSubmitted() && $labelForm->isValid())
        {
            $repository->add($newLabel);
            return $this->redirectToRoute('admin_label');
        }
        
        return $this->renderForm('@admin/label_form.twig', [
            'labelForm' => $labelForm,
            
        ]);
    }
    
    /**
     * @Route("/admin/label_edit/{id}", name="admin_label_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Label $label): Response
    {
        $labelForm = $this->createForm(LabelType::class, $label);
        $labelForm->handleRequest($request);

        if ($labelForm->isSubmitted() && $labelForm->isValid()) {
            $repository->add($label);
            return $this->redirectToRoute('admin_label');
        }

        return $this->renderForm('@admin/label_form.twig', [
            'labelForm' => $labelForm,
        ]);
    }
    
    /**
     * @Route("/admin/label_delete/{id}", name="admin_label_delete", methods={"GET"})
     */
    public function delete(Label $label, LabelRepository $repository): Response
    {
        $repository->remove($label);

        return $this->redirectToRoute('admin_label');
    }
    
    /**
     * @Route("/admin/label_action", name="admin_label_action", methods={"POST"})
     */
    public function action(Request $request, LabelRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('action_checked', $request->request->get('_token')) and is_array($request->request->get('labels')))
        {
            switch ($request->request->get('action'))
            {
                case 'delete':
                    $repository->delete($request->request->get('labels'));
                    break;
            }
        }
        
        return $this->redirectToRoute('admin_label');
    }
}
