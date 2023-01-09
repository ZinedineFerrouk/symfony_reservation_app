<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendPasswordResetEmail(User $user, $url)
    {
        $message = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Réinitialiser votre mot de passe ici: ' . $url)
            ->html('<p>See Twig integration for better HTML integration!</p>'.
            '<a target="_blank" href="' . $url . '">Cliquez sur ce lien pour reinitialiser votre mot de passe</a>'
        );

        $this->mailer->send($message);
    }
}