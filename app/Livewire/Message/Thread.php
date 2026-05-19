<?php

declare(strict_types=1);

namespace App\Livewire\Message;

use App\Models\Message;
use Illuminate\Contracts\View\View;
use Shopper\Facades\Shopper;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Thread extends AbstractPageComponent
{
    public Message $message;

    public function mount(Message $message): void
    {
        $user = Shopper::auth()->user();

        $this->authorize('view', $message);

        if ($message->recipient_id === $user->id && blank($message->read_at)) {
            $message->update([
                'read_at' => now(),
            ]);
        }

        $this->message = $message->load(['sender', 'recipient']);
    }

    public function archive(): void
    {
        $this->authorize('delete', $this->message);

        $this->message->update([
            'archived_at' => now(),
        ]);

        $this->redirectRoute('shopper.messages.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.message.thread')
            ->title($this->message->subject);
    }
}
