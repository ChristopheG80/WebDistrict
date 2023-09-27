<?php

namespace App\Controller;

use App\Form\BarreRechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class BarreRechercheController extends AbstractController
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }
    
    
}
