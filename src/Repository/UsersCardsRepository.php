<?php

namespace App\Repository;

use App\Entity\UsersCards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersCards>
 *
 * @method UsersCards|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersCards|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersCards[]    findAll()
 * @method UsersCards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersCardsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersCards::class);
    }

//    /**
//     * @return UsersCards[] Returns an array of UsersCards objects
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

//    public function findOneBySomeField($value): ?UsersCards
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
