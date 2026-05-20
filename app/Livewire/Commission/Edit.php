<?php

declare(strict_types=1);

namespace App\Livewire\Commission;

use App\Actions\Commission\UpdateCommissionAction;
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

class Edit extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public Commission $commission;

    public ?array $data = [];

    public function mount(Commission $commission): void
    {
        $this->authorize('update', $commission);

        $this->commission = $commission->load(['order.items', 'seller']);

        $this->form->fill([
            'order_id' => $commission->order_id,
            'seller_id' => $commission->seller_id,
            'rate' => $commission->rate,
            'amount' => $commission->amount,
            'status' => $commission->status,
            'payment_reference' => $commission->payment_reference,
            'notes' => $commission->notes,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->label('Order')
                    ->options($this->orderOptions())
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('seller_id')
                    ->label('Seller')
                    ->options($this->sellerOptions())
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
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('payment_reference')
                    ->maxLength(255)
                    ->visible(fn (Forms\Get $get): bool => $get('status') === 'paid'),
                Forms\Components\Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function update(UpdateCommissionAction $action): void
    {
        $data = $this->form->getState();

        $order = Order::query()->with('items')->findOrFail($data['order_id']);
        $seller = filled($data['seller_id'] ?? null)
            ? User::query()->findOrFail($data['seller_id'])
            : null;

        $commission = $action->execute(
            commission: $this->commission,
            order: $order,
            seller: $seller,
            rate: (float) $data['rate'],
            amount: filled($data['amount'] ?? null) ? (float) $data['amount'] : null,
            status: $data['status'],
            paymentReference: $data['payment_reference'] ?? null,
            notes: $data['notes'] ?? null,
        );

        Notification::make()
            ->title('Commission updated')
            ->success()
            ->send();

        $this->redirectRoute('shopper.commissions.show', $commission, navigate: true);
    }

    public function render(): View
    {
        return view('livewire.commission.edit')
            ->title('Edit Commission');
    }

    private function orderOptions(): array
    {
        return Order::query()
            ->with('items')
            ->latest()
            ->limit(100)
            ->get()
            ->mapWithKeys(fn (Order $order): array => [
                $order->id => $order->number . ' - ' . $order->currency_code . ' ' . number_format($order->total() / 100, 2),
            ])
            ->all();
    }

    private function sellerOptions(): array
    {
        return User::query()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get()
            ->mapWithKeys(fn (User $user): array => [
                $user->id => $user->full_name . ' - ' . $user->email,
            ])
            ->all();
    }
}
