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

    public function findByUserID($usr_id): array
    {
        return $this->createQueryBuilder('uc')
            ->andWhere('uc.uc_usr = :id')
            ->setParameter('id', $usr_id)
            ->getQuery()
            ->getResult()
        ;
    }
}
