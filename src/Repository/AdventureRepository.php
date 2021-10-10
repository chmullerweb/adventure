<?php

namespace App\Repository;

use App\Entity\{Character, Adventure, Tile, TileEffects, Monster, MonsterType};
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adventure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adventure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adventure[]    findAll()
 * @method Adventure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdventureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adventure::class);
    }

    public function getAdventureItems(Tile $tile)
    {
        $q = $this->createQueryBuilder('a')
        ->select('a')
        ->where('a.tile_id = :tile_id')
            ->setParameter('tile_id', $tile->getId())
        ;
        return $q->getQuery()->getResult();

    }

    public function findAdventureByCharacter(Character $character)
    {
        $q = $this->createQueryBuilder('a')
        ->select('a')
        ->where('a.character = :character')
            ->setParameter('character', $character->getId())
        ;
        return $q->getQuery()->getResult();
    }

    // /**
    //  * @return Adventure[] Returns an array of Adventure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Adventure
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
