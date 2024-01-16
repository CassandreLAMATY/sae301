<?php

namespace App\Repository;

use App\Entity\Notifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notifications>
 *
 * @method Notifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notifications[]    findAll()
 * @method Notifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notifications::class);
    }

    public function findById($id): array
    {
        $notifications = [];
        foreach ($id as $notifId) {
            $_notifications = $this->createQueryBuilder('n')
                ->andWhere('n.not_id = :id')
                ->setParameter('id', $notifId)
                ->getQuery()
                ->getResult()
            ;

            $notifications[] = $_notifications[0];
        }

        return $notifications;
    }

}
