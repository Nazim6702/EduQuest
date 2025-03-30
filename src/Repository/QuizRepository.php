<?php

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quiz>
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function findAllOrderedByNewest()
    {
    return $this->createQueryBuilder('q')
        ->orderBy('q.createdAt', 'DESC')
        ->getQuery();
    }

    public function findByCategoryOrderedByNewest(string $category)
    {
    return $this->createQueryBuilder('q')
        ->where('q.category = :category')
        ->setParameter('category', $category)
        ->orderBy('q.createdAt', 'DESC')
        ->getQuery();
    }

    public function findByFilters(?string $search, ?string $category)
    {
    $qb = $this->createQueryBuilder('q');

    if ($search) {
        $qb->andWhere('q.title LIKE :search')
           ->setParameter('search', '%' . $search . '%');
        }

    if ($category) {
        $qb->andWhere('q.category = :cat')
           ->setParameter('cat', $category);
        }

    return $qb->orderBy('q.createdAt', 'DESC')->getQuery();
    }

    //    /**
    //     * @return Quiz[] Returns an array of Quiz objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Quiz
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
