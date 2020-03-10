<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Animal;
use App\Entity\User;

class AnimalController extends AbstractController
{
    private function resjson($data)
    {
        //serializar datos con servicio de serializer
        $response = new Response();
        $json = $this->get('serializer')->serialize($data, 'json');
        // response con http foundation
        //asignar contenido a la respuesta
        $response->setContent($json);
        // indicar formato de respuesta
        $response->headers->set('Content-type', 'application/json');
        // devolver respuesta
        return $response;
    }

    /**
     * @Route("/animal", name="animal")
     */
    public function index()
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }

    /**
     * @Route("/animal/save", name="save")
     */
    public function save(){
        //traer ususario
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'id'=> 1
        ]);
        //guardar en una tabla de la base de datos
        $animal = new Animal();
        $animal->setTipo('perro');
        $animal->setRaza('pastor ganadero australiano');
        $animal->getColor('negro con blanco');
        $animal->setUser($user);

        //guardar objeto en doctrine (persisitir)
        $em = $this->getDoctrine()->getManager();
        $em->persist($animal);
        $em->flush();

        $data = [
            'status' => 'succes',
            'code' => 200,
            'message' => 'se agrego el animal correctamente',
            'animal_id' => $animal->getId()
        ];

        return $this->resjson($data);
    }
}
