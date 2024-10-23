<?php

declare(strict_types=1);

namespace App\Mail;

use App\Config;
use App\Entity\User;
use App\SignedUrl;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\BodyRendererInterface;

readonly class SignupEmail
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
    public function sendTo(User $user): void
    {
        $expirationDate = new DateTime('+20 minutes');
        $email          = $user->getEmail();
        $activationLink = $this->generateSignedUrl($user->getId(), $email, $expirationDate);
        $sender         = $this->config->get('mailer.from');
        $templatedEmail = new TemplatedEmail();

        $message = $templatedEmail
            ->from($sender)
            ->to($email)
            ->subject('Welcome to Expennies')
            ->htmlTemplate('emails/signup.twig')
            ->context(
                [
                    'activationLink' => $activationLink,
                    'expirationDate' => $expirationDate,
                ]
            );

        $this->renderer->render($message);

        $this->mailer->send($message);
    }

    private function generateSignedUrl(int $userId, string $email, DateTime $expirationDate): string
    {
        $expiration = $expirationDate->getTimestamp();
        $params     = ['id' => $userId, 'hash' => sha1($email)];
        $query      = ['expiration' => $expiration];

        return $this->signedUrl->fromRoute('verify', $params, $query);
    }

}
