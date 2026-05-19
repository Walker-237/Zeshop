<?php

declare(strict_types=1);

namespace App\Livewire\Delivery;

use App\Actions\Delivery\AssignDeliveryAction;
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

class Create extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->authorize('create', Delivery::class);

        $this->form->fill();
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
                Forms\Components\DateTimePicker::make('scheduled_for')
                    ->label('Scheduled For')
                    ->seconds(false),
                Forms\Components\Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create(AssignDeliveryAction $action): void
    {
        $data = $this->form->getState();

        $order = Order::query()->findOrFail($data['order_id']);
        $deliveryPerson = isset($data['delivery_person_id'])
            ? User::query()->find($data['delivery_person_id'])
            : null;

        $action->execute(
            order: $order,
            deliveryPerson: $deliveryPerson,
            trackingNumber: $data['tracking_number'] ?? null,
            scheduledFor: $data['scheduled_for'] ?? null,
            notes: $data['notes'] ?? null,
        );

        Notification::make()
            ->title('Delivery created')
            ->success()
            ->send();

        $this->redirectRoute('shopper.deliveries.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.delivery.create')
            ->title('Create Delivery');
    }

    protected function orderOptions(): array
    {
        return Order::query()
            ->with(['items'])
            ->whereNotIn('id', Delivery::query()->select('order_id'))
            ->latest()
            ->limit(50)
            ->get()
            ->mapWithKeys(fn (Order $order): array => [
                $order->id => $order->number . ' - ' . $order->currency_code . ' ' . number_format($order->total() / 100, 2),
            ])
            ->all();
    }

    protected function deliveryPersonOptions(): array
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
