<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;


class ReactController extends AbstractController
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }
    
    #[Route('/react', name: 'app_react')]
    public function index(): Response
    {
        return $this->render('react/index.html.twig', [
            'controller_name' => 'ReactController',
        ]);
    }
}
