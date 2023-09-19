<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Detail;
use App\Entity\Commande;
use App\Entity\Contact;
use App\Repository\PlatRepository;
use App\Service\MailService;
//use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
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
        $panier = $session->get("panier", []);
        $referer = $request->headers->get('referer');
        
        if (isset($panier[$plat->getId()])) {
            $panier[$plat->getId()]++;
        } else {
            $panier[$plat->getId()] = 1;
        }
        $session->set("panier", $panier);
        return $this->redirect("$referer");
    }

    #[Route('/panier/delete/{plat}', name: 'app_panier_delete')]
    public function delplat(SessionInterface $session, PlatRepository $repo, Request $request, Plat $plat): Response
    {
        $panier = $session->get("panier");
        $referer = $request->headers->get('referer');
        $panier2=array();
        foreach($panier as $key => $value){
            if($key != $plat->getId()){
                $panier2 += [$key=>$value];
            }
            
        }
        $panier = $panier2;
        $session->set("panier", $panier);
        return $this->redirect("$referer");
    }

    #[Route('/panier/retrait/{plat}', name: 'app_panier_retrait')]
    public function retrait(SessionInterface $session, PlatRepository $repo, Request $request, Plat $plat): Response
    {
        $panier = $session->get("panier");
        $panier2=array();
        if($panier[$plat->getId()] > 0){
            $panier[$plat->getId()]--;
        }
        else{
            foreach($panier as $key => $value){
                if($value>0){
                    $panier2 += [$key=>$value];
                }
            }
            $panier=$panier2;    
        }
        $referer = $request->headers->get('referer');
        $session->set("panier", $panier);
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
    public function confirmcde(
        SessionInterface $session, 
        Detail $detail, 
        Commande $commande, 
        PlatRepository $repo, 
        Request $request, 
        EntityManagerInterface $entityManager,
        MailService $mailer)
    {
        // $detail = new Detail();
        // $commande = new Commande();
        $total_panier=0;
        $panier=$session->get("panier", []);
        $nouveau_panier = [];

        //Ajouter dans Commande
        $date = Date("Y-m-d h:i:s");
        $commande->setDateCommande($date);
        $commande->setLivAdresse('adresse');
        $commande->setLivCp(60000);
        $commande->setLivVille('Beauvais');
        $commande->setLivTelephone('0322334455');
        $idCommande=$this->$commande->getId();

        // Ajouter des Détail        
        foreach ($panier as $key => $value) {
            $p = $repo->find($key);
            $nouveau_panier[] = $p;
            $this->$detail->setPlat($key);
            $this->$detail->setQuantite($value);
            $this->$detail->setCommande($idCommande);
            $total_panier+=$p->getPrix()*$value;
        }
        
        $this->$commande->setTotal($total_panier);
        $this->$commande->setEtat(0);

        // Envoyer un mail de confirmation de la commande
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $message = new Contact();
        $data = $form->getData();
        $message = $data;

        $entityManager->persist($message);
        $entityManager->flush();
        $oo = strval($message->getObjet());
        $ee = strval($message->getEmail());
        $mm = strval($message->getMessage());
            //dd($oo,$ee,$mm);
        $mailer->sendMail($oo, $ee, $mm);
        }
    }



}
