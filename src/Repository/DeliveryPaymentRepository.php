<?php

namespace App\Repository;

use App\Entity\DeliveryPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeliveryPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryPayment[]    findAll()
 * @method DeliveryPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryPayment::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DeliveryPayment $entity, bool $flush = true): void
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
    public function remove(DeliveryPayment $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return DeliveryPayment[] Returns an array of DeliveryPayment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeliveryPayment
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
