<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\{Character, Monster, Adventure, Tile, MonsterType, TileEffects};

class CharacterController extends AbstractController
    {
    public function postMoveAction(Character $character): Response
    {
        $em = $this->getDoctrine()->getManager();

        $adventure = $this->getDoctrine()->getRepository(Adventure::class)->findAdventureByCharacter($character);
        $character = $this->getDoctrine()->getRepository(Character::class)->findOneById($character);
        $tile = $this->getDoctrine()->getRepository(Tile::class)->findById($adventure[0]->getTile()->getId());
        $tileEffects = $this->getDoctrine()->getRepository(TileEffects::class)->findById($tile[0]->getEffects()->getId());
        $monster = $this->getDoctrine()->getRepository(Monster::class)->findById($tile[0]->getMonster()->getId());

        $monsterRoaming = $monster[0]->getLife() !== 0;
        
        /* if monster still alive, monster attacks */
        if ($monsterRoaming) {

            /* set special effect */
            $specialEffects = $monster[0]->getType() === $tileEffects[0]->getEffectTarget();
            if ($specialEffects) {
                $isStronger = $monster[0]->getAttack() + $tileEffects[0]->getEffectValue();
                $monster[0]->setAttack($isStronger);
            }

            $monsterAttack      = $monster[0]->getAttack();
            $characterShielding = $character->getShielding();
            $characterLife      = $character->getLife();

            /* set Character damages */
              /* launch dice method missing */
            if ($monsterAttack > $characterShielding) {
                $remainingLife = $characterLife - ($monsterAttack - $characterShielding);
                $character->setLife($remainingLife);
            }
            
            /* persist the entities updated */
            $em->persist($monster[0]);
            $em->persist($character);
            $em->flush();

            /* test game over */
            if ($characterLife <= 0) {
                /* adventure.end */
                dump('Game Over');die;
            }         
        }
        
        /* character moves, a new tile is created and added to this adventure */

        /* create a monster to assigned to the new tile */
        $monster = new Monster();
        $monsterType = ['ork', 'gobelin', 'ghost', 'troll'];
        $monsterType = $monsterType[array_rand($monsterType, 1)];
        $monsterType = $this->getDoctrine()->getRepository(MonsterType::class)->findMonsterByType($monsterType);
        $monster->setType($monsterType->getType());
        $monster->setLife($monsterType->getLife());
        $monster->setAttack($monsterType->getAttack());
        $monster->setShielding($monsterType->getShielding());
        $em->persist($monster);
        $em->flush();

        // create tile
        $tile = new Tile();
        $tileType = ['grasslands', 'hills', 'forest', 'mountains', 'desert', 'swamp'];
        $tile->setType($tileType[array_rand($tileType, 1)]);
        // set effects
        $effects = $this->getDoctrine()->getRepository(TileEffects::class)->findEffectsByTypeTile($tile->getType());
        $tile->setEffects($effects);
        // set monster
        $tile->setMonster($monster);
        $em->persist($tile);
        $em->flush();

        // add the new tile to the adventure of the character 
        $adventure = $this->getDoctrine()->getRepository(Adventure::class)->findAdventureByCharacter($character);
        $adventure[0]->addTile($tile);
        dump($adventure);die;

    }

    public function postAttackAction($character): Response
    {
        return $this->json([
            'damage points' => $character
        ]);
    }

    public function postRestAction($character): Response
    {
        return $this->json([
            'time of the nap' => $character
        ]);
    }

    public function getCharacterAction(Character $character): Response
    {
        $character = $this->getDoctrine()->getRepository(Character::class)->findById($character);
        dump($character);die;
    }
}