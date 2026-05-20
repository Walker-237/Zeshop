<?php

declare(strict_types=1);

namespace App\Livewire\Commission;

use App\Models\Commission;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Show extends AbstractPageComponent
{
    public Commission $commission;

    public function mount(Commission $commission): void
    {
        $this->authorize('view', $commission);

        $this->commission = $commission->load(['seller', 'order.items', 'order.customer']);
    }

    public function markPaid(): void
    {
        $this->authorize('update', $this->commission);

        $this->commission->markPaid();
        $this->commission->refresh();

        Notification::make()
            ->title('Commission marked as paid')
            ->success()
            ->send();
    }

    public function cancel(): void
    {
        $this->authorize('update', $this->commission);

        $this->commission->cancel();
        $this->commission->refresh();

        Notification::make()
            ->title('Commission cancelled')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.commission.show')
            ->title('Commission Details');
    }
}
