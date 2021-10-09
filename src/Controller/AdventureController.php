<?php
// src/Controller/AdventureController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\{Character, Adventure, Tile, TileEffects, Monster, MonsterType};
use Symfony\Component\Serializer\SerializerInterface;


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
        $em->flush();

        //create Adventure
        $adventure = new Adventure();
        $adventure->setScore(0);
        $adventure->setTile($tile);
        $adventure->setCharacter($character);
        $em->persist($adventure);
        $em->flush();

        dump($adventure);
        dump($character);die;
        
        // try to setup JsonSerializableNormalizer
        // $json = $serializer->serialize(
        //     $adventure,
        //     'json',
        //     ['adventure' => 'show_adventure']
        // );

    }

    public function getAdventureAction(Request $request, Adventure $adventure): Response
    {
        $adventure = $this->getDoctrine()->getRepository(Adventure::class)->findById($adventure);
        // try to find solution to "null" parameters for joined Entity ($tile, $tile_effects, $monster, $character)
        // $tile = $adventure[0]->getTile()
        // $adventure = $this->getDoctrine()->getRepository(Adventure::class)->getAdventureItems($tile);

        $tile = $this->getDoctrine()->getRepository(Tile::class)->findById($adventure[0]->getTile()->getId());
        $character = $this->getDoctrine()->getRepository(Character::class)->findById($adventure[0]->getCharacter()->getId());

        dump($adventure);die;
    }

    public function getTileAction($adventure): Response
    {
        return $this->json([
            'tile attributs' => $adventure
        ]);
    }

}