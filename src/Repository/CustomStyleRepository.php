<?php

namespace App\Repository;

use App\Entity\CustomStyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomStyle>
 *
 * @method CustomStyle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomStyle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomStyle[]    findAll()
 * @method CustomStyle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomStyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomStyle::class);
    }

//    /**
//     * @return CustomStyle[] Returns an array of CustomStyle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CustomStyle
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
