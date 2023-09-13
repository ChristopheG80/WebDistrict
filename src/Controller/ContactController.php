<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\MailerController;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\MailService;

class ContactController extends AbstractController
{
    private $mailer;

    //On injecte dans le constructeur le MailerInterface

    public function __construct(MailerInterface $mailer){
        // $this->mailer = $mailer;
    }
    
    
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailService $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = new Contact();
            $data = $form->getData();
            $message = $data;

            $entityManager->persist($message);
            $entityManager->flush();

            //dd($message->getObjet(),$message->getEmail(),$message->getMessage());
            $oo = strval($message->getObjet());
            $ee = strval($message->getEmail());
            $mm = strval($message->getMessage());
            //dd($oo,$ee,$mm);
            $mailer->sendMail($oo, $ee, $mm);

            return $this->redirectToRoute('app_catalogue');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form
        ]);
    }
}
