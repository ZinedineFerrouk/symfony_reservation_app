<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    public function __construct(EntityManagerInterface $entityManager){
        // $this->session = $session;
        $this->entityManager = $entityManager;
    }
    
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        // $this->session->getFlashBag()->add('success', 'Heureux de vous revoir par ici !');
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $event->getUser()->getId()]);
        $user->setVisites($user->getVisites() + 1);
        dd($user);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}
