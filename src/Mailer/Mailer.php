<?php

namespace App\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

class Mailer
{
    public function __construct(
        private MailerInterface $mailer,
        private MessageGenerator $messageGenerator,
        private string $mailerRecipientAddress)
    {
    }

    /**
     * Send new password to user.
     */
    public function resetPassword(ResetPasswordToken $resetToken, string $to): void
    {
        $message = $this->messageGenerator->getMessage('reset_password', [
            'resetToken' => $resetToken,
        ]);

        $message->to($to);

        $this->mailer->send($message);
    }
}
