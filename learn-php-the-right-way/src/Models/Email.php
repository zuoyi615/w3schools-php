<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EmailStatus;
use App\Model;
use Symfony\Component\Mime\Address;

class Email extends Model
{

    public function queue(
        Address $to,
        Address $from,
        string $subject,
        string $html,
        ?string $text = null
    ): void {
        $meta['to']   = $to->toString();
        $meta['from'] = $from->toString();

        $this
            ->db
            ->createQueryBuilder()
            ->insert('emails')
            ->values(
                [
                    'subject'    => '?',
                    'status'     => '?',
                    'html_body'  => '?',
                    'text_body'  => '?',
                    'meta_json'  => '?',
                    'created_at' => 'NOW()',
                ]
            )
            ->setParameters(
                [
                    'subject'   => $subject,
                    'status'    => EmailStatus::QUEUE->value,
                    'html_body' => $html,
                    'text_body' => $text,
                    'meta_json' => json_encode($meta),
                ]
            );
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getEmailByStatus(EmailStatus $status): array
    {
        return $this
            ->db
            ->createQueryBuilder()
            ->select('*')
            ->from('emails')
            ->where('status=?')
            ->setParameter(0, $status->value)
            ->fetchAllAssociative();
    }

    public function markEmailSent(int $id): void
    {
        $this
            ->db
            ->createQueryBuilder()
            ->update('emails')
            ->set('status', '?')
            ->setParameter(0, EmailStatus::SENT->value)
            ->set('sent_at', 'NOW()')
            ->where('id=?')
            ->setParameter(1, $id);
    }

}
