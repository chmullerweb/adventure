<?php
namespace App\Manager;

use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;


class CharactersManager
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em          = $em;
    }

    public function createCharacter(Character $character)
    {
        $character = new Character();
        $character->setLife(20);
        $character->setAttack(12);
        $character->setSchielding(5);
        return $character;
    }

}