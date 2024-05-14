<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Stores data for uploaded email messages.
 *
 * @property int $id
 * @property string $sender_address
 * @property string $recipient_address
 * @property string $subject
 * @property string $body
 * @property string $body_plain
 * @property string $eml_location
 * @property array $attachments
 * @property array $tags
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_address',
        'recipient_address',
        'subject',
        'body',
        'body_plain',
        'attachments',
        'eml_location',
    ];

    protected $casts = [
        'tags' => 'array',
        'attachments' => 'array',
    ];
}
