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
     * @Route("/animal", name="index")
     */
    public function index()
    {
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        $animales = $animal_repo->findAll();

        // una consulta dependiendo las condiciones
        $animal = $animal_repo->findOneBy([
           'tipo' => 'perro',
            'id' => 1
        ]);
        if($animal){
            dump($animal);die();
        }

        // todas las consultas que cumplan lad condiciones
        $animals = $animal_repo->findBy([
            'tipo' => 'perro',
        ],[
            'id' => 'DESC'
        ]);
        if($animals){
            dump($animals);die();
        }

        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animales' => $animales
        ]);
    }

    /**
     * @Route("/animal/save", name="save", methods={"POST"})
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

    /**
     * @Route("/animal/show/{id}", name="animal")
     */
    public function animal($id){
        //cargar repositorio
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        //consulta find
        $animal = $animal_repo->find($id);
        //comprobar
        if(!$animal){
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'el animal con id:'. $id . 'no existe',
            ];
        }else{
            $data = [
                'status' => 'success',
                'code' => 200,
                'message' => 'animal encontrado satisfactoriamente',
                'id' => $animal->getId()
            ];
        }


        return $this->resjson($data);
    }

    /**
     * @Route("/animal/update/{id}", name="update")
     */
    public function update($id){
        //cargar doctrine
        $doctrine = $this->getDoctrine();
        //cargar entity manager
        $em = $doctrine->getManager();
        //cargar repo entidad animal
        $animal_repo = $doctrine->getRepository(Animal::class);
        // find para sacar objeto
        $animal = $animal_repo->find($id);
        //comprobar si el objeto llega
        if(!$animal){
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'el animal con id:'. $id . 'no existe',
            ];
        }else{
            //setear los nuevos datos
            $animal->setTipo("perro $id");
            $animal->setColor('verde');
            //persisitir en docrine el objeto
            $em->persist($animal);
            // flush para guardar
            $em->flush();
            $data = [
                'status' => 'success',
                'code' => 200,
                'message' => 'actualizacion con exito',
                'animal_id' => $animal->getId()
            ];
        }
        // respuesta
        return $this->resjson($data);
    }

    /**
     * @Route("/animal/delete/{id}", name="delete")
     */
    public function delete($id){
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        $animal = $animal_repo->findOneBy([
            'id' => $id
        ]);
        if($animal && is_object($animal)){
            $em = $this->getDoctrine()->getManager();
            $em->remove($animal);
            $em->flush();
            $data = [
                'status' => 'success',
                'code' => 200,
                'message' => 'elimiando exitosamente',
                'animal id' => $animal->getId()
            ];
        }else{
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'e',
            ];
        }
        return $this->resjson($data);
    }

    /**
     * @Route("/animal/querybuilder", name="queryBuilder")
     */
    public function queryBuilder(){
        //ejemplos de query builder
        // animales de raza pastor
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        $qb = $animal_repo->createQueryBuilder('a')
                            ->setParameter('raza', 'pastor ganadero australiano')
                            ->andWhere("a.raza = :raza")
                            ->orderBy('a.id', 'DESC')
                            ->getQuery();
        $result = $qb->execute();
        dump($result);die();
    }

    /**
     * @Route("/animal/dqlEjemplo", name="dqlEjemplo")
     */
    public function dqlEjemplo(){
        // ejemplo de consultas DQL
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT a FROM App\Entity\Animal a WHERE a.raza = 'pastor ganadero australiano' ORDER BY a.id DESC";
        $query = $em->createQuery($dql);
        $result = $query->execute();
        dump($result);die();
    }

}
