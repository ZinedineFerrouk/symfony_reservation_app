<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserRegisterEvent extends Event{
    public const NAME = 'user.register';
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}