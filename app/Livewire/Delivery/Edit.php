<?php

declare(strict_types=1);

namespace App\Livewire\Delivery;

use App\Actions\Delivery\UpdateDeliveryAction;
use App\Models\Delivery;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Core\Models\Order;
use Shopper\Livewire\Pages\AbstractPageComponent;
use Spatie\Permission\Models\Role;

class Edit extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public Delivery $delivery;

    public ?array $data = [];

    public function mount(Delivery $delivery): void
    {
        $this->authorize('update', $delivery);

        $this->delivery = $delivery->load(['order.items', 'deliveryPerson']);

        $this->form->fill([
            'order_id' => $delivery->order_id,
            'delivery_person_id' => $delivery->delivery_person_id,
            'tracking_number' => $delivery->tracking_number,
            'status' => $delivery->status,
            'scheduled_for' => $delivery->scheduled_for,
            'delivered_to' => $delivery->delivered_to,
            'failure_reason' => $delivery->failure_reason,
            'notes' => $delivery->notes,
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
                Forms\Components\Select::make('delivery_person_id')
                    ->label('Delivery Person')
                    ->options($this->deliveryPersonOptions())
                    ->searchable(),
                Forms\Components\TextInput::make('tracking_number')
                    ->label('Tracking Number')
                    ->maxLength(255)
                    ->unique(table: 'deliveries', column: 'tracking_number', ignoreRecord: true),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'assigned' => 'Assigned',
                        'picked_up' => 'Picked up',
                        'in_transit' => 'In transit',
                        'delivered' => 'Delivered',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('scheduled_for')
                    ->label('Scheduled For')
                    ->seconds(false),
                Forms\Components\TextInput::make('delivered_to')
                    ->label('Delivered To')
                    ->maxLength(255)
                    ->visible(fn (Forms\Get $get): bool => $get('status') === 'delivered'),
                Forms\Components\Textarea::make('failure_reason')
                    ->rows(3)
                    ->visible(fn (Forms\Get $get): bool => $get('status') === 'failed')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data')
            ->model($this->delivery);
    }

    public function update(UpdateDeliveryAction $action): void
    {
        $data = $this->form->getState();

        $order = Order::query()->findOrFail($data['order_id']);
        $deliveryPerson = filled($data['delivery_person_id'] ?? null)
            ? User::query()->findOrFail($data['delivery_person_id'])
            : null;

        $delivery = $action->execute(
            delivery: $this->delivery,
            order: $order,
            deliveryPerson: $deliveryPerson,
            trackingNumber: $data['tracking_number'] ?? null,
            status: $data['status'],
            scheduledFor: $data['scheduled_for'] ?? null,
            deliveredTo: $data['delivered_to'] ?? null,
            failureReason: $data['failure_reason'] ?? null,
            notes: $data['notes'] ?? null,
        );

        Notification::make()
            ->title('Delivery updated')
            ->success()
            ->send();

        $this->redirectRoute('shopper.deliveries.show', $delivery, navigate: true);
    }

    public function render(): View
    {
        return view('livewire.delivery.edit')
            ->title('Edit Delivery');
    }

    private function orderOptions(): array
    {
        return Order::query()
            ->with('items')
            ->where(function ($query): void {
                $query
                    ->where('id', $this->delivery->order_id)
                    ->orWhereNotIn('id', Delivery::query()->whereKeyNot($this->delivery->getKey())->select('order_id'));
            })
            ->latest()
            ->limit(100)
            ->get()
            ->mapWithKeys(fn (Order $order): array => [
                $order->id => $order->number . ' - ' . $order->currency_code . ' ' . number_format($order->total() / 100, 2),
            ])
            ->all();
    }

    private function deliveryPersonOptions(): array
    {
        $query = User::query()
            ->orderBy('first_name')
            ->orderBy('last_name');

        if (Role::query()->where('name', 'delivery_person')->exists()) {
            $query->role('delivery_person');
        }

        return $query
            ->get()
            ->mapWithKeys(fn (User $user): array => [
                $user->id => $user->full_name . ' - ' . $user->email,
            ])
            ->all();
    }
}
