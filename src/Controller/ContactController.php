<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form= $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $message = new Contact();
            $data = $form->getData();
            $message= $data;
//dd($data, $message);
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_catalogue');
        }
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form
        ]);
    }
}
