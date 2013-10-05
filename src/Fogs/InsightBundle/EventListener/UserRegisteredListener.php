<?php

namespace Fogs\InsightBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Fogs\InsightBundle\Entity\Profile;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to create a profile after a user registered
 */
class UserRegisteredListener implements EventSubscriberInterface
{

	/**
	 * @var EntityManager
	 */
	protected $entityManager;
	
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
				FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
		);
	}

	public function onRegistrationSuccess(FormEvent $event)
	{
		$user = $event->getForm()->getData();
		$profile = new Profile();
		$profile->setOwner($user);
		$this->entityManager->persist($profile);
	}

}