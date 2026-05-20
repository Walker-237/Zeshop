<?php

declare(strict_types=1);

namespace App\Actions\Report;

use App\Models\Commission;
use App\Models\Delivery;
use App\Models\Inventory;
use App\Models\Message;
use App\Models\Voucher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Shopper\Core\Models\InventoryHistory;
use Shopper\Core\Models\Order;
use Shopper\Core\Models\OrderItem;
use Shopper\Core\Models\Product;

final class BuildOperationalOverviewAction
{
    public function execute(?Carbon $start = null, ?Carbon $end = null): array
    {
        $start ??= now()->subDays(30)->startOfDay();
        $end ??= now()->endOfDay();

        return [
            'period' => [
                'start' => $start,
                'end' => $end,
            ],
            'summary' => $this->summary($start, $end),
            'orders_by_status' => $this->ordersByStatus($start, $end),
            'top_products' => $this->topProducts($start, $end),
            'recent_stock_movements' => $this->recentStockMovements(),
            'low_stock_products' => $this->lowStockProducts(),
        ];
    }

    private function summary(Carbon $start, Carbon $end): array
    {
        $orders = Order::query()
            ->with('items')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $revenue = $orders->sum(fn (Order $order): float => $order->total() / 100);
        $totalStock = Inventory::query()
            ->withSum('histories as stock_on_hand', 'quantity')
            ->get()
            ->sum('stock_on_hand');

        return [
            'orders_count' => $orders->count(),
            'total_revenue' => round($revenue, 2),
            'average_order_value' => $orders->count() ? round($revenue / $orders->count(), 2) : 0.0,
            'products_count' => Product::query()->count(),
            'stock_on_hand' => (int) $totalStock,
            'low_stock_count' => $this->lowStockProducts()->count(),
            'deliveries_in_progress' => Delivery::query()->whereIn('status', ['assigned', 'picked_up', 'in_transit'])->count(),
            'failed_deliveries' => Delivery::query()->where('status', 'failed')->count(),
            'pending_commission_amount' => round((float) Commission::query()->where('status', 'pending')->sum('amount'), 2),
            'unread_messages' => Message::query()->whereNull('read_at')->whereNull('archived_at')->count(),
            'issued_vouchers' => Voucher::query()->where('status', 'issued')->count(),
        ];
    }

    private function ordersByStatus(Carbon $start, Carbon $end): array
    {
        return Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy(fn (Order $order): string => (string) $order->status->value)
            ->map->count()
            ->all();
    }

    private function topProducts(Carbon $start, Carbon $end): Collection
    {
        $itemsTable = (new OrderItem())->getTable();
        $ordersTable = (new Order())->getTable();

        if (! Schema::hasTable($itemsTable) || ! Schema::hasTable($ordersTable)) {
            return collect();
        }

        return DB::table($itemsTable . ' as items')
            ->join($ordersTable . ' as orders', 'orders.id', '=', 'items.order_id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select([
                'items.name',
                'items.sku',
                DB::raw('SUM(items.quantity) as units_sold'),
                DB::raw('SUM(items.quantity * items.unit_price_amount) / 100 as revenue'),
            ])
            ->groupBy('items.name', 'items.sku')
            ->orderByDesc('units_sold')
            ->limit(8)
            ->get()
            ->map(fn ($row): array => [
                'name' => $row->name ?: 'Unknown product',
                'sku' => $row->sku ?: 'N/A',
                'units_sold' => (int) $row->units_sold,
                'revenue' => round((float) $row->revenue, 2),
            ]);
    }

    private function recentStockMovements(): Collection
    {
        return InventoryHistory::query()
            ->with(['inventory', 'stockable', 'user'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(fn (InventoryHistory $history): array => [
                'created_at' => $history->created_at,
                'product' => $history->stockable?->name ?? 'Unknown item',
                'inventory' => $history->inventory?->name ?? 'Unknown inventory',
                'quantity' => (int) $history->quantity,
                'old_quantity' => (int) $history->old_quantity,
                'event' => $history->event ?? 'stock_movement',
                'user' => $history->user?->full_name ?? 'System',
                'description' => $history->description,
            ]);
    }

    private function lowStockProducts(): Collection
    {
        return Product::query()
            ->withSum('inventoryHistories as stock_on_hand', 'quantity')
            ->whereNotNull('security_stock')
            ->orderBy('name')
            ->get()
            ->filter(fn (Product $product): bool => (int) ($product->stock_on_hand ?? 0) <= (int) $product->security_stock)
            ->take(8)
            ->values()
            ->map(fn (Product $product): array => [
                'name' => $product->name,
                'sku' => $product->sku ?: 'N/A',
                'stock_on_hand' => (int) ($product->stock_on_hand ?? 0),
                'security_stock' => (int) $product->security_stock,
            ]);
    }
}
