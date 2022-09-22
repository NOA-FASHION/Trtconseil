<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Recruteur;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Recruteur>
 *
 * @method Recruteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recruteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recruteur[]    findAll()
 * @method Recruteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecruteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recruteur::class);
    }

    public function add(Recruteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Recruteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // public function findRecruteursFromUser(User $user): array

    // {

    //     $queryBuilder = $this->createQueryBuilder('m')

    //         ->join('m.userRecrutueur', 'u')

    //         ->where('u.email = :email')

    //         ->setParameter('email', $user->getEmail())

    //     ;


    //     $query = $queryBuilder->getQuery();


    //     return $query->getResult();

    // }

//    /**
//     * @return Recruteur[] Returns an array of Recruteur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Recruteur
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
