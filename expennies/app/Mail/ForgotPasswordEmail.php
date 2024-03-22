<?php

declare(strict_types=1);

namespace App\Mail;

use App\Config;
use App\Entity\PasswordReset;
use App\SignedUrl;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\BodyRendererInterface;

readonly class ForgotPasswordEmail
{

    public function __construct(
        private Config                $config,
        private MailerInterface       $mailer,
        private BodyRendererInterface $renderer,
        private SignedUrl             $signedUrl,
    ) {}

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendLink(PasswordReset $passwordReset): void
    {
        $email          = $passwordReset->getEmail();
        $sender         = $this->config->get('mailer.from');
        $templatedEmail = new TemplatedEmail();

        $expiration = $passwordReset->getExpiration()->getTimestamp();
        $params     = ['token' => $passwordReset->getToken()];
        $query      = ['expiration' => $expiration];
        $resetLink  = $this->signedUrl->fromRoute('password-reset', $params, $query);

        $message = $templatedEmail
            ->from($sender)
            ->to($email)
            ->subject('Your Expennies Password Reset Instructions')
            ->htmlTemplate('emails/password_reset.twig')
            ->context(
                [
                    'resetLink' => $resetLink,
                ]
            );

        $this->renderer->render($message);

        $this->mailer->send($message);
    }

}
