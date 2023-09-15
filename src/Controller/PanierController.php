<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Detail;
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


    
    public function index(PlatRepository $repo, Request $request): Response
    {

        $form = $this->createForm(LivraisonpanierType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
        $plats = $repo->findAll();

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'plats' => $plats,
            'form' => $form
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

    #[Route('/panier/del/{plat}', name: 'app_panier')]
    public function delplat(SessionInterface $session, PlatRepository $repo, Request $request): Response
    {
        $referer = $request->headers->get('referer');

        return $this->redirect("$referer");
    }

    #[Route('/panier/delpanier', name: 'app_delpanier')]
    public function panierdel(SessionInterface $session, Request $request): Response
    {
        $referer = $request->headers->get('referer');
        $session->set("panier", []);
        return $this->redirect("$referer");
    }
    
    #[Route('/panier', name: 'app_panier')]
    public function panier(SessionInterface $session, PlatRepository $repo): Response
    {
        
        $total_panier=0;
        $panier = $session->get("panier", []);

        $nouveau_panier = [];
        foreach ($panier as $key => $value) {
            $p = $repo->find($key);
            $nouveau_panier[] = $p;
            $total_panier+=$p->getPrix()*$value;
        }
        return $this->render('panier/panier.html.twig', [
            'panier' => $panier,
            'nouveau_panier' => $nouveau_panier,
            'total_panier' => $total_panier,
        ]);
    }
    #[Route('/panierconfirm', name: 'app_panierconfirm')]
    public function confirmcde(SessionInterface $session, Detail $detail, Request $request)
    {
        
    }
    
}
