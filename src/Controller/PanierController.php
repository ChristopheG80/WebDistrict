<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Detail;
use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Entity\Contact;
use App\Form\LivraisonpanierType;
use App\Repository\PlatRepository;
use App\Service\MailService;
//use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
        $panier2 = array();
        foreach ($panier as $key => $value) {
            if ($key != $plat->getId()) {
                $panier2 += [$key => $value];
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
        $panier2 = array();
        if ($panier[$plat->getId()] > 0) {
            $panier[$plat->getId()]--;
        } else {
            foreach ($panier as $key => $value) {
                if ($value > 0) {
                    $panier2 += [$key => $value];
                }
            }
            $panier = $panier2;
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

        $total_panier = 0;
        $panier = $session->get("panier", []);

        $nouveau_panier = [];
        foreach ($panier as $key => $value) {
            $p = $repo->find($key);
            $nouveau_panier[] = $p;
            $total_panier += $p->getPrix() * $value;
        }
        return $this->render('panier/panier.html.twig', [
            'panier' => $panier,
            'nouveau_panier' => $nouveau_panier,
            'total_panier' => $total_panier,
        ]);
    }





    #[Route('/panierlivraison', name: 'app_panierlivraison')]
    public function confirmlivraison(Request $request, EntityManagerInterface $entityManager, MailService $mailer, Session $session)
    {

        $form = $this->createForm(LivraisonpanierType::class);
        $form->handleRequest($request);
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd('Commande envoyée');
            $date = date_create_immutable();
            $commande = new Commande();
            $message = new Contact();
            $details= new Detail();
            $plats= new Plat();
            $panier = $session->get("panier");

            foreach($panier as $key => $value){
                //dd($key, $value);
                $details->setQuantite($value);
                $details->setPlat($plats->getId($key));
                dump($details, $plats->getId());
            }
//dd('fin du each');
            $data = $form->getData();
            //dd($data, $data['hiddenDate']);
            $message = $data;
            $commande->setLivAdresse($data['adresseLiv']);
            $commande->setLivCp($data['cpLiv']);
            $commande->setLivVille($data['villeLiv']);
            $commande->setfactAdresse($data['adresse']);
            $commande->setfactCp($data['cp']);
            $commande->setfactVille($data['ville']);
            $commande->setDateCommande($date);
            $commande->setLivTelephone($data['telephone']);
            $commande->setTotal(0);
            $commande->setEtat(0);
            $commande->addDetail($panier);
            dd($commande);

            //dd($message->getObjet(),$message->getEmail(),$message->getMessage());
            $oo = "Confimation de commande";
            $ee = $data['email'];
            $mm = "Vous allez recevoir votre commande à l'adresse suivante:";
            $mm .= $data['prenom'] . " " . $data['nom'];
            $mm .= $data['adresse'];
            $mm .= $data['cpLiv'] . " " . $data['villeLiv'];
            $mm .= $data['telephone'] . " pour vous joindre";
            dd($mm);

            //dd($oo,$ee,$mm);
            $mailer->sendMail($oo, $ee, $mm);

            $entityManager->persist($message);
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_panier');
        }
        return $this->render('panier/delivery.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form,
            // 'panier' => $panier,
            // 'nouveau_panier' => $nouveau_panier,
            // 'total_panier' => $total_panier,
        ]);
    }










    #[Route('/panierconfirm', name: 'app_panierconfirm')]
    public function confirmcde(
        SessionInterface $session,
        PlatRepository $repo,
        Request $request,
        EntityManagerInterface $entityManager,
        MailService $mailer
    ) {
        // $detail = new Detail();
        // $commande = new Commande();
        $total_panier = 0;
        $panier = $session->get("panier", []);
        $nouveau_panier = [];

        //Ajouter dans Commande
        $commande = new Commande();
        $date = date_create_immutable();
        $commande->setDateCommande($date);
        $commande->setLivAdresse('adresse');
        $commande->setLivCp(80000);
        $commande->setLivVille('Amiens');
        $commande->setLivTelephone('0322334455');
        $commande->setTotal(0);
        $commande->setEtat(0);
        $entityManager->persist($commande);

        //dd($commande);


        // $entityManager->persist($commande);
        //dd($commande);


        // $entityManager->flush();

        //$idCommande = $commande->getId();
        //dd($idCommande);

        // Ajouter des lignes pour Détail
        foreach ($panier as $key => $value) {

            $detail = new Detail();

            $p = $repo->find($key);
            //dd($p);
            $nouveau_panier[] = $p;
            // dump($key, $value, $idCommande, $p);
            // dd('fin');

            $detail->setPlat($p);
            $detail->setCommande($commande);

            $detail->setQuantite($value);

            $total_panier += $p->getPrix() * $value;

            $entityManager->persist($detail);
        }

        $commande->setTotal($total_panier);

        $entityManager->flush();


        // dd($total_panier);
        // dd($key, $value, $detail);

        //dd($commande);
        // Envoyer un mail de confirmation de la commande
        $form = $this->createForm(LivraisonpanierType::class);
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

        $entityManager->flush();
    }
}
