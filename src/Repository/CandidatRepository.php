<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Candidat;
use App\Entity\Candidature;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Candidat>
 *
 * @method Candidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidat[]    findAll()
 * @method Candidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidat::class);
    }

    public function add(Candidat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Candidat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findAllCandidatforUser()
    {
        return $this->createQueryBuilder('c')
           
            ->addSelect('u as USER')
            ->join('c.userCandidat', 'u')
            -> select('u.email','c.name','c.activation','c.id','c.lastname')
            ->getQuery()
            ->getResult()
        ;
    }

  

    public function findAllCandidatforAnnonce(Annonce $annonce)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('u as USER')
            ->join('c.annonces', 'a')
            ->join('c.userCandidat', 'u')
            ->where('a = :annonce')
            ->setParameter('annonce', $annonce)
            -> select('u.email','c.name' ,'c.id','c.cvLien','a.intitulePoste')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findCandidatforAnnonce(Annonce $annonce,int $id)
    {
        return $this->createQueryBuilder('c')
            ->join('c.annonces', 'a')
            ->where('a = :annonce')
            ->andWhere('c.id = :id')
            ->setParameter('annonce', $annonce)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return Candidat[] Returns an array of Candidat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Candidat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
