<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\{Character, Monster, Adventure, Tile, MonsterType, TileEffects};
use Symfony\Component\Serializer\Serializer;

class CharacterController extends AbstractController
    {

    public function postMoveAction(Request $request, Character $character): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        $adventure = $this->getDoctrine()->getRepository(Adventure::class)->findAdventureByCharacter($character);
        $character = $this->getDoctrine()->getRepository(Character::class)->findOneById($character);
        $tile = $this->getDoctrine()->getRepository(Tile::class)->findById($adventure[0]->getTile()->getId());
        $tileEffects = $this->getDoctrine()->getRepository(TileEffects::class)->findById($tile[0]->getEffects()->getId());
        $monster = $this->getDoctrine()->getRepository(Monster::class)->findById($tile[0]->getMonster()->getId());

        /* test if life of the character is impacted */
        if ($tileEffects[0]->getType() === 'desert') {
            $characterLife = $character->getLife();
            $damage = $tileEffects[0]->getEffectValue());

            $character->setLife($characterLife + $damage); 
            $em->persist($character);
            $em->flush();
        }

        /*** if monster still alive, monster attacks - Monster.attack ***/
        $monsterRoaming = $monster[0]->getLife() !== 0;
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
        
        /* test if action of the character is impacted */
        if ($tileEffects[0]->getType() === 'swamp') {
            dump('move action cancelled');die;
        } else { 
            /*** character moves, a new tile is created and added to this adventure ***/

            /* create a monster to assigned to the new tile - Monster.new */
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

            /* create tile - Tile.new */
            $tile = new Tile();
            $tileType = ['grasslands', 'hills', 'forest', 'mountains', 'desert', 'swamp'];
            $tile->setType($tileType[array_rand($tileType, 1)]);
            /* set effects */
            $effects = $this->getDoctrine()->getRepository(TileEffects::class)->findEffectsByTypeTile($tile->getType());
            $tile->setEffects($effects);
            /* set monster */
            $tile->setMonster($monster);
            $em->persist($tile);
            $em->flush();

            /* add the new tile to the adventure of the character */
            $adventure = $this->getDoctrine()->getRepository(Adventure::class)->findAdventureByCharacter($character);
            $adventure[0]->addTile($tile);
            dump($adventure);die;
        }

    }

    public function postAttackAction(Request $request, Character $character): Response
    {
        $em = $this->getDoctrine()->getManager();

        $character = $this->getDoctrine()->getRepository(Character::class)->findOneById($character);
        $adventure = $this->getDoctrine()->getRepository(Adventure::class)->findAdventureByCharacter($character);
        $tile = $this->getDoctrine()->getRepository(Tile::class)->findById($adventure[0]->getTile()->getId());

        /* test if monster is roaming on the active tile */
        $monster = $this->getDoctrine()->getRepository(Monster::class)->findById($tile[0]->getMonster()->getId());

        $monsterRoaming = $monster[0]->getLife() !== 0;

        if (!$monsterRoaming) {
           dump('action stopped: no monster to attack');die;
        } else {
            /*** character attacks ***/

            /* test if life of the character is impacted */
            $tileEffects = $this->getDoctrine()->getRepository(TileEffects::class)->findById($tile[0]->getEffects()->getId());

            if ($tileEffects[0]->getType() === 'desert') {
                $characterLife = $character->getLife();
                $damage = $tileEffects[0]->getEffectValue());

                $character->setLife($characterLife + $damage); 
                $em->persist($character);
                $em->flush();
            }

            $characterAttack    = $character->getAttack();
            $monsterShielding   = $monster[0]->getShielding();
            $monsterLife        = $monster[0]->getLife();

            /* launch dice method missing */
            if ($characterAttack > $monsterShielding) {
                $remainingLife = $monsterLife - ($characterAttack - $monsterShielding);
                $monster[0]->setLife($remainingLife);
            }

            /* persist the entities updated */
            $em->persist($monster[0]);
            $em->persist($character);
            $em->flush();

            /* test monster defeat */
            if ($monsterLife <= 0) {
                $tile[0].setMonster(null);
                dump($tile);die;
            } else {
                /*** monster attack ***/

                /* set special effect */
                $tileEffects = $this->getDoctrine()->getRepository(TileEffects::class)->findById($tile[0]->getEffects()->getId());
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
        }
    }

    public function postRestAction($character): Response
    {
        return $this->json([
            'time of the nap' => $character
        ]);
    }

    public function getCharacterAction(Character $character): Response
    {
        /*** fetch the character parameters ***/
        $character = $this->getDoctrine()->getRepository(Character::class)->findById($character);
        dump($character);die;
    }
}