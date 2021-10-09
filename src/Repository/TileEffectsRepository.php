<?php

namespace App\Repository;

use App\Entity\TileEffects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TileEffects|null find($id, $lockMode = null, $lockVersion = null)
 * @method TileEffects|null findOneBy(array $criteria, array $orderBy = null)
 * @method TileEffects[]    findAll()
 * @method TileEffects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TileEffectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TileEffects::class);
    }
    
    public function findEffectsByTypeTile(string $type) {
        return $this->createQueryBuilder('t')
            ->andWhere('t.type = :type')
               ->setParameter('type', $type)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return TileEffects[] Returns an array of TileEffects objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TileEffects
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
