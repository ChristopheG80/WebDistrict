<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Stringable;
use Symfony\component\Mailer\MailerInterface;


/**
 * @extends ServiceEntityRepository<Plat>
 *
 * @method Plat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plat[]    findAll()
 * @method Plat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatRepository extends ServiceEntityRepository
{
    private $mailer;
    public function __construct(ManagerRegistry $registry, MailerInterface $mailer)
    {
        parent::__construct($registry, Plat::class);
        $this->mailer = $mailer;
    }

    /**
     * @return Plat[] Returns an array of Plat objects
     */
    public function showHomePlats(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.libelle, p.image, p.description, p.prix')
            ->where('p.active = :val')
            ->setParameter('val', 1)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function showAllPlats(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.libelle, p.image, p.description, p.prix')
            ->where('p.active = :val')
            ->setParameter('val', 1)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneById($value): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->where('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function ShowPlatsRec($Rec): array
    {
        return $this->createQueryBuilder('p')
        ->select('p.id, p.libelle, p.image, p.description, p.prix')
        ->where('p.libelle LIKE :val')
            ->setParameter('val', '%' . $Rec .'%')
        ->orWhere('p.description LIKE :val2')
            ->setParameter('val2', '%' . $Rec .'%')
        ->andWhere('p.active = :val')
            ->setParameter('val', 1)
        ->orderBy('p.id', 'ASC')
        ->getQuery()
        ->getResult();
    }
}
