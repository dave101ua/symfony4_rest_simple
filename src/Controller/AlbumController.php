<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController ;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class AlbumController extends FOSRestController
{
    /**
     * @Route("/album", name="index_album", methods={"Get"})
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AlbumController.php',
        ]);
    }

    /**
     * @Rest\Post("/album")
     * @param Request $request
     */
    public function postAlbumAction(Request $request){
        die('preved');
    }
}
