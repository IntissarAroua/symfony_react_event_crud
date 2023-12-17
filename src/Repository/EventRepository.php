<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use \Datetime;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
    * @return Event[] Returns an array of Event objects
    */
    public function findByDateAndLocation($date, $location): array
    {
        $qr = $this->createQueryBuilder('e');

        if ($location != '') {
            $qr->andWhere('e.location = :location')
                ->setParameter('location', $location);
        }
        if ($date != '') {
            $date = new DateTime($date);
            $qr->andWhere('e.start_date BETWEEN :start AND :end OR e.end_date BETWEEN :start AND :end OR :start BETWEEN e.start_date AND e.end_date OR :end BETWEEN e.start_date AND e.end_date')
                ->setParameter('start', $date->format('Y-m-d')." 00:00:00")
                ->setParameter('end', $date->format('Y-m-d')." 23:59:59");
        }

        return $qr->getQuery()->getResult();
    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
