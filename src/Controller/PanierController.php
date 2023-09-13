<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends AbstractController
{
    private $mailer;

    //On injecte dans le constructeur le MailerInterface

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    
    public function index(PlatRepository $repo): Response
    {

        $plats = $repo->findAll();

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'plats' => $plats
        ]);
    }

    #[Route('/panier/ajout/{plat}', name: 'app_panier_add')]
    public function addDetails(SessionInterface $session, Plat $plat, Request $request): Response
    {
        // dd($plat_id);
        $panier = $session->get("panier", []);
        $referer = $request->headers->get('referer');
        //dd($plat->getId($plat));
        //dd($panier[$plat->findOneById($plat)]);
        
        if (isset($panier[$plat->getId()])) {
            $panier[$plat->getId()]++;
        } else {
            $panier[$plat->getId()] = 1;
        }
//dd($panier);
        $session->set("panier", $panier);
        //$session->set("panier", []);
        return $this->redirect("$referer");
    }

    #[Route('/panier', name: 'app_panier')]
    public function panier(SessionInterface $session, PlatRepository $repo): Response
    {
        $panier = $session->get("panier", []);

        $nouveau_panier = [];
        foreach ($panier as $key => $value) {
            $p = $repo->find($key);
            $nouveau_panier[] = $p;
        }
        dump($panier);
        dump($nouveau_panier);
        return $this->render('panier/panier.html.twig', [
            'panier' => $panier,
            'nouveau_panier' => $nouveau_panier,
        ]);
    }
}
