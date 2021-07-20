<?php

namespace App\DataFixtures;

use App\Entity\Proposition;
use App\Entity\Question;
use App\Entity\Quizz;
use App\Entity\Theme;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

	private $passwordHasher;

	public function __construct(UserPasswordHasherInterface $passwordHasher) {
		$this->passwordHasher = $passwordHasher;
	}

	public function load(ObjectManager $manager)
	{
		// $product = new Product();
		// $manager->persist($product);

		// Create Oquizz / Master User
		$oquizzUser = new User();
		$oquizzUser->setLogin("Oquizz")
				->setRoles(['ROLE_ADMIN'])
				->setEmail("oquizz@gmail.com")
				->setPassword($this->passwordHasher->hashPassword(
					$oquizzUser,
					'123456'
				));

			$manager->persist($oquizzUser);

		// Create Users
		$users = ["Tom", "Robin", "Corentin", "Fanou"];
		foreach ($users as $user) {
			$userCreate = new User();
			$userCreate->setLogin($user)
				->setEmail($user."@gmail.com")
				->setRoles(['ROLE_ADMIN'])
				->addFriend($oquizzUser)
				->setPassword($this->passwordHasher->hashPassword(
					$userCreate,
					'123456'
				));

			$manager->persist($userCreate);
		}



		// Create Themes
		// 1st Parent Theme : Serie TV
		$parentTheme = new Theme();
		$parentTheme->setName("Serie TV");
		
		$manager->persist($parentTheme);
		
		// Create Children Themes
		$themes = ["Friends", "Scrubs", "H", "Kaamelott"];
		foreach ($themes as $theme) {
			$childTheme = new Theme;
			$childTheme->setName($theme)
				->addThemeParent($parentTheme);

				$manager->persist($childTheme);

			// Create Quizz
			for ($i = 1; $i < 5; $i++) {
				$quizz = new Quizz();
				$quizz->setName("Questionnaire $theme $i");
				$quizz->addTheme($childTheme);
				$quizz->addTheme($parentTheme);
				$quizz->setCreatedBy($oquizzUser);
				
				$manager->persist($quizz);
				
				for ($j = 1; $j < 21; $j++) {
					// Create Question (20 per theme)
					$question = new Question();
					$question->setQuestion("Question n°$j ( $theme )");
					$question->addQuizz($quizz);
					$question->addTheme($childTheme);
					$question->addTheme($parentTheme);
					$question->setCreatedBy($oquizzUser);

					$manager->persist($question);

					for ($k = 1; $k < 5; $k++) {
						// Create Proposition (4 per question)
						$proposition = new Proposition();
						$proposition->setText("Proposition n°$k (Question N° $j)");
						if ($k == 1) {
							$proposition->setIsValid(true);
						} else {
							$proposition->setIsValid(false);
						}
						$proposition->setQuestion($question);

						$manager->persist($proposition);
					}
				}

			}
			
		}

		$manager->flush();


	}
}
