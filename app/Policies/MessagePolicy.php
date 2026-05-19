<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('browse_messages');
    }

    public function view(User $user, Message $message): bool
    {
        return $user->can('read_messages')
            && in_array($user->id, [$message->sender_id, $message->recipient_id], true);
    }

    public function create(User $user): bool
    {
        return $user->can('add_messages');
    }

    public function update(User $user, Message $message): bool
    {
        return $user->can('edit_messages')
            && in_array($user->id, [$message->sender_id, $message->recipient_id], true);
    }

    public function delete(User $user, Message $message): bool
    {
        return $user->can('delete_messages')
            && in_array($user->id, [$message->sender_id, $message->recipient_id], true);
    }
}
