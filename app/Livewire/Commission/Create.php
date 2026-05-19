<?php

declare(strict_types=1);

namespace App\Livewire\Commission;

use App\Actions\Commission\CreateCommissionAction;
use App\Models\Commission;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Core\Models\Order;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Create extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->authorize('create', Commission::class);

        $this->form->fill([
            'rate' => 10,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->label('Order')
                    ->options(
                        Order::query()
                            ->latest()
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn (Order $order): array => [
                                $order->id => $order->number . ' - ' . $order->currency_code . ' ' . number_format($order->total() / 100, 2),
                            ])
                    )
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('seller_id')
                    ->label('Seller')
                    ->options(
                        User::query()
                            ->orderBy('first_name')
                            ->orderBy('last_name')
                            ->get()
                            ->mapWithKeys(fn (User $user): array => [
                                $user->id => $user->full_name . ' - ' . $user->email,
                            ])
                    )
                    ->searchable(),
                Forms\Components\TextInput::make('rate')
                    ->label('Rate')
                    ->numeric()
                    ->suffix('%')
                    ->minValue(0)
                    ->maxValue(100)
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->prefix('$')
                    ->helperText('Leave empty to calculate from the order total and rate.'),
                Forms\Components\Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create(CreateCommissionAction $action): void
    {
        $data = $this->form->getState();

        $order = Order::query()->with('items')->findOrFail($data['order_id']);
        $seller = isset($data['seller_id']) ? User::query()->find($data['seller_id']) : null;

        $action->execute(
            order: $order,
            seller: $seller,
            rate: (float) $data['rate'],
            amount: filled($data['amount'] ?? null) ? (float) $data['amount'] : null,
            notes: $data['notes'] ?? null,
        );

        Notification::make()
            ->title('Commission created')
            ->success()
            ->send();

        $this->redirectRoute('shopper.commissions.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.commission.create')
            ->title('Create Commission');
    }
}
