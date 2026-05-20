<?php

declare(strict_types=1);

namespace App\Livewire\Message;

use App\Models\Message;
use App\Actions\Message\SendMessageAction;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Facades\Shopper;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Thread extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public Message $message;

    public ?array $data = [];

    public function mount(Message $message): void
    {
        $user = Shopper::auth()->user();

        abort_unless($user, 403);

        $this->authorize('view', $message);

        if ($message->recipient_id === $user->id && blank($message->read_at)) {
            $message->markRead();
        }

        $this->message = $message->load(['sender', 'recipient', 'replies.sender', 'replies.recipient']);

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('body')
                    ->label('Reply')
                    ->rows(5)
                    ->required()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function reply(SendMessageAction $action): void
    {
        $sender = Shopper::auth()->user();

        abort_unless($sender, 403);

        $recipient = $this->message->sender_id === $sender->id
            ? $this->message->recipient
            : $this->message->sender;

        abort_unless($recipient, 422);

        $data = $this->form->getState();

        $action->execute(
            sender: $sender,
            recipient: $recipient,
            subject: $this->message->subject,
            body: $data['body'],
            parent: $this->message,
        );

        $this->form->fill();
        $this->refreshMessage();

        Notification::make()
            ->title('Reply sent')
            ->success()
            ->send();
    }

    public function archive(): void
    {
        $this->authorize('delete', $this->message);

        $this->message->archive();

        $this->redirectRoute('shopper.messages.index', navigate: true);
    }

    public function restore(): void
    {
        $this->authorize('delete', $this->message);

        $this->message->restore();
        $this->refreshMessage();

        Notification::make()
            ->title('Message restored')
            ->success()
            ->send();
    }

    public function toggleStar(): void
    {
        $this->authorize('update', $this->message);

        filled($this->message->starred_at)
            ? $this->message->unstar()
            : $this->message->star();

        $this->refreshMessage();
    }

    public function render(): View
    {
        return view('livewire.message.thread')
            ->title($this->message->subject);
    }

    private function refreshMessage(): void
    {
        $this->message = $this->message
            ->refresh()
            ->load(['sender', 'recipient', 'replies.sender', 'replies.recipient']);
    }
}
