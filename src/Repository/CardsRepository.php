<?php

namespace App\Repository;

use App\Entity\Cards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cards>
 *
 * @method Cards|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cards|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cards[]    findAll()
 * @method Cards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardsRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Cards::class);
    }

    public function findLastCard(): ?Cards
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.crd_id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
