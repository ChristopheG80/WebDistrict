<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

// use Symfony\Component\Mime\Email;
// use Symfony\Component\Mime\Address;


class MailerController extends AbstractController
{

    private $mailer;

    //On injecte dans le constructeur le MailerInterface

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }
    
    #[Route('/email', name: 'app_email')]
    public function sendEmail(MailerInterface $mailer, $objet="Objet laissé vide", $to='you@example.com', $message="Message laissé vide"): Response
    {
        //dd($objet);
        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to($to)
            // ->to('you@example.com')
            // ->cc('cc@example.com')
            // ->bcc('bcc@example.com')
            // ->replyTo('monadresse@example.com')
            // ->returnPath('oubliemoi@example.com')
            // ->priority(TemplatedEmail::PRIORITY_LOW)
            ->subject($objet)
            // ->subject('Récapitulatif de votre commande chez District')
            ->text($message)
            // ->text('Sending emails is fun again!')
            // ->addPart(new DataPart(new File('/public/doc/mentions.php'), 'Fichier PHP'))
            // le chemin de la vue Twig à utiliser dans le mail
            ->htmlTemplate('email/signup.html.twig')
            ->html('<p>See Twig integration for better HTML integration!</p>')
            ->addPart((new DataPart(fopen('assets/images_the_district/the_district_brand/logo.png', 'r'), 'logo', 'image/png'))->asInline())
            ->addPart((new DataPart(new File('assets/images_the_district/bg1.jpeg'), 'footer-signature', 'image/gif'))->asInline())
    // utiliser la syntaxe 'cid:' + "nom de l'image intégrée " pour référencer l'image
            ->html('<img src="cid:logo"> ... <img src="cid:footer-signature"> ...')
    // utiliser la même syntaxe pour les images intégrées en tant que background
            ->html('... <div background="cid:footer-signature"> ... </div> ...')
            // un tableau de variable à passer à la vue; 
           //  on choisit le nom d'une variable pour la vue et on lui attribue une valeur (comme dans la fonction `render`) :
           ->context([
            'expiration_date' => new \DateTime('+7 days'),
            'username' => 'foo',
            ]);

        $mailer->send($email);
    
        return $this->render('email/signup.html.twig', [
            // 'controllerName' => 'Mailer____Controller',
            'mailer' => $mailer,
        ]);
    }
}

