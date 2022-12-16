<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        // ...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
