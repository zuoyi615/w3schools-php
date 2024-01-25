<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EmailStatus;
use App\Model;
use Doctrine\DBAL\Exception;
use Symfony\Component\Mime\Address;

class Email extends Model
{

    /**
     * @throws Exception
     */
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
            ->setValue('subject', '?')
            ->setValue('status', '?')
            ->setValue('html_body', '?')
            ->setValue('text_body', '?')
            ->setValue('meta_json', '?')
            ->setValue('created_at', 'NOW()')
            ->setParameter(0, $subject)
            ->setParameter(1, EmailStatus::QUEUE->value)
            ->setParameter(2, $html)
            ->setParameter(3, $text)
            ->setParameter(4, json_encode($meta))
            ->executeStatement();
    }

    /**
     * @throws Exception
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

    /**
     * @throws Exception
     */
    public function markEmailSent(int $id): void
    {
        $this
            ->db
            ->createQueryBuilder()
            ->update('emails')
            ->set('status', '?')
            ->set('sent_at', 'NOW()')
            ->where('id=?')
            ->setParameter(0, EmailStatus::SENT->value)
            ->setParameter(1, $id)
            ->executeStatement();
    }

}
