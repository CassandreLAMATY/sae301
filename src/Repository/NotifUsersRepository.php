<?php

namespace App\Repository;

use App\Entity\NotifUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotifUsers>
 *
 * @method NotifUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotifUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotifUsers[]    findAll()
 * @method NotifUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotifUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotifUsers::class);
    }

    public function findByUserID($usr_id): array
    {
        return $this->createQueryBuilder('nu')
            ->andWhere('nu.nu_usr = :id')
            ->setParameter('id', $usr_id)
            ->orderBy('nu.nu_id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
