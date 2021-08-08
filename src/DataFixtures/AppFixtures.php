<?php

namespace App\DataFixtures;

use App\Entity\Historic;
use App\Entity\User;
use App\Entity\Quizz;
use App\Entity\Theme;
use App\Entity\Question;
use App\Entity\Proposition;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
	private $passwordHasher;

	public function __construct(UserPasswordHasherInterface $passwordHasher)
	{
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
			
		// Create Oquizz / Master User
		$tomUser = new User();
		$tomUser->setLogin("Tom")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("Tom@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$tomUser,
				'123456'
			));
		$manager->persist($tomUser);


		// Create Oquizz / Master User
		$robinUser = new User();
		$robinUser->setLogin("Robin")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("robin@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$robinUser,
				'123456'
			));
		$manager->persist($robinUser);


		// Create Oquizz / Master User
		$corentinUser = new User();
		$corentinUser->setLogin("Corentin")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("corentin@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$corentinUser,
				'123456'
			));
		$manager->persist($corentinUser);


		// Create Oquizz / Master User
		$fanouUser = new User();
		$fanouUser->setLogin("Fanou")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("fanou@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$fanouUser,
				'123456'
			));
		$manager->persist($fanouUser);



		// Create Users
		$users = ["SuperQuizzeur", "Bill.Murray", "Will.Smith"];
		foreach ($users as $user) {
			$userCreate = new User();
			$userCreate->setLogin($user)
			->setEmail($user."@gmail.com")
			->setRoles(['ROLE_USER'])
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
		$parentTheme->setName("Série TV");
		$parentTheme->setImage("serietv.jpeg");
		
		$manager->persist($parentTheme);

		// second Parent Theme : Serie TV
		$movietheme = new Theme();
		$movietheme->setName("Films");
		$movietheme->setImage("cinema.jpeg");

		$manager->persist($movietheme);

		$randomtheme = new Theme();
		$randomtheme->setName("Random");
		$manager->persist($randomtheme);
		
		
		// Create Children Themes
		$themes = [
			
			// ["Friends", "friends.jpeg"],
			// ["Kaamelott", "kaamelott.jpeg"],
			// ["Scrubs", "scrubs.jpeg"],
			// ["Années8090", "annees8090.png"],
			// ["How i met your mother", "howimetyourmother.jpeg"],
			// ["Personnages", "personnages.jpeg"],
			// ["Cinéma", "ciné.png"],
			// ["Fixtures", "ladiesman.jpg"]

		];
	//     $manager->persist($parentTheme);
	
		// Create Children Themes
		//  $themes = ["Black Mirror", "Scrubs", "H", "Kaamelott"];
		foreach ($themes as $theme) {
			$childTheme = new Theme;
			$childTheme->setName($theme[0])->setImage($theme[1]);
			
			$manager->persist($childTheme);

			$theme = $theme[0];

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
				// /!\ Les thèmes doivent être différents de ceux créer plus haut (ligne 42) :
				//     Modifier la variable $themes en conséquence.

				// Friends
				$friends = new Theme();
				$friends->setName("Friends"); // Nom de la série
				$friends->setImage("friends-logo.png");
				$friends->addThemeParent($parentTheme); // Serie TV
				$manager->persist($friends);

				// Kaamelott
				$kaamelott = new Theme();
				$kaamelott->setName("Kaamelott"); // Nom de la série
				$kaamelott->setImage("kaamelott.jpeg");
				$kaamelott->addThemeParent($parentTheme); // Serie TV
				$manager->persist($kaamelott);

				// Scrubs
				$Scrubs = new Theme();
				$Scrubs->setName("Scrubs"); // Nom de la série
				$Scrubs->setImage("scrubs-logo.jpg");
				$Scrubs->addThemeParent($parentTheme); // Serie TV
				$manager->persist($Scrubs);

				// Années 8090
				$Années8090 = new Theme();
				$Années8090->setName("Années 80-90"); // Nom de la série
				$Années8090->setImage("annees8090.png");
				$Années8090->addThemeParent($parentTheme); // Serie TV
				$manager->persist($Années8090);

				// How i met your mother
				$HowIMetYourMother = new Theme();
				$HowIMetYourMother->setName("How I Met Your Mother"); // Nom de la série
				$HowIMetYourMother->setImage("howimetyourmother-logo.jpeg");
				$HowIMetYourMother->addThemeParent($parentTheme); // Serie TV
				$manager->persist($HowIMetYourMother);

				// Personnages
				$Personnages = new Theme();
				$Personnages->setName("Personnages"); // Nom de la série
				$Personnages->setImage("personnages.jpeg");
				$Personnages->addThemeParent($parentTheme); // Serie TV
				$manager->persist($Personnages);

				// Cinéma
				$cinéma = new Theme();
				$cinéma->setName("Cinéma"); // Nom du quizz
				$cinéma->setImage("ciné.png");
				$cinéma->addThemeParent($movietheme); // Cinéma
				$manager->persist($cinéma);

				// Demo
				$demo = new Theme();
				$demo->setName("Démo"); // Nom de la série 
				$demo->setImage("ladiesman.jpg");
				$demo->addThemeParent($parentTheme); // Serie TV
				$manager->persist($demo);
			   
				require('tomQuizz.php');


				/**
				 * quizzFriends
				 * quizzFriends2
				 * quizzKaamelott
				 * quizzKaamelott2
				 * quizzScrubs
				 * quizzScrubs2
				 * quizzAnnées8090
				 * quizzNostalgie8090
				 * quizzHowIMetYourMother
				 * quizzHowIMetYourMother2
				 * quizzPersonnages
				 * quizzPersonnages2
				 * quizzCinéma
				 * quizzCinéma2
				 * quizzDemo
				 */	
				
				$allQuizz = [
					$quizzFriends, $quizzFriends2,
					$quizzKaamelott, $quizzKaamelott2,
					$quizzScrubs, $quizzScrubs2,
					$quizzAnnées8090, $quizzNostalgie8090,
					$quizzHowIMetYourMother, $quizzHowIMetYourMother2,
					$quizzPersonnages, $quizzPersonnages2,
					$quizzCinéma, $quizzCinéma2,
					$quizzDemo
				];
				
				$histoOquizz = [
					$quizzAnnées8090, $quizzNostalgie8090,
					$quizzHowIMetYourMother, $quizzHowIMetYourMother2,
					$quizzPersonnages, $quizzPersonnages2
				];

				$robinQuizz = [
					$quizzFriends, $quizzFriends2,
					$quizzKaamelott, $quizzKaamelott2,
					$quizzScrubs, $quizzScrubs2,
					$quizzCinéma, $quizzCinéma2,
					$quizzDemo				
				];

				$corentinQuizz = [
					$quizzScrubs, $quizzScrubs2,
					$quizzAnnées8090, $quizzNostalgie8090,
					$quizzHowIMetYourMother, $quizzHowIMetYourMother2,
					$quizzPersonnages, $quizzPersonnages2,
					$quizzCinéma, $quizzCinéma2,			
				];

				$fanouQuizz = [
					$quizzFriends, $quizzFriends2,
					$quizzKaamelott, $quizzKaamelott2,
					$quizzScrubs, $quizzScrubs2,
					$quizzAnnées8090, $quizzNostalgie8090,
					$quizzCinéma, $quizzCinéma2,
					$quizzDemo
				];				

				foreach($histoOquizz as $quizz) {
					$fakeGame = new Historic();
					$fakeGame->setQuizz($quizz);
					$fakeGame->setUser($oquizzUser);
					$fakeGame->setScore(rand(0, 10));
					$fakeGame->setOutOf(10);
					$manager->persist($fakeGame);
				}

				for ($i = 0; $i < 10; $i++) {
					foreach($allQuizz as $quizz) {
						$fakeGame = new Historic();
						$fakeGame->setQuizz($quizz);
						$fakeGame->setUser($tomUser);
						$fakeGame->setScore(rand(0, 10));
						$fakeGame->setOutOf(10);
						$manager->persist($fakeGame);
					}
				}

				for ($i = 0; $i < 8; $i++) {
					foreach($robinQuizz as $quizz) {
						$fakeGame = new Historic();
						$fakeGame->setQuizz($quizz);
						$fakeGame->setUser($robinUser);
						$fakeGame->setScore(rand(0, 10));
						$fakeGame->setOutOf(10);
						$manager->persist($fakeGame);
					}
				}

				for ($i = 0; $i < 7; $i++) {
					foreach($corentinQuizz as $quizz) {
						$fakeGame = new Historic();
						$fakeGame->setQuizz($quizz);
						$fakeGame->setUser($corentinUser);
						$fakeGame->setScore(rand(0, 10));
						$fakeGame->setOutOf(10);
						$manager->persist($fakeGame);
					}
				}

				for ($i = 0; $i < 6; $i++) {
					foreach($fanouQuizz as $quizz) {
						$fakeGame = new Historic();
						$fakeGame->setQuizz($quizz);
						$fakeGame->setUser($fanouUser);
						$fakeGame->setScore(rand(0, 10));
						$fakeGame->setOutOf(10);
						$manager->persist($fakeGame);
					}
				}

				$manager->flush();
	}
}