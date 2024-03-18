<?php

declare(strict_types=1);

namespace App\Mail;

use App\Config;
use App\Entity\UserLoginCode;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\BodyRendererInterface;

readonly class TwoFactorAuthEmail
{

    public function __construct(
        private Config                $config,
        private MailerInterface       $mailer,
        private BodyRendererInterface $renderer,
    ) {}

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendCode(UserLoginCode $userLoginCode): void
    {
        $user           = $userLoginCode->getUser();
        $email          = $user->getEmail();
        $sender         = $this->config->get('mailer.from');
        $templatedEmail = new TemplatedEmail();

        $message = $templatedEmail
            ->from($sender)
            ->to($email)
            ->subject('Your Expennies Verification Code')
            ->htmlTemplate('emails/two_factor.twig')
            ->context(
                [
                    'code' => $userLoginCode->getCode(),
                ]
            );

        $this->renderer->render($message);

        $this->mailer->send($message);
    }

}
