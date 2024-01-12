<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EmailStatus;
use App\Model;
use PDO;
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
        $query
                      = 'INSERT INTO emails (subject, status, html_body, text_body, meta_json, created_at) VALUES (?,?,?,?,?,NOW())';
        $stmt         = $this->db->prepare($query);
        $meta['to']   = $to->toString();
        $meta['from'] = $from->toString();
        $stmt->execute([
            $subject,
            EmailStatus::QUEUE->value,
            $html,
            $text,
            json_encode($meta),
        ]);
    }

    public function getEmailByStatus(EmailStatus $status): array
    {
        $query = 'SELECT * FROM emails WHERE status=?';
        $stmt  = $this->db->prepare($query);
        $stmt->execute([$status->value]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function markEmailSent(int $id): void
    {
        $query = 'UPDATE emails SET status=?, sent_at=NOW() WHERE id=?';
        $stmt  = $this->db->prepare($query);
        $stmt->execute([EmailStatus::SENT->value, $id]);
    }

}
