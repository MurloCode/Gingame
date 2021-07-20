<?php

namespace App\Repository;

use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Theme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theme[]    findAll()
 * @method Theme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Theme::class);
	}

/**
 *  @return Theme[] Returns an array of Theme objects
 */

	public function findRootThemes()
	{
		return $this->createQueryBuilder('t')
		->leftJoin('t.themeParent', 'b')
		->having('COUNT(b.id) = 0')
		//->addSelect('COUNT(b.id) AS amount')
		->groupBy('t.id')
		->getQuery()
		->getResult();

	}


	public function findChildThemes()
	{
		return $this->createQueryBuilder('a')
        ->innerJoin('a.themeParent', 'b')
        //->addSelect('a.name')
        //->addSelect('a.id')
        ->addSelect('COUNT(b.id)')
        ->groupBy('a.id')
        ->getQuery()
        ->getResult();
		//return $qb;
	}
	


	/*
	public function findOneBySomeField($value): ?Theme
	{
		return $this->createQueryBuilder('t')
			->andWhere('t.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
}
