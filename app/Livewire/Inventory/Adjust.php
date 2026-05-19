<?php

declare(strict_types=1);

namespace App\Livewire\Inventory;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopper\Core\Models\Inventory;
use Shopper\Core\Models\Product;

class Adjust extends Component
{
    public Product $product;
    public int $quantity = 0;
    public int $inventoryId;
    public string $description = '';

    public function mount(int $productId): void
    {
        $this->product = Product::with('inventoryHistories')->findOrFail($productId);
        $this->inventoryId = Inventory::scoped()->default()->first()?->id
            ?? Inventory::first()?->id;
        $this->quantity = $this->product->stock;
    }

    public function save(): void
    {
        $this->validate([
            'quantity'    => 'required|integer|min:0',
            'inventoryId' => 'required|exists:sh_inventories,id',
            'description' => 'nullable|string|max:255',
        ]);

        $this->product->setStock($this->quantity, $this->inventoryId, [
            'description' => $this->description ?: 'Manual stock adjustment',
            'event'       => 'manual_adjustment',
        ]);

        session()->flash('success', 'Stock updated successfully.');

        $this->redirect(route('inventory.index'));
    }

    public function render(): View
    {
        return view('livewire.inventory.adjust', [
            'inventories' => Inventory::all(),
            'histories'   => $this->product->inventoryHistories()->latest()->take(10)->get(),
        ]);
    }
}