<?php

namespace App\EventSubscriber;

use App\Entity\Proposition;
use App\Entity\Question;
use App\Entity\Quizz;
use App\Entity\Theme;
use App\Repository\ThemeRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

use function PHPUnit\Framework\isEmpty;

class CreateQuizzSubscriber implements EventSubscriberInterface
{
	public function __construct(ThemeRepository $themeRepository) {
		$this->themeRepository = $themeRepository;
	}

	public function onBeforeEntitySavedEvent ($event) {
		if ($event->getEntityInstance() instanceof Quizz) {
			$request = Request::createFromGlobals();
			$newQuestions = $request->request->all()['Quizz'];
			//$newPropositions = $request->request->all()['Quizz']["new_propositions"];
			// dd($newQuestions);
			// dd($Quizz[image][file]);

			//  dd($newQuestions['themes']);
			
			

			$themes = $newQuestions['themes'];
			//dd($themes);
			if(isset($newQuestions["new_questions"])){				
				$newQuestions = $newQuestions["new_questions"];

				
				foreach ($newQuestions as $newQuestion) {
						
					//dd($newQuestion);
					if ($newQuestion['question'] != "") {
					
						$question = new Question();
						$question->setQuestion($newQuestion['question']);

						
						foreach ($themes as $theme) {
							//dd($theme);
							$themeEntity = $this->themeRepository->findOneBy(['id' => $theme]);
							//$themeRepo = $this->entityManager->getRepository(Theme::class);
							//$th = $themeRepo->findOneBy(['id' => $theme]);
							$question->addTheme($themeEntity);
						}

						//dd($newQuestion);
						if ($newQuestion['propositions'] && $newQuestion['propositions'] != null) {
							foreach ($newQuestion['propositions'] as $newProposition) {
								//$newProposition = $newQuestion['propositions'];
								//dd($newProposition);
								if ( !empty($newProposition['text']) || is_null($newProposition['text'])) {
									$proposition = new Proposition();
									$proposition->setText($newProposition['text']);
									$proposition->setIsValid((isset($newProposition['is_valid']) && $newProposition['is_valid'] == 1) ? true : false);
									$question->addProposition($proposition);
								}
							}
						}
						$event->getEntityInstance()->addQuestion($question);
					}
				}
			
			
			
			}

		} else {
			return false;
		}
	}

	public static function getSubscribedEvents()
	{
		return [
			BeforeEntityPersistedEvent::class => 'onBeforeEntitySavedEvent',
			BeforeEntityUpdatedEvent::class => 'onBeforeEntitySavedEvent',
		];
	}
}
