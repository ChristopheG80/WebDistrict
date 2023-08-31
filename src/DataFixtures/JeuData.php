<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Plat;
use App\Entity\Utilisateur;
use Symfony\Component\Clock\Clock;
use Symfony\Component\Clock\MockClock;


class JeuData extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        Clock::set(new MockClock());
        $clock = Clock::get();
        $now = $clock->now();

        $cat1 = new Categorie();
        $cat1->setLibelle('Burger');
        $cat1->setImage('burger_cat.jpg');
        $cat1->setActive(true);

        $cat2 = new Categorie();
        $cat2->setLibelle('Pizza');
        $cat2->setImage('pizza_cat.jpg');
        $cat2->setActive(true);

        $cat3 = new Categorie();
        $cat3->setLibelle('Pasta');
        $cat3->setImage('pasta_cat.jpg');
        $cat3->setActive(true);

        $cat4 = new Categorie();
        $cat4->setLibelle('Wraps');
        $cat4->setImage('wraps_cat.jpg');
        $cat4->setActive(true);

        $cat5 = new Categorie();
        $cat5->setLibelle('Salade');
        $cat5->setImage('salade_cat.jpg');
        $cat5->setActive(true);

        $cat6 = new Categorie();
        $cat6->setLibelle('Veggie');
        $cat6->setImage('veggie_cat.jpg');
        $cat6->setActive(true);

        $cat7 = new Categorie();
        $cat7->setLibelle('Sandwich');
        $cat7->setImage('sandwich_cat.jpg');
        $cat7->setActive(true);

        $cat8 = new Categorie();
        $cat8->setLibelle('AsianFood');
        $cat8->setImage('asian_food_cat.jpg');
        $cat8->setActive(false);

        $plat1 = new Plat();
        $plat1->setLibelle('District Burger');
        $plat1->setDescription('Burger composé d’un bun’s du boulanger, deux steaks de 80g (origine française), de deux tranches poitrine de porc fumée, de deux tranches cheddar affiné, salade et oignons confits.');
        $plat1->setPrix(8.00);
        $plat1->setImage('hamburger.png');
        $plat1->setCategorie($cat1);
        $plat1->setActive(true);

        $plat2 = new Plat();
        $plat2->setLibelle('Cheeseburger');
        $plat2->setDescription('Burger composé d’un bun’s du boulanger, de salade, oignons rouges, pickles, oignon confit, tomate, d’un steak d’origine Française, d’une tranche de cheddar affiné, et de notre sauce maison.');
        $plat2->setPrix(8.00);
        $plat2->setImage('pizza-margherita.png');
        $plat2->setCategorie($cat1);
        $plat2->setActive(true);

        $plat3 = new Plat();
        $plat3->setLibelle('Pizza Bianca');
        $plat3->setDescription('Une pizza fine et croustillante garnie de crème mascarpone légèrement citronnée et de tranches de saumon fumé, le tout relevé de baies roses et de basilic frais.');
        $plat3->setPrix(14.00);
        $plat3->setImage('pizza-bianca.png');
        $plat3->setCategorie($cat2);
        $plat3->setActive(true);

        $plat4 = new Plat();
        $plat4->setLibelle('Pizza Margherita');
        $plat4->setDescription('Une authentique pizza margarita, un classique de la cuisine italienne! Une pâte faite maison, une sauce tomate fraîche, de la mozzarella Fior di latte, du basilic, origan, ail, sucre, sel & poivre...');
        $plat4->setPrix(14.00);
        $plat4->setImage('pizza-margherita.png');
        $plat4->setCategorie($cat2);
        $plat4->setActive(true);

        $plat5 = new Plat();
        $plat5->setLibelle('Spaghetti aux légumes');
        $plat5->setDescription('Un plat de spaghetti au pesto de basilic et légumes poêlés, très parfumé et rapide.');
        $plat5->setPrix(10.00);
        $plat5->setImage('spaghetti-legumes.png');
        $plat5->setCategorie($cat3);
        $plat5->setActive(true);

        $plat6 = new Plat();
        $plat6->setLibelle('Lasagnes');
        $plat6->setDescription('Découvrez notre recette des lasagnes, l\’une des spécialités italiennes que tout le monde aime avec sa viande hachée et gratinée à l\’emmental. Et bien sûr, une inoubliable béchamel à la noix de muscade.');
        $plat6->setPrix(12.00);
        $plat6->setImage('lasagnes_viande.png');
        $plat6->setCategorie($cat3);
        $plat6->setActive(true);

        $plat7 = new Plat();
        $plat7->setLibelle('Tagliatelles au saumon');
        $plat7->setDescription('Découvrez notre recette délicieuse de tagliatelles au saumon frais et à la crème qui vous assure un véritable régal !');
        $plat7->setPrix(12.00);
        $plat7->setImage('tagliatelles_saumon.png');
        $plat7->setCategorie($cat3);
        $plat7->setActive(true);

        $plat8 = new Plat();
        $plat8->setLibelle('Buffalo Chicken Wrap');
        $plat8->setDescription('Du bon filet de poulet mariné dans notre spécialité sucrée & épicée, enveloppé dans une tortilla blanche douce faite maison.');
        $plat8->setPrix(5.00);
        $plat8->setImage('buffalo-chicken.png');
        $plat8->setCategorie($cat4);
        $plat8->setActive(true);

        $plat9 = new Plat();
        $plat9->setLibelle('Salade César');
        $plat9->setDescription('Une délicieuse salade Caesar (César) composée de filets de poulet grillés, de feuilles croquantes de salade romaine, de croutons à l’ail, de tomates cerise et surtout de sa fameuse sauce Caesar. Le tout agrémenté de copeaux de parmesan.');
        $plat9->setPrix(7.00);
        $plat9->setImage('cesar_salad.png');
        $plat9->setCategorie($cat5);
        $plat9->setActive(true);

        $plat10 = new Plat();
        $plat10->setLibelle('Courgettes farcies au quinoa et champignon');
        $plat10->setDescription('Voici une recette équilibrée à base de courgettes, quinoa et champignons, 100% vegan et sans gluten !');
        $plat10->setPrix(8.00);
        $plat10->setImage('courgettes_farcies.png');
        $plat10->setCategorie($cat6);
        $plat10->setActive(true);

        $user1 = new Utilisateur();
        $user1->setPassword('1234');
        $user1->setEmail('alibaba@gmail.com');
        $user1->setNom('Baba');
        $user1->setPrenom('Ali');
        $user1->setAdresse('12 grande rue');
        $user1->setCp('80000');
        $user1->setVille('Amiens');
        $user1->setTelephone('0322446677');
        $user1->setRoles(['ROLE_CLIENT']);

        $user2 = new Utilisateur();
        $user2->setPassword('456789');
        $user2->setEmail('johndoe@gmail.com');
        $user2->setNom('Doe');
        $user2->setPrenom('John');
        $user2->setAdresse('14 grande rue');
        $user2->setCp('80000');
        $user2->setVille('Amiens');
        $user2->setTelephone('0322445577');
        $user2->setRoles(['ROLE_CLIENT']);

        $cmd1 = new Commande();
        $cmd1->setDateCommande($now);
        $det1 = new Detail();
        $det1->setCommande($cmd1);
        $det1->setPlat($plat4);
        $det1->setQuantite(2);
        $tot1 = $plat4->getPrix() * $det1->getQuantite();
        $det2 = new Detail();
        $det2->setCommande($cmd1);
        $det2->setPlat($plat3);
        $det2->setQuantite(3);
        $tot1 += $plat3->getPrix() * $det2->getQuantite();
        $cmd1->setTotal($tot1);
        $cmd1->setEtat(0);
        $cmd1->setUtilisateur($user2);
        

        $cmd2 = new Commande();
        $cmd2->setDateCommande($now);
        $det3 = new Detail();
        $det3->setCommande($cmd2);
        $det3->setPlat($plat7);
        $det3->setQuantite(1);
        $tot2 = $plat7->getPrix() * $det3->getQuantite();
        $det4 = new Detail();
        $det4->setCommande($cmd2);
        $det4->setPlat($plat2);
        $det4->setQuantite(3);
        $tot2 += $plat2->getPrix() * $det4->getQuantite();
        $cmd2->setTotal($tot2);
        $det6 = new Detail();
        $det6->setCommande($cmd2);
        $det6->setPlat($plat8);
        $det6->setQuantite(3);
        $tot2 += $plat2->getPrix() * $det6->getQuantite();
        $det7 = new Detail();
        $det7->setCommande($cmd2);
        $det7->setPlat($plat9);
        $det7->setQuantite(3);
        $tot2 += $plat2->getPrix() * $det7->getQuantite();
        $det8 = new Detail();
        $det8->setCommande($cmd2);
        $det8->setPlat($plat10);
        $det8->setQuantite(3);
        $tot2 += $plat2->getPrix() * $det8->getQuantite();
        $cmd2->setEtat(0);
        $cmd2->setUtilisateur($user1);


        $cmd3 = new Commande();
        $cmd3->setDateCommande($now);
        $det5 = new Detail();
        $det5->setCommande($cmd3);
        $det5->setPlat($plat6);
        $det5->setQuantite(2);
        $tot3 = $plat6->getPrix() * $det5->getQuantite();
        $cmd3->setTotal($tot3);
        $cmd3->setEtat(0);
        $cmd3->setUtilisateur($user1);

        $manager->persist($cat1);
        $manager->persist($cat2);
        $manager->persist($cat3);
        $manager->persist($cat4);
        $manager->persist($cat5);
        $manager->persist($cat6);
        $manager->persist($cat7);
        $manager->persist($cat8);

        $manager->persist($plat1);
        $manager->persist($plat2);
        $manager->persist($plat3);
        $manager->persist($plat4);
        $manager->persist($plat5);
        $manager->persist($plat6);
        $manager->persist($plat7);
        $manager->persist($plat8);
        $manager->persist($plat9);
        $manager->persist($plat10);

        $manager->persist($cmd1);
        $manager->persist($cmd2);
        $manager->persist($cmd3);
        
        $manager->persist($user1);
        $manager->persist($user2);
        
        $manager->persist($det1);
        $manager->persist($det2);
        $manager->persist($det3);
        $manager->persist($det4);
        $manager->persist($det5);
        $manager->persist($det6);
        $manager->persist($det7);
        $manager->persist($det8);

        $manager->flush();
    }
}
