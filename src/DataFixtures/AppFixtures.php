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

		// Create Users
		$users = ["Robin", "Corentin", "Fanou"];
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
		$themes = ["Black Mirror", "Scrubs", "H", "Kaamelott"];
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

		// /!\ Les thèmes doivent être différents de ceux créer plus haut (ligne 42) :
		//     Modifier la variable $themes en conséquence.

			// Friends
			$friends = new Theme();
			$friends->setName("Friends"); // Nom de la série 
			$friends->addThemeParent($parentTheme); // Serie TV
			$manager->persist($friends);

			// Kaamelott
			$kaamelott = new Theme();
			$kaamelott->setName("Kaamelott"); // Nom de la série 
			$kaamelott->addThemeParent($parentTheme); // Serie TV
			$manager->persist($kaamelott);

			
				$quizzFriends = new Quizz();
				$quizzFriends->setName("Aimez-vous Friends ?"); // Titre du Quizz, à modifier
				$quizzFriends->addTheme($friends)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
				$manager->persist($quizzFriends);

					// 1
					$questionFriends = new Question();
					$questionFriends->setQuestion("Qui prononce les premiers mots de la série ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Monica")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Chandler")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Phoebe")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Ross")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 2
					$questionFriends = new Question();
					$questionFriends->setQuestion("Quel est le nom du café où ils se retrouvent ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Central Perk")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Central Presk")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Central Bert")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Centrale Perk")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);
			
					// 3
					$questionFriends = new Question();
					$questionFriends->setQuestion("Comment s'appelle le colocataire psychotique de Chandler ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Eddie Menuek")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Eddie Donque")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Elon Musk")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Just Leblanc")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);
	
					// 4
					$questionFriends = new Question();
					$questionFriends->setQuestion("Pour qui Rachel ressort-elle sa tenue de cheerleader ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Joshua")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("José")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Joseph")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Gunther")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 5
					$questionFriends = new Question();
					$questionFriends->setQuestion("Comment s'appelle l'homme qui permet à Julie d'oublier Ross ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Russ")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("David")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Gavin")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Janice")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 6
					$questionFriends = new Question();
					$questionFriends->setQuestion("Comment s'appelle la grand-mère de Ross et Monica qui décède dans la première saison ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Althea")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Athena")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Mauricette")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Germaine")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 7
					$questionFriends = new Question();
					$questionFriends->setQuestion("Comment se nomment les triplés de Frank Jr ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Franck Jr Jr, Leslie et Chandler")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Ross, Rachel et Chandler")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("LeHulk, Lesly et Phoebe Jr")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Alvin, Simon et Théodore")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 8
					$questionFriends = new Question();
					$questionFriends->setQuestion("Qui aide Ross à monter le canapé ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Rachel et Chandler")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Phoebe et Monica")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Monica et Chandler")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Joey et Monica")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 9
					$questionFriends = new Question();
					$questionFriends->setQuestion("Combien Joey a-t-il de soeurs ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("7")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("8")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("6")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("2")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 10
					$questionFriends = new Question();
					$questionFriends->setQuestion("Qu'offre M.Geller à Monica pour compenser la perte de ses souvenirs ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Sa Porsche")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Sa montre")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Une pièce de monnaie")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Une maison de poupées")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 11
					$questionFriends = new Question();
					$questionFriends->setQuestion("Quel est l'ancien métier de Mike ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Avocat")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Comptable")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Developpateur")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Juge")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 12
					$questionFriends = new Question();
					$questionFriends->setQuestion("Pour quel rôle Estelle appelle-t-elle Joey quand il commence Mac & C.H.E.E.S.E ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Son rôle actuel")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Le frère de Drake Ramoray")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Un boxeur gay")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Serveur dans un bar")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 13
					$questionFriends = new Question();
					$questionFriends->setQuestion("Combien de fois Ross s'est-il fiancé ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("2")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("4")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("3")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("1")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 14
					$questionFriends = new Question();
					$questionFriends->setQuestion("Dans quel jeu télévisé Joey est-il invité ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Pyramide")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Les chiffres et les lettres")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Qui est qui ?")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Le juste prix")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 15
					$questionFriends = new Question();
					$questionFriends->setQuestion("Quel est le métier de la mère de Chandler ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Romancière érotique")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Meneuse de revue dans un cabaret")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Docteur")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Mère au foyer")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 16
					$questionFriends = new Question();
					$questionFriends->setQuestion("Comment se nomment les soeurs de Rachel ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Amy et Jil")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Annie et Jil")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Amy et Karen")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Jil et Karine")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 17
					$questionFriends = new Question();
					$questionFriends->setQuestion("Où Chandler est-il muté ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Tulsa")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Phoenix")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Atlanta")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Paris")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 18
					$questionFriends = new Question();
					$questionFriends->setQuestion("Quelle est la plus grande peur de Rachel ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Les poissons")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Les tarentules")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Les pigeons")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Les balançoires")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 19
					$questionFriends = new Question();
					$questionFriends->setQuestion("De quel acteur Joey doit-il être la doublure de fesses ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Al Pacino")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Marlon Brando")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Robert DeNiro")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Charlton Eston")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

					// 20
					$questionFriends = new Question();
					$questionFriends->setQuestion("Qui prononce les derniers mots de la série ?");
					$questionFriends->addQuizz($quizzFriends)->addTheme($friends); 
					$questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
					$manager->persist($questionFriends);

						$proposition = new Proposition();
						$proposition->setText("Chandler")->setIsValid(true)->setQuestion($questionFriends);
						$manager->persist($proposition);
						
						$proposition = new Proposition();
						$proposition->setText("Monica")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Ross")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);

						$proposition = new Proposition();
						$proposition->setText("Rachel")->setIsValid(false)->setQuestion($questionFriends);
						$manager->persist($proposition);
			


	
		$manager->flush();


	}
}