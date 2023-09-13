<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Mailer\MailerInterface;

class AppFixtures extends Fixture
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
