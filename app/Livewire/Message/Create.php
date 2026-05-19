<?php

declare(strict_types=1);

namespace App\Livewire\Message;

use App\Actions\Message\SendMessageAction;
use App\Models\Message;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Facades\Shopper;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Create extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->authorize('create', Message::class);

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        $currentUser = Shopper::auth()->user();

        return $form
            ->schema([
                Forms\Components\Select::make('recipient_id')
                    ->label('Recipient')
                    ->options(
                        User::query()
                            ->when($currentUser, fn ($query) => $query->whereKeyNot($currentUser->id))
                            ->orderBy('first_name')
                            ->orderBy('last_name')
                            ->get()
                            ->mapWithKeys(fn (User $user): array => [
                                $user->id => $user->full_name . ' - ' . $user->email,
                            ])
                    )
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('subject')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Textarea::make('body')
                    ->label('Message')
                    ->rows(8)
                    ->required()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create(SendMessageAction $action): void
    {
        $sender = Shopper::auth()->user();

        abort_unless($sender, 403);

        $data = $this->form->getState();
        $recipient = User::query()->findOrFail($data['recipient_id']);

        $action->execute(
            sender: $sender,
            recipient: $recipient,
            subject: $data['subject'],
            body: $data['body'],
        );

        Notification::make()
            ->title('Message sent')
            ->success()
            ->send();

        $this->redirectRoute('shopper.messages.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.message.create')
            ->title('Compose Message');
    }
}
