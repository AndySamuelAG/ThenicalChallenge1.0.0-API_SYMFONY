<?php

namespace App\Repository;

use App\Entity\Material;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Material|null find($id, $lockMode = null, $lockVersion = null)
 * @method Material|null findOneBy(array $criteria, array $orderBy = null)
 * @method Material[]    findAll()
 * @method Material[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Material::class);
    }

    public function allToArray($m){
        $data = [];
        foreach($m as $key=>$item) {
            $data[$key] = [
                'id' => $item->getId(),
                'tipo' => $item->getTipo(),
                'codigo' => $item->getCodigo(),
                'autor' => $item->getAutor(),
                'titulo' => $item->getTitulo(),
                'anio' => $item->getAnio(),
                'status' => $item->getStatus(),
                'precio' => $item->getPrecio(),
                'editorial' => $item->getEditorial(),
            ];
        }
        return $data;
    }

    // /**
    //  * @return Material[] Returns an array of Material objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Material
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
