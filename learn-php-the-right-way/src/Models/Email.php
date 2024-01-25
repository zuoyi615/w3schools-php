<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EmailStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Mime\Address;

/**
 * @property int         $id
 * @property string      subject
 * @property EmailStatus status
 * @property string      text_body
 * @property string      html_body
 * @property array       meta_json
 * @property Carbon      created_at
 * @property Carbon      updated_at
 * @property Carbon      sent_at
 */
class Email extends Model
{

    protected $casts
        = [
            'meta_json' => 'array',
            'status'    => EmailStatus::class,
        ];

    public static function queue(
        Address $to,
        Address $from,
        string $subject,
        string $html,
        ?string $text = null
    ): void {
        $meta['to']   = $to->toString();
        $meta['from'] = $from->toString();

        $email            = new Email();
        $email->subject   = $subject;
        $email->status    = EmailStatus::QUEUE;
        $email->html_body = $html;
        $email->text_body = $text;
        $email->meta_json = $meta;

        $email->save();
    }

    public static function getEmailByStatus(EmailStatus $status): array
    {
        return static::query()->where('status', '=', $status)->get()->toArray();
    }

    public static function markEmailSent(int $id): void
    {
        static::query()->where('id', '=', $id)->update([
            'status'  => EmailStatus::SENT,
            'sent_at' => new Carbon(),
        ]);
    }

}
