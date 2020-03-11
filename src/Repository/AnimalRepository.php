<?php
namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AnimalRepository extends ServiceEntityRepository{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,  Animal::class);
    }

    public function getAnimalesOrderById($order){
        // animales de raza pastor
        $qb = $this->createQueryBuilder('a')
            //->setParameter('raza', 'pastor ganadero australiano')
            //->andWhere("a.raza = :raza")
            ->orderBy('a.id', 'DESC')
            ->getQuery();
        $result = $qb->execute();
        return $result;
    }

}