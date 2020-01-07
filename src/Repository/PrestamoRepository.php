<?php

namespace App\Repository;

use App\Entity\Prestamo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Prestamo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestamo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestamo[]    findAll()
 * @method Prestamo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestamoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestamo::class);
    }

    public function allToArray($m){
        $data = [];
        foreach($m as $key=>$item) {
            $data[$key] = [
                'id' => $item->getId(),
                'biblioteca' => $item->getBiblioteca(),
                'entregado' => $item->getEntregado(),
                'prestamo' => $item->getPrestamo(),
            ];
        }
        return $data;
    }

    // /**
    //  * @return Prestamo[] Returns an array of Prestamo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prestamo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
