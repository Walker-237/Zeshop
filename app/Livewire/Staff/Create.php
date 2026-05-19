<?php

declare(strict_types=1);

namespace App\Livewire\Staff;

use App\Actions\User\CreateStaffUserAction;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Shopper\Core\Models\Role;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Create extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->authorize('view_users');

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(table: 'users', column: 'email')
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->minLength(8)
                    ->hintAction(
                        Forms\Components\Actions\Action::make('generate')
                            ->label('Generate')
                            ->action(fn (Forms\Set $set): mixed => $set('password', Str::password(16)))
                    ),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Select::make('role_id')
                    ->label('Role')
                    ->options($this->roleOptions())
                    ->required()
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function create(CreateStaffUserAction $action): void
    {
        $user = $action->execute($this->form->getState());

        Notification::make()
            ->title('Staff user created')
            ->body($user->full_name . ' can now access the admin panel.')
            ->success()
            ->send();

        $this->redirectRoute('shopper.settings.users', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.staff.create')
            ->title('Create Staff User');
    }

    private function roleOptions(): array
    {
        return Role::query()
            ->whereIn('name', [
                config('shopper.core.users.admin_role'),
                config('shopper.core.users.manager_role'),
                config('shopper.core.users.default_role'),
                'accountant',
                'stock_manager',
                'delivery_person',
                'seller',
            ])
            ->orderBy('display_name')
            ->pluck('display_name', 'id')
            ->all();
    }
}
