<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\EmailStatus;
use App\Models\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class EmailService
{

    public function __construct(
        protected Email $emailModel,
        protected MailerInterface $mailer
    ) {}

    /**
     * @throws TransportExceptionInterface
     */
    public function sendQueuedEmails(): void
    {
        $emails = $this
            ->emailModel
            ->getEmailByStatus(EmailStatus::QUEUE);

        foreach ($emails as $email) {
            $meta = $email['meta_json'];

            $message = (new \Symfony\Component\Mime\Email())
                ->from($meta['from'])
                ->to($meta['to'])
                ->subject($email['subject'])
                ->text($email['text_body'])
                ->html($email['html_body']);
            $this->mailer->send($message);
            $this->emailModel->markEmailSent($email['id']);
        }
    }

    public function send(array $to, string $template): bool
    {
        // sleep(1);
        return true;
    }

}
