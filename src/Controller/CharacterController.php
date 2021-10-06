<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CharacterController extends AbstractController
{
    public function postMoveAction($character): Response
    {
        return new Response(
            '<html><body>Character '.$character.' moves.</body></html>'
        );
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

    public function getCharacterAction($character): Response
    {
        return $this->json([
            'attributs' => $character
        ]);
    }
}