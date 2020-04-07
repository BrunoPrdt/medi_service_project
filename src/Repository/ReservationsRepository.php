<?php

namespace App\Repository;

use App\Entity\Reservations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    /**
     * @param $user
     * @return array
     */
    public function findUserReservation($user): array
    {
        return $this->findAllQuery()
            ->andWhere('reservations.user = :val')
            ->setParameter('val', $user)
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array Reservations
     */
    public function findLastestQuery(): array
    {
        return $this->findAllQuery()
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    private function findAllQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('reservations')
            ->orderBy('reservations.id', 'DESC');
    }

    // /**
    //  * @return Reservations[] Returns an array of Reservations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservations
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
