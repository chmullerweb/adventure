<?php
namespace App\Manager;

use App\Entity\Character;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;


class CharacterManager
{
    protected $em;
    protected $repository;

    public function __construct(EntityManager $em)
    {
        $this->setEntityManager($entityManager);
    }

    public function createCharacter(Character $character)
    {
        dump('ok');die;
        $character = new Character();
        $character->setLife(20);
        $character->setAttack(12);
        $character->setSchielding(5);
        $em->persist($character);
        $em->flush();
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

}