<?php 
namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;




class MailService extends AbstractController
{
    private $mailer;

    //On injecte dans le constructeur le MailerInterface

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }
    
    public function sendMail($objet='Objet laissé vide', $to='you@example.com', $message='Message laissé vide'): Response
    {
        //dd($objet);
        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to($to)
            ->subject($objet)
            ->text($message)
            //->htmlTemplate('email/signup.html.twig')
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
                ]);
        $this->mailer->send($email);
            
        return $this->render('email/signup.html.twig', [
            // 'controllerName' => 'Mailer____Controller',
            'mailer' => $this->mailer,
        ]);
        
    }
}