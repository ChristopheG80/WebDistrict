<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BarreRechercheType;



class CatalogueController extends AbstractController
{
    private $categorieRepo;
    private $platRepo;
    private $mailer;

    public function __construct(CategorieRepository $categorieRepo, PlatRepository $platRepo, MailerInterface $mailer)
    {
        $this->categorieRepo = $categorieRepo;
        $this->platRepo = $platRepo;
        $this->mailer = $mailer;
    }


    #[Route('/', name: 'app_main')]
    public function main()
    {
        return $this->redirectToRoute('app_catalogue');
    }

    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(BarreRechercheType::class);
        $form->handleRequest($request);
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $platsRec = $this->platRepo->ShowPlatsRec($data['textSearch']);
            $categRec = $this->categorieRepo->ShowCatRec($data['textSearch']);

            //dd($data);
            return $this->render('barre_recherche/index.html.twig', [
                'controller_name' => 'CatalogueController',
                'categories' => $categRec,
                'plats' => $platsRec,
            ]);
        }
        // $categories = $this->categorieRepo->findAll();
        $categories = $this->categorieRepo->ShowCat6Pop();
        $plats = $this->platRepo->showHomePlats();
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories' => $categories,
            'plats' => $plats,
            'form' => $form
        ]);
    }

    #[Route('/plats', name: 'app_catalogue_plats')]
    public function showPlats(): Response
    {
        $plats = $this->platRepo->showAllPlats();
        return $this->render('catalogue/showPlats.html.twig', [
            'controller_name' => 'CatalogueController',
            'plats' => $plats
        ]);
    }

    #[Route('/plats/{categorie_id}', name: 'app_catalogue_CatPlats')]
    public function showCatPlats($categorie_id): Response
    {

        $plats = $this->categorieRepo->ShowPlatbyCat($categorie_id);
        $cats = $this->categorieRepo->ShowOneCat($categorie_id);
        //dd($plats);
        return $this->render('catalogue/showCatPlats.html.twig', [
            'controller_name' => 'CatalogueController',
            'plats' => $plats,
            'cats' => $cats
        ]);
    }

    #[Route('/categories/{page}', name: 'app_catalogue_cats')]
    public function showCats(int $page = 1): Response
    {
        $limit = 6;
        $categories = $this->categorieRepo->findCatPaginated($page, $limit);
        $pages=$this->categorieRepo->countAllCat();
        //dd($categories);
        $pages=ceil($pages[0][1]/$limit);
        //  dd($pages);
        return $this->render('catalogue/showCats.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories' => $categories,
            'pages' => $pages
        ]);
    }
    #[Route('/barre/recherche', name: 'app_barre_recherche')]
    public function searchBar(Request $request): Response
    {
        $form = $this->createForm(BarreRechercheType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        }
        return $this->render('barre_recherche/index.html.twig', [
            'controller_name' => 'BarreRechercheController',
            'form' => $form
        ]);
    }
}
