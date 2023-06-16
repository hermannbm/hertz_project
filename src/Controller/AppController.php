<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(VoitureRepository $repo): Response
    {
        $voitures = $repo->findAll();
        return $this->render('app/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }
    #[Route('/car/view/{id}', name: 'voiture_test')]
    public function carview(Voiture $voiture): Response
    {
        return $this->render('app/carView.html.twig' , [
            'voiture' => $voiture,
        ]);
    }

   }