<?php

declare(strict_types=1);

namespace App\Mail;

use App\Config;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\BodyRendererInterface;

readonly class SignupEmail
{

    public function __construct(
        private Config                $config,
        private MailerInterface       $mailer,
        private BodyRendererInterface $renderer
    ) {}

    public function sendTo(string $receiver): void
    {
        $sender         = $this->config->get('mailer.from');
        $templatedEmail = new TemplatedEmail();
        $message        = $templatedEmail
            ->from($sender)
            ->to($receiver)
            ->subject('Welcome to Expennies')
            ->htmlTemplate('emails/signup.twig')
            ->context(
                [
                    'activationLink' => '#',
                    'expirationDate' => new DateTime('+15 minutes'),
                ]
            );

        $this->renderer->render($message);

        $this->mailer->send($message);
    }

}
