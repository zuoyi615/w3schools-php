<?php

declare(strict_type=1);

namespace App\Models;

use App\Model;

class Email extends Model
{
    public function queue(
        string $to,
        string $from,
        string $subject,
        string $html,
        ?string $text = null
    ): void {
        $query = 'INSERT INTO emails (subject, status, html_body, text_body, meta, created_at)
      VALUES (?,?,?,?,?,NOW())';
        $stmt = $this->db->prepare($query);
    }
}
