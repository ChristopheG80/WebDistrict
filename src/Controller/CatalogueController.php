<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(): Response
    {
        // $categories = $this->categorieRepo->findAll();
        $categories = $this->categorieRepo->ShowCat6Pop();
        $plats = $this->platRepo->showHomePlats();
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories' => $categories,
            'plats' => $plats
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

    #[Route('/categories', name: 'app_catalogue_cats')]
    public function showCats(): Response
    {
        // $categories = $this->categorieRepo->ShowCat6Pop();
        $page=1;
        $limit=6;
        $categories = $this->categorieRepo->findCatPaginated($page, $limit);
        return $this->render('catalogue/showCats.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories' => $categories
        ]);
    }
}
