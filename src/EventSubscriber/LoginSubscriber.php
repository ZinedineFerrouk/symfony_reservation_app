<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    private $entityManager;
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack){
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }
    
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $event->getUser()->getId()]);
        $user->setVisites($user->getVisites() + 1);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $request = $this->requestStack->getSession()->getFlashBag()->add('success', 'Heureux de vous revoir ici !');
    }

    public function onLoginFailureEvent(LoginFailureEvent $event): void
    {
        $request = $this->requestStack->getSession()->getFlashBag()->add('danger', 'Désolé une erreur s\'est produite.');
    }

    public function onLogoutEvent(LogoutEvent $event): void
    {
        $request = $this->requestStack->getSession()->getFlashBag()->add('success', 'Vous avez éte correctement deconnecté. A bientôt !');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
            LoginFailureEvent::class => 'onLoginFailureEvent',
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
