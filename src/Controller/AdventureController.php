<?php
// src/Controller/AdventureController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdventureController extends AbstractController
{
    public function postAdventureAction()
    {
        $id = random_int(0, 100);

        return new Response(
            '<html><body>Adventure '.$id.' created. Let\'s play !</body></html>'
        );
    }

    public function getAdventureAction($adventure): Response
    {
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