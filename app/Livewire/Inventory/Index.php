<?php

declare(strict_types=1);

namespace App\Livewire\Inventory;

use App\Actions\Inventory\GetInventoryDashboardAction;
use Illuminate\Contracts\View\View;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent
{
    public function mount(): void
    {
        $this->authorize('browse_inventories');
    }

    public function render(GetInventoryDashboardAction $dashboard): View
    {
        return view('livewire.inventory.index', $dashboard->execute())
            ->title('Inventory');
    }
}
