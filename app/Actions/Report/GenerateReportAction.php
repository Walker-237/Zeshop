<?php

declare(strict_types=1);

namespace App\Actions\Report;

use App\Models\Commission;
use App\Models\Delivery;
use App\Models\Inventory;
use App\Models\Report;
use Illuminate\Support\Carbon;
use Shopper\Core\Models\Order;
use Shopper\Core\Models\Product;

final class GenerateReportAction
{
    public function execute(string $type, string $title, ?string $periodStart = null, ?string $periodEnd = null): Report
    {
        $start = $periodStart ? Carbon::parse($periodStart)->startOfDay() : null;
        $end = $periodEnd ? Carbon::parse($periodEnd)->endOfDay() : null;

        return Report::query()->create([
            'generated_by' => auth()->id(),
            'title' => $title,
            'type' => $type,
            'period_start' => $start,
            'period_end' => $end,
            'summary' => $this->summaryFor($type, $start, $end),
            'generated_at' => now(),
        ]);
    }

    protected function summaryFor(string $type, ?Carbon $start, ?Carbon $end): array
    {
        return match ($type) {
            'sales' => $this->salesSummary($start, $end),
            'commissions' => $this->commissionSummary($start, $end),
            'deliveries' => $this->deliverySummary($start, $end),
            'inventory' => $this->inventorySummary(),
            default => [],
        };
    }

    protected function salesSummary(?Carbon $start, ?Carbon $end): array
    {
        $orders = Order::query()
            ->with('items')
            ->when($start, fn ($query) => $query->where('created_at', '>=', $start))
            ->when($end, fn ($query) => $query->where('created_at', '<=', $end))
            ->get();

        $revenue = $orders->sum(fn (Order $order): float => $order->total() / 100);

        return [
            'orders_count' => $orders->count(),
            'total_revenue' => round($revenue, 2),
            'average_order_value' => $orders->count() ? round($revenue / $orders->count(), 2) : 0,
            'orders_by_status' => $orders
                ->groupBy(fn (Order $order): string => (string) $order->status->value)
                ->map->count()
                ->all(),
        ];
    }

    protected function commissionSummary(?Carbon $start, ?Carbon $end): array
    {
        $commissions = Commission::query()
            ->when($start, fn ($query) => $query->where('created_at', '>=', $start))
            ->when($end, fn ($query) => $query->where('created_at', '<=', $end))
            ->get();

        return [
            'commissions_count' => $commissions->count(),
            'total_amount' => round((float) $commissions->sum('amount'), 2),
            'pending_amount' => round((float) $commissions->where('status', 'pending')->sum('amount'), 2),
            'paid_amount' => round((float) $commissions->where('status', 'paid')->sum('amount'), 2),
            'cancelled_amount' => round((float) $commissions->where('status', 'cancelled')->sum('amount'), 2),
            'commissions_by_status' => $commissions->groupBy('status')->map->count()->all(),
        ];
    }

    protected function deliverySummary(?Carbon $start, ?Carbon $end): array
    {
        $deliveries = Delivery::query()
            ->when($start, fn ($query) => $query->where('created_at', '>=', $start))
            ->when($end, fn ($query) => $query->where('created_at', '<=', $end))
            ->get();

        return [
            'deliveries_count' => $deliveries->count(),
            'scheduled_count' => $deliveries->whereNotNull('scheduled_for')->count(),
            'delivered_count' => $deliveries->where('status', 'delivered')->count(),
            'failed_count' => $deliveries->where('status', 'failed')->count(),
            'deliveries_by_status' => $deliveries->groupBy('status')->map->count()->all(),
        ];
    }

    protected function inventorySummary(): array
    {
        $inventories = Inventory::query()
            ->withSum('histories as stock_on_hand', 'quantity')
            ->get();

        $lowStockProducts = Product::query()
            ->withSum('inventoryHistories as stock_on_hand', 'quantity')
            ->whereNotNull('security_stock')
            ->get()
            ->filter(fn (Product $product): bool => (int) ($product->stock_on_hand ?? 0) <= (int) $product->security_stock);

        return [
            'locations_count' => $inventories->count(),
            'total_stock' => (int) $inventories->sum('stock_on_hand'),
            'low_stock_products_count' => $lowStockProducts->count(),
            'stock_by_location' => $inventories
                ->mapWithKeys(fn (Inventory $inventory): array => [
                    $inventory->name => (int) ($inventory->stock_on_hand ?? 0),
                ])
                ->all(),
        ];
    }
}
