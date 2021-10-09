<?php
// src/Controller/AdventureController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\{Character, Adventure, Tile, TileEffects, Monster, MonsterType};


class AdventureController extends AbstractController
{
    public function postAdventureAction()
    {
        $em = $this->getDoctrine()->getManager();

        // create monster
        $monster = new Monster();
        $monsterType = ['ork', 'gobelin', 'ghost', 'troll'];
        $monsterType = $monsterType[array_rand($monsterType, 1)];
        $monsterType = $this->getDoctrine()->getRepository(MonsterType::class)->findMonsterByType($monsterType);
        $monster->setType($monsterType);
        $em->persist($monster);
        $em->flush();

        // create tile
        $tile = new Tile();
        $tileType = ['grasslands', 'hills', 'forest', 'mountains', 'desert'];
        $tile->setType($tileType[array_rand($tileType, 1)]);
        // set effects
        $effects = $this->getDoctrine()->getRepository(TileEffects::class)->findEffectsByTypeTile($tile->getType());
        $tile->setEffects($effects);
        // set monster
        $tile->setMonster($monster);
        $em->persist($tile);
        $em->flush();
        
        //create Character & set with default value
        $character = new Character();
        $character->setLife(20);
        $character->setAttack(12);
        $character->setShielding(5);
        $em->persist($character);

        //create Adventure
        $adventure = new Adventure();
        $adventure->setScore(0);
        $adventure->setTile($tile);
        $em->persist($adventure);
        
        $em->flush();

        dump($adventure);
        dump($character);die;

        return $this->json([
            'adventure' => $adventure,
            'character' => $character
        ]);
    }

    public function getAdventureAction(Request $request, $adventure): Response
    {
        // $request->query->get('page');
        return $this->json([
            'adventure' => $adventure
        ]);
    }

    public function getTileAction($adventure): Response
    {
        return $this->json([
            'tile attributs' => $adventure
        ]);
    }

}