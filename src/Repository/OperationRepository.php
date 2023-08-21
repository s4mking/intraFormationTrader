<?php

namespace App\Repository;

use App\Entity\Operation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Operation>
 *
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function paginate($dql, $page = 1, $limit = 25)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
    public function findAveragesLastWeek(UserInterface $user): array
   {
       return $this->createQueryBuilder('o')
           ->select('SUM(o.profit) AS weekly_average')
           ->addSelect('DATE_TRUNC(\'week\', o.closeTime) AS week')
           ->andWhere('o.transmitter = :user')
           ->setParameter('user', $user)
           ->addGroupBy('week')
           ->getQuery()
           ->execute()
       ;
   }
    public function findTotalLastLastWeek(UserInterface $user): array
    {
        return $this->createQueryBuilder('o')
            ->select('SUM(o.profit) AS weekly_total')
            ->andWhere('o.closeTime >= :begin')
            ->andWhere('o.closeTime <= :end')
            ->andWhere('o.transmitter = :user')
            ->setParameter('begin', new \DateTime('-7 days'))
            ->setParameter('end', new \DateTime('-14 days'))
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function countOperations(UserInterface $user): int
    {
        return $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->andWhere('o.type LIKE :buy OR o.type LIKE :sell')
            ->andWhere('o.transmitter = :user')
            ->setParameter('user', $user)
            ->setParameter('buy', 'Buy')
            ->setParameter('sell', 'Sell')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findTotalLastWeek(UserInterface $user): array
    {
        return $this->createQueryBuilder('o')
            ->select('SUM(o.profit) AS weekly_total')
            ->andWhere('o.type LIKE :buy OR o.type LIKE :sell')
            ->andWhere('o.closeTime >= :end')
            ->andWhere('o.transmitter = :user')
            ->setParameter('end', new \DateTime('-7 days'))
            ->setParameter('user', $user)
            ->setParameter('buy', 'Buy')
            ->setParameter('sell', 'Sell')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findOperationsForUser(UserInterface $user, $currentPage = 1):Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->andWhere('o.type LIKE :buy OR o.type LIKE :sell')
            ->andWhere('o.transmitter = :user')
            ->setParameter('user', $user)
            ->setParameter('buy', 'Buy')
            ->setParameter('sell', 'Sell')
            ->getQuery()
            ;

        return $this->paginate($query, $currentPage);
    }

    public function findOperationsPendingForUser(UserInterface $user):array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.isVerified = false OR o.isApproved = false')
            ->andWhere('o.transmitter = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute()
        ;
    }

    public function findEveryOperationsForUser(UserInterface $user, $currentPage = 1):Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->andWhere('o.transmitter = :user')
            ->setParameter('user', $user)
            ->getQuery()
        ;

        return $this->paginate($query, $currentPage);
    }

    public function findTotalBuy(UserInterface $user): array
    {
        return $this->createQueryBuilder('o')
            ->select('SUM(o.profit) AS weekly_total')
            ->andWhere('o.type LIKE :buy')
            ->andWhere('o.transmitter = :user')
            ->setParameter('buy', 'Buy')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findTotalSell(UserInterface $user): array
    {
        return $this->createQueryBuilder('o')
            ->select('SUM(o.profit) AS weekly_total')
            ->andWhere('o.type LIKE :sell')
            ->andWhere('o.transmitter = :user')
            ->setParameter('sell', 'Sell')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }



//    /**
//     * @return Operation[] Returns an array of Operation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Operation
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
