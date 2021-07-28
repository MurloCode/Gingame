<?php

namespace App\EventSubscriber;

use App\Entity\Proposition;
use App\Entity\Question;
use App\Entity\Quizz;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateQuizzSubscriber implements EventSubscriberInterface
{
	public function onBeforeEntitySavedEvent ($event) {
		if ($event->getEntityInstance() instanceof Quizz) {
			$request = Request::createFromGlobals();
			$newQuestions = $request->request->all()['Quizz']["new_questions"];
			//$newPropositions = $request->request->all()['Quizz']["new_propositions"];
			dd($newQuestions);
			if($newQuestions) {
				foreach ($newQuestions as $newQuestion) {
					$question = new Question();
					$question->setQuestion($newQuestion['question']);

					if ($newQuestion['propositions']) {
						dd($newQuestion['propositions']);
						foreach ($newQuestion['propositions'] as $newProposition) {
							//$newProposition = $newQuestion['propositions'];
							
							$proposition = new Proposition();
							$proposition->setText($newProposition);
							$proposition->setIsValid(true);
							$question->addProposition($proposition);
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
