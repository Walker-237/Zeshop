<?php

declare(strict_types=1);

namespace App\Livewire\Staff;

use App\Actions\User\UpdateStaffUserAction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Shopper\Core\Models\Role;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Edit extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public User $user;

    public ?array $data = [];

    public function mount(User $user): void
    {
        $this->authorize('view_users');

        $this->user = $user;

        $this->form->fill([
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'gender' => $user->gender,
            'phone_number' => $user->phone_number,
            'role_id' => $user->roles()->value('id'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(table: 'users', column: 'email', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->helperText('Leave empty to keep the current password.')
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
            ->model($this->user)
            ->statePath('data');
    }

    public function update(UpdateStaffUserAction $action): void
    {
        $user = $action->execute($this->user, $this->form->getState());

        Notification::make()
            ->title('User updated')
            ->body($user->full_name . ' was updated successfully.')
            ->success()
            ->send();

        $this->redirectRoute('shopper.settings.users', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.staff.edit')
            ->title('Edit User');
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
