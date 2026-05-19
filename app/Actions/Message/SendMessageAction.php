<?php

declare(strict_types=1);

namespace App\Actions\Message;

use App\Models\Message;
use App\Models\User;

final class SendMessageAction
{
    public function execute(User $sender, User $recipient, string $subject, string $body): Message
    {
        return Message::query()->create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'subject' => $subject,
            'body' => $body,
        ]);
    }
}
