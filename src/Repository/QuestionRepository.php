<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    private $maxResult;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
        $this->maxResult = 10;
    }

    /**
     * Select Random Question for create random quizz
     */
    public function randomQuestion() {
        return
            $this->createQueryBuilder('qb')
            ->orderBy('RAND()')
            ->setMaxResults($this->maxResult)
            ->getQuery()
            ->getResult()
        ;
    }

    public function setMaxResult(int $maxResult) {
        $this->maxResult = $maxResult;
    }

    public function findMostQuestionUsers($userId, int $limit = 5) {
		return
			$qb = $this
				->createQueryBuilder('question')
				->select('COUNT(question.createdBy) as count')
                ->where("question.createdBy = $userId")
				->getQuery()
				->getOneOrNullResult();
	}


}
