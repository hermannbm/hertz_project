<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/voiture/{id}', name: 'voiture_edit')]
    #[Route('/admin/voiture', name: 'gestion_voiture')]
    public function gestionVoiture(Request $request, EntityManagerInterface $manager, VoitureRepository $repo, Voiture $voiture = null): Response
    {
        $colonnes = $manager->getClassMetadata(Voiture::class)->getFieldNames();
        $tousVoitures = $repo->findAll();

        if($voiture == null)
        {
        $voiture = new Voiture;
        }
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $voiture->setDateEnregistrement(new \Datetime);
            $manager->persist($voiture);
            $manager->flush();
            // $this->addFlash('success', 'Modifications enregistrées');
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/carManagement.html.twig', [
            "formVoiture" => $form,
            "colonnes" => $colonnes,
            "voitures" => $tousVoitures,
            "editMode" => $voiture->getId()!=null
        ]);
    }
}