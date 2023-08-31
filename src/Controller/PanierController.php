<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
    
    #[Route('/panier/ajout/{id}', name: 'app_panier')]
    public function addDetails(): Response
    {
        return $this->render('panier/addDetails.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
}
