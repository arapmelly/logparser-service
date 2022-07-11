<?php

namespace App\Repository;

use App\Entity\LogEntryValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogEntryValue>
 *
 * @method LogEntryValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogEntryValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogEntryValue[]    findAll()
 * @method LogEntryValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogEntryValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogEntryValue::class);
    }

    public function add(LogEntryValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LogEntryValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     *  get the count of events grouped by serviceNames.
     *  Filters: date, statusCode
     */

//    /**
//     * @return LogEntryValue[] Returns an array of LogEntryValue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LogEntryValue
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
