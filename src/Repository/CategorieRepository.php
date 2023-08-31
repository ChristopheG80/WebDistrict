<?php

namespace App\Repository;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categorie;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function findCatPaginated($page = 1, $limit = 6)
    {
        
        $limit = abs($limit);
        $first = ($page - 1) * $limit;
        $entityManager = $this->getEntityManager();
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.libelle, c.image')
            ->where('c.active = :val')
            ->setParameter('val', 1)
            ->setMaxResults($limit)
            ->setFirstResult($first)
            ->getQuery();
            // dd($query);
            
        return $query->getResult();
    }

    //    /**
    //     * @return Categorie[] Returns an array of Categorie objects
    //     */
    public function ShowCat6Pop(int $limit = 6)
    {
        $entityManager = $this->getEntityManager();
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.libelle, c.image, SUM(d.quantite) AS qteCde')
            // ->from('categorie', 'c')
            ->join('c.plats', 'p')
            ->join('p.details', 'd')
            ->where('c.active = :val')
            ->setParameter('val', 1)
            ->andWhere('p.active = :val2')
            ->setParameter('val2', 1)
            ->groupBy('c.id')
            ->orderBy('qteCde', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
        //dd($query);
        return $query->getResult();
    }

    //    public function findOneBySomeField($value): ?Categorie
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
