<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlatRepository;

class PlatController extends AbstractController
{
    private $platRepo;
    
    public function __construct(PlatRepository $platRepo)
    {
        $this->platRepo = $platRepo;
    }

    #[Route('/plats', name: 'app_plat')]
    public function index(): Response
    {
        $plats= $this->platRepo->showallPlats();
        return $this->render('plat/index.html.twig', [
            'controller_name' => 'PlatController',
            'plats' => $plats
        ]);
    }
}
