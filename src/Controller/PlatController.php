<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlatRepository;
use Symfony\component\Mailer\MailerInterface;

class PlatController extends AbstractController
{
    
    private $platRepo;
    //On injecte dans le constructeur le MailerInterface
    private $mailer;
    
    public function __construct(PlatRepository $platRepo, MailerInterface $mailer)
    {
        $this->platRepo = $platRepo;
        $this->mailer = $mailer;
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
