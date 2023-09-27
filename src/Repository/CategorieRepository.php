<?php

namespace App\Repository;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categorie;
use Symfony\component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManager;



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
    private $mailer;
    public function __construct(ManagerRegistry $registry, MailerInterface $mailer)
    {
        parent::__construct($registry, Categorie::class);
        $this->mailer = $mailer;
    }

    public function findCatPaginated($page = 1, $limit = 3)
    {
        //, EntityManager $entityManager
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

    public function ShowPlatbyCat(int $cat)
    {
        
        //dd($cat);
        $entityManager = $this->getEntityManager();
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.libelle, c.image AS titimage, p.libelle, p.id, p.prix, p.description, p.image')
            ->join('c.plats', 'p')
            ->where('c.id = :val1')
            ->setParameter('val1',$cat)
            
            ->getQuery();
        return $query->getResult();
    }

    public function ShowOneCat(int $cat)
    {
        //dd($cat);
        $entityManager = $this->getEntityManager();
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.libelle, c.image')
            ->where('c.id = :val1')
            ->andWhere('c.active = :val')
            ->setParameter('val', 1)
            ->setParameter('val1',$cat)
            ->getQuery();
        return $query->getResult();
    }
    
    public function ShowCatRec(string $Rec)
    {
        //dd($cat);
        //$entityManager = $this->getEntityManager();
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.libelle, c.image')
            ->where('c.libelle LIKE :val1')
            ->setParameter('val1','%' . $Rec .'%')
            ->andWhere('c.active = :val')
            ->setParameter('val', 1)
            ->getQuery();
            //dd($query);
        return $query->getResult();
    }
    public function countAllCat()
    {
        //dd($cat);
        //$entityManager = $this->getEntityManager();
        $query = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.active = :val')
            ->setParameter('val', 1)
            ->getQuery();
            //dd($query);
        return $query->getResult();
    }

}
