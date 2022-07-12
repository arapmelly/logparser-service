<?php

namespace App\Repository;

use App\Entity\LogDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogDetail>
 *
 * @method LogDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogDetail[]    findAll()
 * @method LogDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogDetail::class);
    }

    public function add(LogDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LogDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * log count aggregation
     */
    public function logCount($params){

        
        
        $qb = $this->createQueryBuilder('l');

        $qb->select('count(l.id) As total ');

        if (isset($params['statusCode'])){
            $qb->andWhere(
                $qb->expr()->eq('l.statusCode', ':statusCode')
            )->setParameter('statusCode', $params['statusCode']);
        }

        if (isset($params['startDate'])) {
            $qb->andWhere(
                $qb->expr()->gte('l.date', ':startDate')
            )->setParameter('startDate', $params['startDate']);
        }

        if (isset($params['endDate'])) {
            $qb->andWhere(
                $qb->expr()->lte('l.date', ':endDate')
            )->setParameter('endDate', $params['endDate']);
        }

        if (isset($params['serviceNames'])) {
            $qb->andWhere(
                $qb->expr()->in('l.service', ':serviceNames')
            )->setParameter('serviceNames', explode(',', $params['serviceNames']));
        }


        
        return $qb->getQuery()->getResult();

        
 
    }

    public function createQuery($params){
        return $this->createQueryBuilder('l')->select('l.service, count(l.id) As total ');
        
    }

    // public function addSelect($params){
    //     $this->select('l.service, count(l.id) As total ');
    //     return $this;
    // }

    public function queryService($params){
        if(null !== $params['serviceNames'])
            $this->createQuery($params)->andWhere('l.service IN (:service)')->setParameter('service', $params['serviceNames']);
        
        return $this;
    }

    public function queryStatusCode($params){
        if(null !== $params['statusCode'])
            return $this->createQuery($params)->andWhere('l.statusCode = (:statusCode)')->setParameter('statusCode', $params['statusCode']);
        
        
    }

    public function addGroupBy($params){
        return $this->createQuery($params)->groupBy('l.service');
        
    }

//    /**
//     * @return LogDetail[] Returns an array of LogDetail objects
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

//    public function findOneBySomeField($value): ?LogDetail
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
