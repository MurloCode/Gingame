<?php

namespace App\Repository;

use App\Entity\Quizz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quizz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quizz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quizz[]    findAll()
 * @method Quizz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizzRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quizz::class);
    }

    /**
     * Permet de renvoyer les derniers Quizz de la bdd
     * @return Quizz[] Returns an array of Product objects
     */
    public function findLastQuizz($value = 10)
    {
        return $this->createQueryBuilder('quizz')
            ->orderBy('quizz.id', 'DESC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult();
    }

    public function findAllNotRandom() {

        return $this->createQueryBuilder('quizz')
            ->orderBy('quizz.id', 'DESC') 
            ->innerJoin('quizz.themes', 'tp')     
            ->where('tp.name != :Random')
            ->setParameter(':Random', 'Random')
            ->getQuery()
            ->getResult();
    }
}
