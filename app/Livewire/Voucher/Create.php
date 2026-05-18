<?php

declare(strict_types=1);

namespace App\Livewire\Voucher;

use App\Actions\Voucher\GenerateVoucherAction;
use App\Models\User;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Core\Models\Order;
use Shopper\Facades\Shopper;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Create extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->authorize('create', Voucher::class);

        $this->form->fill([
            'currency_code' => 'USD',
            'status' => 'issued',
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
                            ->with('items')
                            ->latest()
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn (Order $order): array => [
                                $order->id => $order->number . ' - ' . $order->currency_code . ' ' . number_format($order->total() / 100, 2),
                            ])
                    )
                    ->searchable()
                    ->helperText('Optional. Leave empty for a manual voucher.'),
                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->options(
                        User::query()
                            ->orderBy('first_name')
                            ->orderBy('last_name')
                            ->get()
                            ->mapWithKeys(fn (User $user): array => [
                                $user->id => $user->full_name . ' - ' . $user->email,
                            ])
                    )
                    ->searchable()
                    ->helperText('Optional when an order is selected.'),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->minValue(0)
                    ->helperText('Leave empty to use the selected order total.'),
                Forms\Components\TextInput::make('currency_code')
                    ->label('Currency')
                    ->maxLength(3)
                    ->required(),
                Forms\Components\TextInput::make('payment_method')
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'issued' => 'Issued',
                        'paid' => 'Paid',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create(GenerateVoucherAction $action): void
    {
        $data = $this->form->getState();

        $order = filled($data['order_id'] ?? null)
            ? Order::query()->with(['items', 'customer'])->findOrFail($data['order_id'])
            : null;
        $customer = filled($data['customer_id'] ?? null)
            ? User::query()->findOrFail($data['customer_id'])
            : null;

        $action->execute(
            order: $order,
            customer: $customer,
            issuedBy: Shopper::auth()->user(),
            amount: filled($data['amount'] ?? null) ? (float) $data['amount'] : null,
            currencyCode: $data['currency_code'] ?? null,
            paymentMethod: $data['payment_method'] ?? null,
            status: $data['status'],
            notes: $data['notes'] ?? null,
        );

        Notification::make()
            ->title('Voucher generated')
            ->success()
            ->send();

        $this->redirectRoute('shopper.vouchers.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.voucher.create')
            ->title('Generate Voucher');
    }
}
