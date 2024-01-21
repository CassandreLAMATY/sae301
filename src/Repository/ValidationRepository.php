<?php

namespace App\Repository;

use App\Entity\Validation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Validation>
 *
 * @method Validation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Validation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Validation[]    findAll()
 * @method Validation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValidationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Validation::class);
    }

    public function findByCardId($crd_id): array
    {
        return $this->createQueryBuilder('val')
            ->innerJoin('val.val_crd', 'v')
            ->addSelect('v')
            ->andWhere('v.crd_id = :id')  // Adjusted from val.val_usr to v.crd_id
            ->setParameter('id', $crd_id)
            ->orderBy('v.crd_to', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Validation[] Returns an array of Validation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Validation
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
