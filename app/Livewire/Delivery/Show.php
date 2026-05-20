<?php

declare(strict_types=1);

namespace App\Livewire\Delivery;

use App\Models\Delivery;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Show extends AbstractPageComponent
{
    public Delivery $delivery;

    public function mount(Delivery $delivery): void
    {
        $this->authorize('view', $delivery);

        $this->delivery = $delivery->load(['deliveryPerson', 'order.items', 'order.customer', 'order.shippingAddress']);
    }

    public function markPickedUp(): void
    {
        $this->authorize('update', $this->delivery);

        $this->delivery->markPickedUp();
        $this->refreshDelivery();

        Notification::make()
            ->title('Delivery marked as picked up')
            ->success()
            ->send();
    }

    public function markInTransit(): void
    {
        $this->authorize('update', $this->delivery);

        $this->delivery->markInTransit();
        $this->refreshDelivery();

        Notification::make()
            ->title('Delivery marked as in transit')
            ->success()
            ->send();
    }

    public function markDelivered(): void
    {
        $this->authorize('update', $this->delivery);

        $this->delivery->markDelivered();
        $this->refreshDelivery();

        Notification::make()
            ->title('Delivery marked as delivered')
            ->success()
            ->send();
    }

    public function cancel(): void
    {
        $this->authorize('update', $this->delivery);

        $this->delivery->cancel();
        $this->refreshDelivery();

        Notification::make()
            ->title('Delivery cancelled')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.delivery.show')
            ->title('Delivery Details');
    }

    private function refreshDelivery(): void
    {
        $this->delivery = $this->delivery
            ->refresh()
            ->load(['deliveryPerson', 'order.items', 'order.customer', 'order.shippingAddress']);
    }
}
