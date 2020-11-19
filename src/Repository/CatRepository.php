<?php

namespace App\Repository;

use App\Entity\Cat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cat[]    findAll()
 * @method Cat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cat::class);
    }

    /**
     * @return mixed
     */
    public function deactivateAllCats() : int
    {
        return $this->createQueryBuilder('c')
            ->update('App:Cat', 'c')
            ->set('c.isActive', 0)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @return mixed
     */
    public function resetViewedCount() : int
    {
        return $this->createQueryBuilder('c')
            ->update('App:Cat', 'c')
            ->set('c.viewedCount', 0)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @param int $number
     * @return mixed
     */
    public function getLeastSeenCats(int $number) : array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.viewedCount', 'ASC')
            ->setMaxResults($number)
            ->getQuery()
            ->execute()
            ;
    }


    public function getScoring() : array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.votedCount', 'DESC')
            ->getQuery()
            ->execute()
            ;
    }
}
