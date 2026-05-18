<?php

declare(strict_types=1);

namespace App\Actions\Inventory;

use App\Models\Inventory;
use Illuminate\Support\Collection;
use Shopper\Core\Models\InventoryHistory;
use Shopper\Core\Models\Product;
use Shopper\Core\Models\ProductVariant;

final class GetInventoryDashboardAction
{
    /**
     * @return array{
     *     inventories: Collection<int, Inventory>,
     *     recentMovements: Collection<int, InventoryHistory>,
     *     lowStockProducts: Collection<int, Product>,
     *     totalStock: int,
     *     productCount: int,
     *     variantCount: int
     * }
     */
    public function execute(): array
    {
        $inventories = Inventory::query()
            ->with('country')
            ->withSum('histories as stock_on_hand', 'quantity')
            ->orderByDesc('is_default')
            ->orderBy('priority')
            ->orderBy('name')
            ->get();

        $recentMovements = InventoryHistory::query()
            ->with(['inventory', 'stockable', 'user'])
            ->latest()
            ->limit(12)
            ->get();

        $lowStockProducts = Product::query()
            ->withSum('inventoryHistories as stock_on_hand', 'quantity')
            ->whereNotNull('security_stock')
            ->orderBy('name')
            ->get()
            ->filter(fn (Product $product): bool => (int) ($product->stock_on_hand ?? 0) <= (int) $product->security_stock)
            ->take(8)
            ->values();

        return [
            'inventories' => $inventories,
            'recentMovements' => $recentMovements,
            'lowStockProducts' => $lowStockProducts,
            'totalStock' => (int) $inventories->sum('stock_on_hand'),
            'productCount' => Product::query()->count(),
            'variantCount' => ProductVariant::query()->count(),
        ];
    }
}
