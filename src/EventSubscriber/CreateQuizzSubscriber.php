<?php

namespace App\EventSubscriber;

use App\Entity\Proposition;
use App\Entity\Question;
use App\Entity\Quizz;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

use function PHPUnit\Framework\isEmpty;

class CreateQuizzSubscriber implements EventSubscriberInterface
{
	public function onBeforeEntitySavedEvent ($event) {
		if ($event->getEntityInstance() instanceof Quizz) {
			$request = Request::createFromGlobals();
			$newQuestions = $request->request->all()['Quizz'];
			//$newPropositions = $request->request->all()['Quizz']["new_propositions"];
			// dd($newQuestions);
			// dd($Quizz[image][file]);


			
			if(isset($newQuestions["new_questions"]) && $newQuestions["new_questions"] != null){				
				$newQuestions = $newQuestions["new_questions"];

				foreach ($newQuestions as $newQuestion) {
					$question = new Question();
					$question->setQuestion($newQuestion['question']);

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
