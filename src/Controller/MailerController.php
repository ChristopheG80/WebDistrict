<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
// use Symfony\Component\Mime\Email;
// use Symfony\Component\Mime\Address;


class MailerController extends AbstractController
{


    #[Route('/email', name: 'app_email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            // le chemin de la vue Twig à utiliser dans le mail
            ->htmlTemplate('email/index.html.twig')
            ->html('<p>See Twig integration for better HTML integration!</p>')

            // un tableau de variable à passer à la vue; 
           //  on choisit le nom d'une variable pour la vue et on lui attribue une valeur (comme dans la fonction `render`) :
           ->context([
            'expiration_date' => new \DateTime('+7 days'),
            'username' => 'foo',
            ]);

        $mailer->send($email);
    
        return $this->render('email/index.html.twig', [
            // 'controllerName' => 'Mailer____Controller',
            'mailer' => $mailer,
        ]);
    }
}

