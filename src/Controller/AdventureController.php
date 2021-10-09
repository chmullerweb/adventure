<?php
// src/Controller/AdventureController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\{Character, Adventure, Tile, TileEffects, Monster};


class AdventureController extends AbstractController
{
    public function postAdventureAction()
    {
        $em = $this->getDoctrine()->getManager();
        //new Tile
        $tile = new Tile();
        $type = ['grasslands', 'hills', 'forest', 'mountains', 'desert'];
        $tile->setType($type[array_rand($type, 1)]);

        // set effects
        $effects = $this->getDoctrine()->getRepository(TileEffects::class)->findTypeTileEffects($tile->getType());
        $tile->setEffects($effects);

        $monster = $this->getDoctrine()->getRepository(Monster::class)->findTypeTileEffects($tile->getType());
        $tile->setMonster('ork');
        
        $em->persist($tile);
        $em->flush();
        dump($tile);die;
        // assign special effect
        // créer une entity à join avec tile > et aller dans phpmyadmin pour ajouter des instances
        // $datas = [];
        // switch ($tile->getType()) {
        //     case 'grasslands':
        //         $datas = {
        //             "point": 2,
        //             "effect": "attack",
        //             "character": "ork"
        //         }
        //         break;
        //     case 'hills':
        //         $datas = {
        //             'point': 2,
        //             'effect': 'attack',
        //             'character': 'ghost'
        //         }
        //         break;
        //     case 'forest':
        //         $datas = {
        //             'point': 2,
        //             'effect': 'attack',
        //             'character': 'gobelin'
        //         }
        //         break;
        //     case 'mountains':
        //         $datas = {
        //             'point': 2,
        //             'effect': 'attack',
        //             'character': 'troll'
        //         }
        //         break;    
        //     case 'desert':
        //         $datas = {
        //             'point': -1,
        //             'effect': 'attack',
        //             'character': 'character'
        //         }
        //         break;
        //     default:
        //         $datas;      
        // }
        
        //new Adventure
        $adventure = new Adventure();
        $adventure->setScore(0);
        $adventure->setTile($tile->getId());
        

        //new Character set with default value
        $character = new Character();
        $character->setLife(20);
        $character->setAttack(12);
        $character->setSchielding(5);
        


        $id = random_int(0, 100);

        return new Response(
            [$tile, $character, $adventure]
        );
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