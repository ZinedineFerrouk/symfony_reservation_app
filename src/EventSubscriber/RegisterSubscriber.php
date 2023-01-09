<?php

namespace App\EventSubscriber;

use App\Event\UserRegisterEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class RegisterSubscriber implements EventSubscriberInterface
{
    private $requestStack;

    public function __construct( RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onUserRegisterEvent(UserRegisterEvent $event): void
    {
       // dd($event->getUser());
        $this->requestStack->getSession()->getFlashBag()->add('success', 'Bienvenue sur notre site, vous pouvez vous connecter');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegisterEvent',
        ];
    }
}
