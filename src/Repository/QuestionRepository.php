<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    //    /**
    //     * @return Question[] Returns an array of Question objects
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

    //    public function findOneBySomeField($value): ?Question
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findQuestionOfTheDay(): ?Question
{
    $count = $this->createQueryBuilder('q') // ici on acrée une requete perso sur entité question
        ->select('COUNT(q.id)')
        ->getQuery()
        ->getSingleScalarResult();

    if ($count == 0) {
        return null;
    }

    $index = ((int)(new \DateTime())->format('z')) % $count;

    return $this->createQueryBuilder('q')
        ->setFirstResult($index)
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}

}
