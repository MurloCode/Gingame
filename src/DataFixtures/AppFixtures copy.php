<?php

namespace App\DataFixtures;

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
        $parentTheme->setName("Série TV");
        $parentTheme->setImage("/img/serietv.jpeg");
        
        $manager->persist($parentTheme);

        // second Parent Theme : Serie TV
        $movietheme = new Theme();
        $movietheme->setName("Films");
        $movietheme->setImage("/img/cinema.jpeg");

        $manager->persist($movietheme);

        $randomtheme = new Theme();
        $randomtheme->setName("Random");
        $manager->persist($randomtheme);
        
        
        // Create Children Themes
        $themes = [
            
            // ["Friends", "/img/serietv/friends.jpeg"],
            // ["Kaamelott", "/img/serietv/kaamelott.jpeg"],
            // ["Scrubs", "/img/serietv/scrubs.jpeg"],
            // ["Années8090", "/img/annees8090.png"],
            // ["How i met your mother", "/img/serietv/howimetyourmother.jpeg"],
            // ["Personnages", "/img/serietv/personnages.jpeg"],
            // ["Cinéma", "/img/ciné.png"],
            // ["Fixtures", "/img/ladiesman.jpg"]

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
                $friends->setImage("/img/serietv/friends-logo.png");
                $friends->addThemeParent($parentTheme); // Serie TV
                $manager->persist($friends);

                // Kaamelott
                $kaamelott = new Theme();
                $kaamelott->setName("Kaamelott"); // Nom de la série
                $kaamelott->setImage("/img/serietv/kaamelott.jpeg");
                $kaamelott->addThemeParent($parentTheme); // Serie TV
                $manager->persist($kaamelott);

                // Scrubs
                $Scrubs = new Theme();
                $Scrubs->setName("Scrubs"); // Nom de la série
                $Scrubs->setImage("/img/serietv/scrubs-logo.jpg");
                $Scrubs->addThemeParent($parentTheme); // Serie TV
                $manager->persist($Scrubs);

                // Années 8090
                $Années8090 = new Theme();
                $Années8090->setName("Années8090"); // Nom de la série
                $Années8090->setImage("/img/quizz/annees8090.png");
                $Années8090->addThemeParent($parentTheme); // Serie TV
                $manager->persist($Années8090);

                // How i met your mother
                $HowIMetYourMother = new Theme();
                $HowIMetYourMother->setName("How I Met Your Mother"); // Nom de la série
                $HowIMetYourMother->setImage("/img/serietv/howimetyourmother-logo.jpeg");
                $HowIMetYourMother->addThemeParent($parentTheme); // Serie TV
                $manager->persist($HowIMetYourMother);

                // Personnages
                $Personnages = new Theme();
                $Personnages->setName("Personnages"); // Nom de la série
                $Personnages->setImage("/img/serietv/personnages.jpeg");
                $Personnages->addThemeParent($parentTheme); // Serie TV
                $manager->persist($Personnages);

                // Cinéma
                $cinéma = new Theme();
                $cinéma->setName("Cinéma"); // Nom du quizz
                $cinéma->setImage("/img/quizz/ciné.png");
                $cinéma->addThemeParent($movietheme); // Cinéma
                $manager->persist($cinéma);

                // Demo
                $demo = new Theme();
                $demo->setName("Démo"); // Nom de la série 
                $demo->setImage("/img/quizz/ladiesman.jpg");
                $demo->addThemeParent($parentTheme); // Serie TV
                $manager->persist($demo);
               
                // Quizz builder

                // Connaissez-vous Friends ?
                $quizzFriends = new Quizz();
                $quizzFriends->setName("Connaissez-vous Friends ?"); // Titre du Quizz, à modifier
                $quizzFriends->setImage("/img/quizz/friends.jpeg");
                $quizzFriends->addTheme($friends)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzFriends);

                // Testez-vous sur Friends ?
                $quizzFriends2 = new Quizz();
                $quizzFriends2->setName("Testez-vous sur Friends ?"); // Titre du Quizz, à modifier
                $quizzFriends2->setImage("/img/quizz/friends-2.jpeg");
                $quizzFriends2->addTheme($friends)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzFriends2);

                // Connaissez-vous Kaamelott ?
                $quizzKaamelott = new Quizz();
                $quizzKaamelott->setName("Connaissez-vous Kaamelott ?");
                $quizzKaamelott->setImage("/img/quizz/kaa.png");
                $quizzKaamelott->addTheme($kaamelott)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzKaamelott);

                // Testez-vous sur Kaamelott ?
                $quizzKaamelott2 = new Quizz();
                $quizzKaamelott2->setName("Testez-vous sur Kaamelott ?");
                $quizzKaamelott2->setImage("/img/quizz/kaamelott-2.jpg");
                $quizzKaamelott2->addTheme($kaamelott)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzKaamelott2);

                //Connaissez-vous Scrubs ?
                $quizzScrubs = new Quizz();
                $quizzScrubs->setName("Connaissez-vous Scrubs ?");
                $quizzScrubs->setImage("/img/quizz/scrubs.jpeg");
                $quizzScrubs->addTheme($Scrubs)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzScrubs);

                 //Testez-vous sur Scrubs ?
                 $quizzScrubs2 = new Quizz();
                 $quizzScrubs2->setName("Testez-vous sur Scrubs ?");
                 $quizzScrubs2->setImage("/img/quizz/scrubs-1.jpg");
                 $quizzScrubs2->addTheme($Scrubs)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                 $manager->persist($quizzScrubs2);

                //Années 8090
                $quizzAnnées8090 = new Quizz();
                $quizzAnnées8090->setName("Années8090"); // Titre du Quizz, à modifier
                $quizzAnnées8090->setImage("/img/quizz/annees8090-1.jpg");
                $quizzAnnées8090->addTheme($Années8090)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzAnnées8090);

                //Nostalgie 8090
                $quizzNostalgie8090 = new Quizz();
                $quizzNostalgie8090->setName("Années8090"); // Titre du Quizz, à modifier
                $quizzNostalgie8090->setImage("/img/quizz/annees8090-2.jpg");
                $quizzNostalgie8090->addTheme($Années8090)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzNostalgie8090);

                // Connaissez vous How i met your mother ?
                $quizzHowIMetYourMother = new Quizz();
                $quizzHowIMetYourMother->setName("Connaissez vous How i met your mother ?"); // Titre du Quizz, à modifier
                $quizzHowIMetYourMother->setImage("/img/quizz/howimetyourmother.jpeg");
                $quizzHowIMetYourMother->addTheme($HowIMetYourMother)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzHowIMetYourMother);

                // Testez-vous sur How i met your mother ?
                $quizzHowIMetYourMother2 = new Quizz();
                $quizzHowIMetYourMother2->setName("Testez-vous sur How i met your mother ?"); // Titre du Quizz, à modifier
                $quizzHowIMetYourMother2->setImage("/img/quizz/howimetyourmother-1.jpeg");
                $quizzHowIMetYourMother2->addTheme($HowIMetYourMother)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzHowIMetYourMother2);

                // Personnages de séries Tv
                $quizzPersonnages = new Quizz();
                $quizzPersonnages->setName("Personnages de séries Tv"); // Titre du Quizz, à modifier
                $quizzPersonnages->setImage("/img/quizz/personnages-1.jpg");
                $quizzPersonnages->addTheme($Personnages)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzPersonnages);

                // Personnages de séries
                $quizzPersonnages2 = new Quizz();
                $quizzPersonnages2->setName("Personnages de séries"); // Titre du Quizz, à modifier
                $quizzPersonnages2->setImage("/img/quizz/personnages-2.jpg");
                $quizzPersonnages2->addTheme($Personnages)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzPersonnages2);

                // Cinéma Divers
                $quizzCinéma = new Quizz();
                $quizzCinéma->setName("Cinéma Divers"); // Titre du Quizz, à modifier
                $quizzCinéma->setImage("/img/quizz/ciné.png");
                $quizzCinéma->addTheme($cinéma)->addTheme($movietheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzCinéma);


                // Cinéma Varié
                $quizzCinéma2 = new Quizz();
                $quizzCinéma2->setName("Cinéma Varié"); // Titre du Quizz, à modifier
                $quizzCinéma2->setImage("/img/quizz/cinéma.jpg");
                $quizzCinéma2->addTheme($cinéma)->addTheme($movietheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzCinéma2);

                // Demo
                $quizzDemo = new Quizz();
                $quizzDemo->setName("Demo oQuizz"); // Titre du Quizz, à modifier
                $quizzDemo->setImage("/img/quizz/ladiesman.jpg");
                $quizzDemo->addTheme($demo)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzDemo);

                // Quizz Connaissez-vous Friends?           

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
                
                //Testez vous sur Friends
                // 1
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Quel est l'ancien métier de Mike ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Avocat")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Comptable")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Developpateur")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Juge")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 2
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Pour quel rôle Estelle appelle-t-elle Joey quand il commence Mac & C.H.E.E.S.E ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Son rôle actuel")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le frère de Drake Ramoray")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un boxeur gay")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Serveur dans un bar")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 3
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Combien de fois Ross s'est-il fiancé ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("2")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("4")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("3")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("1")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 4
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Dans quel jeu télévisé Joey est-il invité ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Pyramide")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Les chiffres et les lettres")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Qui est qui ?")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le juste prix")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 5
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Quel est le métier de la mère de Chandler ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Romancière érotique")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Meneuse de revue dans un cabaret")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Docteur")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mère au foyer")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 6
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Comment se nomment les soeurs de Rachel ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Amy et Jil")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Annie et Jil")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Amy et Karen")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jil et Karine")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 7
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Où Chandler est-il muté ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Tulsa")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Phoenix")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Atlanta")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Paris")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 8
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Quelle est la plus grande peur de Rachel ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Les poissons")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Les tarentules")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les pigeons")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les balançoires")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 9
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("De quel acteur Joey doit-il être la doublure de fesses ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Al Pacino")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Marlon Brando")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Robert DeNiro")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Charlton Eston")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 10
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Qui prononce les derniers mots de la série ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Chandler")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Monica")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ross")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Rachel")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);
        


                // Quizz Connaissez-vous Kaamelott?

                // 1
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion(" A cause de son illétrisme, comment se fait appeler Perceval lors de ses quêtes ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Provencal le Gaulois")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Sébastien le Chabal")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jacques Martin")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lorant Deutsh")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 2
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Pourquoi Kaamelott s’écrit avec 2 “t” ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Afin que le nom de la série soit correctement prononcé.")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("C'est Perceval qui l'a écrit la première fois")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ah bon il y a 2 t?")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Euh non ca s'écrit camelotte")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 3
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Quel personnage ne fait pas partie de la Table Ronde ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Le Duc d'Aquitaine")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Perceval")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Bohort")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Léodagan")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 4
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Comment s’appelle le Royaume de Léodagan ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("La Carmélide")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("La Carmélite")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Caramelys")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La Calédonie")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 5
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Qui a réalisé la bande-son de la série ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Alexandre Astier")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("John Williams")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Vianey")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Pascal Obispo")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 6
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Pourquoi Guenièvre a-t-elle peur des oiseaux ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Ils n’ont pas de bras")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Ils n'ont pas de poils")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ils volent")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ils mangent des graines")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 7
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Sous quel pied Arthur est-il marqué au fer rouge ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Le droit")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le gauche")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Il n'est pas marqué au fer")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("C'est pas faux")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 8
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Quel est le nom de la première épouse d’Arthur ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Aconia")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Arnica")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Camélia")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Césaria")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 9
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Comment se nomme la mère de Guenièvre ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Seli")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Mène")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Madame Léodagan")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Françoise")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 10
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Quel est le plat national de Kaamelott ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Le croque monsieur")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le hot dog")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le chili con carne")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La pizza")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // Testez-vous sur Kaamelott
                // 1
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Quel est le nom du clan crée par Perceval et Karadoc ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Les Semi-croustillants")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Les Sous-croquants")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les Semi-hommes")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les Semis")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 2
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Quelle est la botte secrete de Perceval ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Ouais, c’est pas faux")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("On en a gros")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La gauche")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La droite")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 3
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Comment Perceval appelle-t-il sa grand-mère ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Nonna")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Mima")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mère-Grand")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jocelyne")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 14
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Quel est le vrai nom de La Dame du Lac ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Viviane")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Céline")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Carmen")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mélissa")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 15
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Selon Bohort quel animal est un prédateur mortel ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Le faisan")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le lapin")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le papillon")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le loup")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 16
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Qui a fabriqué la table ronde ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Breccan")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Ikéa")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("But")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le voisin")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 17
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Bien que prêtre officiel de Kaamelott quelle est l’autre fonction du père Blaise ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Scribe")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Facteur")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Boulanger")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Eboueur")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 18
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Qui est le père du Chevalier Gauvain ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Le roi Loth")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Léodagan")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Karadoc")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Arthur")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 19
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Qui est le grand rival de Merlin ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Elias")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Hervé")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Père Blaise")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Tavernier")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 20
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Afin de le protéger de son père, Uther Pendragon, Merlin envoie Arthur auprès d’une famille adoptive.Quel est le nom du père adoptif d’Arthur ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Anton")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Antoine")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Anthony")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mercorius")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // Quizz Connaissez-vous Scrubs?
                
                // 1
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("”J.D” sont les initiales pour : ");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Jonathan Dorian")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("John Dev")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jules Derne")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Job Désiré")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 2
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Quelle série a vu Sarah Chalke (Elliot) débuter à la télévision ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Roseanne")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("How i met your mother")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dallas")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Sentinel")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 3
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("De quelle manière Cox appelle-t-il souvent J.D ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Prénoms féminins")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Jean Jacques")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hey !")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Machin")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 4
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Comment s’appelle le chien de Bob Kelso ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Baxter")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Dexter")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Laxter")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lobster")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 5
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Pour quel établissement J.D quitte-t-il Sacred Heart ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("La Clinique Saint Vincent")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("L'Hotel Dieu")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une clinique vétérinaire")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un Hopital Militaire")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 6
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Comment Turk et J.D ont-ils appelé leur “chien” empaillé ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Rowdy")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Lechien")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Rufus")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Paf")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 7
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Quel acteur le Dr Cox déteste-t-il le plus ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Hugh Jackman")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Bradd Pitt")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ryan Reynolds")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Clint Eastwood")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 8
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Comment s’appelle Le Concierge ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Glen Matthews")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Matthew Glenns")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Tommy Janitor")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("On ne le sait pas")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 9
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Avec qui Cox n’aura-t-il jamais le dernier mot tout au long de la série ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Jordan")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Kelso")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("J.D")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Turk")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 10
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Comment s’appelle le groupe de Ted ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("The Worthless Peons")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("The Lawyers")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Sacred Heart")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Anonymous")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // Testez-vous sur Scrubs
                // 1
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Quel est le nom de la mère du fils de J.D. ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Kim Briggs")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Kim Bassinger")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Carla Shiffer")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Stella Wizeman")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 2
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Qui succède à Kelso dans les 3 premiers épisodes de la saison 8 ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Dr Taylor Maddox")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Dr Evelyn Codox")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr Mitchell Ronflex")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lui-même")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 3
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Qui J.D appelle-t-il pour venir à bout de Neena ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Jordan")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le Concierge")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Eliott")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Sa maman")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 4
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Quel souvenir Kelso a-t-il ramené de la guerre du Vietnam ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Un tatouage “Johnny”")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Son uniforme")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Des cauchemards")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une femme")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 5
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Qui a crée la série ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Bill Lawrence")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Chuck Lorre")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Matha Kauffman")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Bil Clinton")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 6
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Combien de saisons compte la série ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("8+1")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("8")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("10")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("6")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 7
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("A quel célèbre docteur, Cox rend-il hommage en marchant avec une canne ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Dr House")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Dr Ross")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr Geller")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr Becker")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 8
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("De quel show médical Scrubs a-t-il été considéré comme un pastiche ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Grey's Anatomy")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Urgences")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Resident")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr House")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 9
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Quel est le 2eme prénom de Cox ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Ulysse")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Achille")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Steven")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Rodney")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 10
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Pourquoi la majorité des épisodes ont un titre qui commence par un adjectif possessif ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("La série est le journal intime de J.D")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Ils appartiennent à l'auteur")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Erreur de traduction")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("A cause de l'égo du scénariste")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                //Quizz Nostalgie 8090
                // 1
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Bayside ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Sauvés par le gong")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Buffy contre les vampires")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Beverly Hills")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hartley coeurs à vif")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                // 2
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Maire de New York ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Spin City")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Seinfield")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("New York Police Judiciaire")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Happy Days")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);


                // 3
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Le Centre ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Le Caméléon")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Hélène et les Garçons")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Prince de Bel-Air")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Buffy contre les vampires")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);


                // 4
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Vendeur de chaussures ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Mariés, deux enfants")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Alf")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Sex and the city")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La fête à la maison")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);


                // 5
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Homme de ménage ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Madame est servie")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Navarro")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La vie de Famille")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("7 à la maison")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);


                // 6
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Moto noire ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Tonnerre Mécanique")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Supercopter")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Manimal")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("K2000")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);


                // 7
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Robot Orange ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Riptide")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Les dessus de Palm Beach")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Melrose Place")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le rebelle")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);


                // 8
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Moustache ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Magnum")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Arabesque")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Code Quantum")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Profiler")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);


                // 9
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Lézards ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("V")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Code Lisa")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ally McBeal")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dynastie")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);


                // 10
                $questionAnnées8090 = new Question();
                $questionAnnées8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Chats ?");
                $questionAnnées8090->addQuizz($quizzAnnées8090)->addTheme($Années8090);
                $questionAnnées8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionAnnées8090);

                $proposition = new Proposition();
                $proposition->setText("Alf")->setIsValid(true)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Magnum")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une nounou d'enfer")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Friends")->setIsValid(false)->setQuestion($questionAnnées8090);
                $manager->persist($proposition);

                // Nostalgie 8090
                // 1
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Sens ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("The Sentinel")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Hartley coeurs à vif")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mac Gyver")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Deux flics à Miami")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 2
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Commissariat dans une église ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("21 Jump Street")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Navarro")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Julie Lescaut")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("New York Police Judiciaire")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 3
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Le chevalier et sa monture ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("K2000")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Supercopter")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La croisière s'amuse")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Chips")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 4
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Révérend ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("7 à la maison")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Seinfield")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Droles de dames")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hulk")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 5
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Couteau suisse ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("MacGyver")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Stargate SG 1")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Sliders les mondes parallèles")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Magnum")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 6
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Plan ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("L'agence tout risque")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("L'amour du risque")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Charmed")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Wonder Woman")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 7
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Journal ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("Demain à la une")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Rick Hunter")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cosby Show")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Sentinel")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 8
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Australie ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("Hartley Coeurs à vif")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Le rebelle")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Melrose Place")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Alere à Malibu")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 9
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Guerre du Vietnam ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("L'enfer du devoir")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Manimal")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dawson")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Magnum")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 10
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle série des années 80/90 pensez-vous si on vous dit : Demi Dieu ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Années8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("Hercule")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Ulysse 31")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("L'étalon noir")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hulk")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                // Connaissez vous How i met your mother
                // 1
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Où se sont rencontrés Ted et Barney ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Dans les toilettes du Mc Laren")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Au LaserTag")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dans un salon de massage")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dans un club de strip")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                //2
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Comment Ted veut-il appeler ses enfants ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Luke et Leïa")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Dick et Tracy")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lily et Marshall")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Batman et Robin")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //3
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Qu’est devenu l’appartement de Lily ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Un restaurant Chinois")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Un squat")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un aéroport")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un bar à cocktail ")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //4
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Quel est le métier de Barney ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("PLEASE")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Ecrivain")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Trader")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Avocat")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //5
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("De quelle nationalité est Robin ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Canadienne")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Francaise")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Suisse")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mexicaine")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //6
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("De quelle couleur est le cor volé par Ted pour Robin au début de la série ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Bleu")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Rouge")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jaune")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ocre")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //7
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Sur qui les tableaux de Lily font-ils de l’effet ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Les animaux d'un cabinet vétérinaire")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Un couple de gay")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un dealer de crack")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un clown dépressif")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //8
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("De quelle couleur sont les bottes de Ted ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Rouge")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Bleu")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jaune")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ocre")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //9
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Quel est le nom du barman du McClaren ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Carl")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("José")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Marvin")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Rodrigo")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //10
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Comment s’appelle le mort qui empêche les amis de regarder en live le Super Bowl ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Mark")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Carl")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Doug")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mike")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                // Testez-vous sur How i met your mother
                //1
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("De quel État vient Marshall ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Minnesota")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Nevada")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Nebraska")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Alaska")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //2
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quelle célébrité la bande pense-t-elle rencontrer lors d’un réveillon du nouvel an (S01E11) ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Moby")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Jacky Chan")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ray Parker Jr")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Britney Spears")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //3
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quelle célèbre scène d’une célèbre saga a inspiré la “naissance” du Barney Stinson que nous connaissons ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("La naissance de Dark Vador")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("La mort de Mufasa")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le naufrage du Titanic")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("L'attentat contre Vito Corleone")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //4
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Dans quel pays Victoria part étudier la patisserie ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Allemagne")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Suisse")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Canada")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Croatie")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //5
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Qu’utilise Marshall pour couvrir son “accident” de tondeuse le jour de son mariage ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Un chapeau")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Il se rase complètement")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("un masque Spiderman")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Il ne vient pas")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //6
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quel est le nom de l’ex-fiancé de Lily qui est toujours épris d’elle ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Scooter")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Hummer")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Beetle")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Trottinette")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //7
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Comment s’appelle le 2eme mari de la mère de Ted ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Clint")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Daniel")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Philip")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Paul")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //8
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Comment s’appelle la première fille de Marshall et Lily ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Daisy")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Claudie")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lily Jr")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Robin")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //9
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quelles sont les 2 bibles de Barney ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Le Bro Code et le Playbook")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Oliver Twist et Tom Sawyer")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les 3 suisses et La redoute")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cujo et Shinning")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //10
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quel personnage Barney imagine-t-il pour draguer ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Lorenzo Von Matterhorn ")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Jeff Bezos")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Charlie Brown")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Barack Obama")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                // Personnages Séries TV

                // 1
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Al Bundy ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Mariés, deux enfants")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Madame est servie")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("LOST")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Heroes")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //2
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...DeeDee McCall ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Rick Hunter")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Les Dessous de Palm Beach")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Melrose Place")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cosby Show")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //3
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Angus MacGyver ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("MacGyver")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Les Experts: Las Vegas")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("N.C.I.S")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Code Quantum")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //4
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Elliot Alderson ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Mr. Robot")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("BlackList")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Stargate SG1.")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Supercopter")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //5
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Alec Ramsey ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("L' Etalon Noir")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Tonnerre Mécanique")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Rebelle")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Riptide")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //6
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Buffy Summers ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Buffy contre les vampires")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Charmed")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Sentinel")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Caméléon")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //7
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Sheldon Cooper ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("The Big Bang Theory")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("How i met your mother")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Au-delà du réel")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("24")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //8
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Jimmy McGill ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Breaking Bad")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Malcom")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The middle")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("MacGyver")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //9
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Mickael Knight ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("K2000")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Supercopter")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("L'amour du risque")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("buffy contre les vampires")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //10
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle série peut-on retrouver...Arthur Pendragon ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Kaamelott")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("LOST")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Sur écoute")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ally McBeal")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                // Quizz perso 2
                //1
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Jonathan Dorian ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Scrubs")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Urgences")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr House")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Elite")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //2
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Sydney Bristow ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Alias")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Melrose Place")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Beverly Hills")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("N.C.I.S")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //3
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Max Guevara ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Dark Angel")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Angel")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("How i met your mother")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Pretty Little Liars")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //4
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Serena van der Woodsen ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Gossip Girl")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Revenge")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Desperates housewifes")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Numbers")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //5
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Michael Scott ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("The Office US")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Prison Break")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Angel")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les frères Scott")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);


                //6
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Titus Pullo ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Rome")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Game of Thrones")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Spartacus")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hercule")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //7
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Jarod ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Le Caméléon")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Charmed")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Middle")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("X-Files")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);


                //8
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Meredith Grey ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Grey's Anatomy")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Dr House")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Urgences")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("9-1-1")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);


                //9
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...Tom Hanson ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("21 Jump Street")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("24")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Brooklyn Nine Nine")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Scrubs")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);


                //10
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle série peut-on retrouver...James McNulty ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Sur écoute")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("The Shield")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dexter")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Six feet under")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                // Quizz Cinéma Divers

                //1
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("Quel acteur a joué le premier Batman au cinéma en 1989 ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Michael Keaton")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Julien Lepers")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Val Kilmer")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("George Clooney")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                //2
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("Quelle est la particularité du film Mullholland Drive de David Lynch ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Ca devait etre une série")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Il est muet")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Il est en 3D Imax")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Il a été tourné en italien")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                //3
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("A l'origine, de quel film Die Hard: Piège de cristal devait il etre la suite ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Commando")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Terminator")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Top Gun")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Predator")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                //4
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("Quel est le bruitage le plus célèbre du cinéma ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Le cri de Wilhelm")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Les éperons des cow boys ")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le miaulement d'un chat la nuit")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le bruit d'un pet")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                //5
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("Combien d'acteurs ont joué James Bond ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("8")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("6")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("3")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("1")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                //6
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("A l'origine quelle devait être la machine à remonter le temps de Retour vers le Futur ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Un réfrigérateur")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Une cabine téléphonique")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un cercueil")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une trottinette électrique")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                //7
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("Quel créateur de comics apparaissait en caméo dans tous les films des héros qu'il a crée ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Stan Lee")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Bruce Lee")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cora Lee")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Amay Lee")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                //8
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("Comment s'appelle la lampe mascotte de Pixar ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Luxo Jr.")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Néon")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("E27")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Led")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                //9
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("Quel film de Pixar a été le premier à mettre en scène des personnages humains ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Les Indestructibles")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Cars")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Toy Story")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Monde de Nemo")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                //10
                $questionCinéma = new Question();
                $questionCinéma->setQuestion("De quelle nationalité était le catcheur qui a inspiré la silhouette de Shrek ?");
                $questionCinéma->addQuizz($quizzCinéma->addTheme($cinéma));
                $questionCinéma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma);

                $proposition = new Proposition();
                $proposition->setText("Française")->setIsValid(true)->setQuestion($questionCinéma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Allemande")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Géorgienne")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Américaine")->setIsValid(false)->setQuestion($questionCinéma);
                $manager->persist($proposition);

                // Quizz Cinéma Varié
                //1
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Quel acteur est apparu dans les 9 films de la Saga Star Wars ? ");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("Anthony Daniels - C-3PO")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Ian McDiarmid - Palpatine/L'Empereur")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Kanny Baker - R-2D2")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Peter Mayhew - Chewbacca")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //2
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Quelle autre couleur que le noir et blanc est visible dans le film La Liste de Schindler de Steven Spielberg ?
					");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("Rouge")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Bleu")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Vert")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jaune")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //3
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Comment s’appelle le meilleur ami de Tom Hanks dans Seul au monde ?");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("Wilson")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Adidas")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Booba")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Harry")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //4
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Pour quel film de Disney les Daft Punk ont ils composé la Bande Originale ?");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("Tron: L'Héritage")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Bambi")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mulan")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Pocahontas")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //5
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Comment se nomme le requin des Dents de la mer ?");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("Bruce")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Steven")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jack")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("John")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //6
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Comment s'appelle la pizzéria de Toy Story dont la camionnette apparait dans la plupart des films Pixar ?");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("Pizza Planet")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Pizza Chut")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dinoco's Pizza")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Pizza World")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //7
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Sur les 6 films de la franchise Transformers, combien en a réalisé Michael Bay ?");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma)); 
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("5")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                    
                $proposition = new Proposition();
                $proposition->setText("6")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("4")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("3")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //8
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Quel mot est prononcé 226 fois dans Scarface ?");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("F*ck")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Coke")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dope")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Money")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //9
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Quelle célèbre réalisatrice joue le bébé dans la scène du baptème dans Le Parrain ?");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("Sofia Coppola")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Lana Wachowski")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Kathryn Bigelow")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jane Campion")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                //10
                $questionCinéma2 = new Question();
                $questionCinéma2->setQuestion("Quel est le dernier film du personnage Charlot ?");
                $questionCinéma2->addQuizz($quizzCinéma2->addTheme($cinéma));
                $questionCinéma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionCinéma2);

                $proposition = new Proposition();
                $proposition->setText("Les Temps Modernes")->setIsValid(true)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Le dictateur")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Kid")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Iron Man")->setIsValid(false)->setQuestion($questionCinéma2);
                $manager->persist($proposition);
                    

                //Quizz Demo
                // 1
                $questionDemo = new Question();
                $questionDemo->setQuestion("Quel formateur aurait pu être commandant de bord pour la compagnie o'Clock Airlines ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Michael")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Alexis")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Charles")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Julien")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                //2
                $questionDemo = new Question();
                $questionDemo->setQuestion("De quel animal Morgan est-il fan ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Les poneys")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Les licornes")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Les guêpes")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Les chats")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                //3
                $questionDemo = new Question();
                $questionDemo->setQuestion("Quel est le titre du prochain livre de Charles ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Plus tard")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("symfony pour les noobs")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Guillaume Musso, le best-of")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("L'aube vue du ciel sur googlemaps")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //4
                $questionDemo = new Question();
                $questionDemo->setQuestion("Quelle est l'autre passion d'Alexis ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("La musique")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Nous")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("La bataille navale")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Les faits divers en Drôme occidentale")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //5
                $questionDemo = new Question();
                $questionDemo->setQuestion("Qui place des WC DANS la cuisine et pour le coup est super méga archi nul aux sims ? ");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Greg")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Charles")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Alexis")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Morgan")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //6
                $questionDemo = new Question();
                $questionDemo->setQuestion("Comment s'appelle le chien d'Alexis ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Buster")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Remorqueur")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Milou")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Achetéaimèlee")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //7
                $questionDemo = new Question();
                $questionDemo->setQuestion("Quelle est la couleur préférée de la promo");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("fof")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("bof")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("pof")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("rohff")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //8
                $questionDemo = new Question();
                $questionDemo->setQuestion("Si on vous dit Ascenseur, vous pensez à :");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Charles")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Greg")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Julien")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Morgan")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                //9
                $questionDemo = new Question();
                $questionDemo->setQuestion("Qui casse le code à la majorité de ses visites ? ");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Alexis")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Michael")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Greg")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Morgane")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                //10
                $questionDemo = new Question();
                $questionDemo->setQuestion("Complète ces paroles : On fait le bilan, calmement ...");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent Série TV et Créer par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("...en se remémorant chaque instant ")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("... on a kiffé tranquillement")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("... on se rappellera chaque moment")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("... faut que j'aille chercher mes enfants")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                $manager->flush();
    }
}