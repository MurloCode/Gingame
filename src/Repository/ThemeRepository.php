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
	// public function findRootThemes()
	// {
	// 	$em = $this->getContainer()->get('doctrine')->getManager();
	// 	$repository = $em->getRepository('Theme');
	// 	$query = $repository->createQueryBuilder('u')
	// 		->innerJoin('u.groups', 'g')
	// 		->where('g.id = :group_id')
	// 		->setParameter('group_id', 10)
	// 		->getQuery()->getResult();

	// 	return $query;
	// }
	


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
