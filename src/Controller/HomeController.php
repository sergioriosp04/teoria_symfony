<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $json=[
            "hola"=>"hola"
        ];
        return $this->json($json);
        /*return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hello' => 'hola mundo'
        ]);*/
    }

    /**
     * @Route("/home/animales/{name?sergio}", name="animales", methods={"POST", "GET"})
     */
    public function animals($name){
        $title = 'bienvenido a la pagina de animales';
        return $this->render('home/animales.html.twig',[
            'title' => $title,
            'name' => $name
        ]);
    }
}
