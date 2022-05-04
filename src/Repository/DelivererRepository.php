<?php

namespace App\Repository;

use App\Entity\Deliverer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Deliverer>
 *
 * @method Deliverer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deliverer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deliverer[]    findAll()
 * @method Deliverer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DelivererRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deliverer::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Deliverer $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Deliverer $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function lastReservedVehicle($id)
  {
    $query = $this->createQueryBuilder('d')
      ->select('d, r')
      ->where('d.id = :id')
      ->leftJoin('d.rents', 'r')
      ->setParameter('id', $id)
      ->orderBy('r.id', 'DESC')
      ->getQuery()
      ->getResult();
    return $query[0];

  }
    // /**
    //  * @return Deliverer[] Returns an array of Deliverer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deliverer
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
