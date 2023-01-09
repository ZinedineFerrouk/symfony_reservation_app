<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, Session $session){
        $this->session = $session;
        $this->entityManager = $entityManager;
    }
    
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $event->getUser()->getId()]);
        $user->setVisites($user->getVisites() + 1);
        $this->session->getFlashBag()->add('success', 'Heureux de vous revoir par ici !');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}
