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
    public function deactivateAllCats()
    {
        return $this->createQueryBuilder('c')
            ->update('App:Cat', 'c')
            ->set('c. isActive', 0)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @return mixed
     */
    public function resetViewedCount()
    {
        return $this->createQueryBuilder('c')
            ->update('App:Cat', 'c')
            ->set('c. viewedCount', 0)
            ->getQuery()
            ->execute()
        ;
    }

}
