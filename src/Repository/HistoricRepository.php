<?php

namespace App\Repository;

use App\Entity\Historic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry; 


/**
 * @method Historic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Historic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Historic[]    findAll()
 * @method Historic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoricRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Historic::class);
	}

	public function findMostPopular(int $limit = 10) {
		return
			$qb = $this
				->createQueryBuilder('histo')
				->select('quizz.id')
				->innerJoin('histo.quizz', 'quizz')
				->groupBy('quizz.id')
				->orderBy('COUNT(histo.quizz)', 'DESC')
				->setMaxResults($limit)
				->getQuery()
				->getResult();
	}

	public function findMostActivePlayer(int $limit = 5) {
		return
			$qb = $this
				->createQueryBuilder('histo')
				->select('user.id, COUNT(histo.user) as count')
				->innerJoin('histo.user', 'user')
				->groupBy('user.id')
				->orderBy('COUNT(histo.user)', 'DESC')
				->setMaxResults($limit)
				->getQuery()
				->getResult();
	}

	// return
	//     $qb = $this
	//         ->createQueryBuilder('histo')
	//         ->select(/*'COUNT(histo.quizz) as total', 'quizz.name',*/'quizz.id')
	//         ->innerJoin('histo.quizz', 'quizz')
	//         ->groupBy('quizz.id')
	//         ->orderBy('COUNT(histo.quizz)', 'DESC')
	//         ->setMaxResults($limit)
	//         ->getQuery()
	//         ->getResult();

			 //  dd($qb->getDQL());

				
		// return
		//     $qb = $this
		//         ->createQueryBuilder('histo')
		//         ->select('COUNT(histo.quizz) as total', /*'quizz.name',*/'quizz.id')
		//         ->innerJoin('histo.quizz', 'quizz')
		//         // ->innerJoin('histo.quizz', 'quizz', Expr\Join::ON, 'quizz.id = histo.quizz_id')
		//         // ->innerJoin('histo.quizz', 'quizz', "ON",'quizz.id = histo.quizz')
		//         // ->addSelect('COUNT(quizz)')
		//         ->groupBy('quizz.id')
		//         ->orderBy('COUNT(histo.quizz)', 'DESC')
		//         //->having('total > 1')
		//         ->getQuery()
		//         ->getResult();

				  //  dd($qb->getDQL());
		
		// return
		// $qb = $this
		//     ->createQueryBuilder('histo')
		//     ->select('COUNT(histo.quizz) as total', /*'quizz.name',*/'quizz.id')
		//     ->innerJoin('histo.quizz', 'quizz')
		//     // ->innerJoin('histo.quizz', 'quizz', Expr\Join::ON, 'quizz.id = histo.quizz_id')
		//     // ->innerJoin('histo.quizz', 'quizz', "ON",'quizz.id = histo.quizz')
		//     // ->addSelect('COUNT(quizz)')
		//     ->groupBy('quizz.id')
		//     ->orderBy('COUNT(histo.quizz)', 'DESC')
		//     //->having('total > 1')
		//     ->getQuery()
		//     ->getResult();

			
	// return
	//     $qb = $this
	//         ->createQueryBuilder('histo')
	//         ->select('COUNT(histo.quizz) as total', /*'quizz.name',*/'quizz.id')
	//         ->innerJoin('histo.quizz', 'quizz')
	//         // ->innerJoin('histo.quizz', 'quizz', Expr\Join::ON, 'quizz.id = histo.quizz_id')
	//         // ->innerJoin('histo.quizz', 'quizz', "ON",'quizz.id = histo.quizz')
	//         // ->addSelect('COUNT(quizz)')
	//         ->groupBy('quizz.id')
	//         ->orderBy('COUNT(histo.quizz)', 'DESC')
	//         //->having('total > 1')
	//         ->getQuery()
	//         ->getResult();

			  //  dd($qb->getDQL());

		// return
		//     $qb = $this
		//         ->createQueryBuilder('histo')
		//         ->select('COUNT(histo.quizz) as total', 'quizz.name', 'histo.id')
		//         ->innerJoin('histo.quizz', 'quizz')
		//         // ->innerJoin('histo.quizz', 'quizz', Expr\Join::ON, 'quizz.id = histo.quizz_id')
		//         // ->innerJoin('histo.quizz', 'quizz', "ON",'quizz.id = histo.quizz')
		//         // ->addSelect('COUNT(quizz)')
		//         ->groupBy('quizz.id')
		//         ->orderBy('')
		//         //->having('total > 1')
		//         ->getQuery()
		//         ->getResult();

				  //  dd($qb->getDQL());



			// $this
			//     ->createQueryBuilder('h')
			//     //->addSelect('quizz')
			//     ->innerJoin('h.quizz', 'quizz')
			//     ->addSelect('COUNT(quizz) as total')
			//     ->having('total > 1')
			//     ->groupBy('h.id')
			//     ->getQuery()
			//     ->getResult();
	
	
	// $this->repository->createQueryBuilder('offer')
	// ->addSelect('SIZE(offer.files) as files')
	// ->having('files > 1')
	// ->getQuery()
	// ->getResult();
	// https://stackoverflow.com/questions/52813089/doctrine-query-builder-count-manytomany



	// /**
	//  * @return Historic[] Returns an array of Historic objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('h')
			->andWhere('h.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('h.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Historic
	{
		return $this->createQueryBuilder('h')
			->andWhere('h.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/


}
