<?php

namespace App\Repository;

use App\Entity\UsersValidation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersValidation>
 *
 * @method UsersValidation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersValidation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersValidation[]    findAll()
 * @method UsersValidation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersValidationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersValidation::class);
    }

    public function findByCardId($crd_id): array
    {
        return $this->createQueryBuilder('uv')
            ->innerJoin('uv.uv_crd', 'v')
            ->addSelect('v')
            ->andWhere('uv.uv_crd = :id')
            ->setParameter('id', $crd_id)
            ->orderBy('v.crd_to', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByUserIdNotOutdated($usr_id): array
    {
        return $this->createQueryBuilder('uv')
            ->innerJoin('uv.uv_crd', 'v')
            ->addSelect('v')
            ->andWhere('uv.uv_usr = :id')
            ->setParameter('id', $usr_id)
            ->andWhere('v.crd_to >= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('v.crd_to', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return UsersValidation[] Returns an array of UsersValidation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UsersValidation
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
