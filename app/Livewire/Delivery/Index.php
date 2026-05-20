<?php

declare(strict_types=1);

namespace App\Livewire\Delivery;

use App\Models\Delivery;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Shopper\Facades\Shopper;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public array $summary = [];

    public function mount(): void
    {
        $this->authorize('viewAny', Delivery::class);

        $this->summary = $this->summary();
    }

    public function table(Table $table): Table
    {
        $user = Shopper::auth()->user();

        return $table
            ->query(
                Delivery::query()
                    ->with(['deliveryPerson', 'order.shippingAddress', 'order.customer'])
                    ->when(
                        $user?->hasRole('delivery_person'),
                        fn (Builder $query) => $query->where('delivery_person_id', $user->id)
                    )
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('tracking_number')
                    ->label('Tracking')
                    ->placeholder('Not set')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order.number')
                    ->label('Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deliveryPerson.full_name')
                    ->label('Delivery Person')
                    ->placeholder('Unassigned')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('order.shippingAddress.city')
                    ->label('Destination')
                    ->placeholder('No address')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'pending',
                        'info' => ['assigned', 'picked_up', 'in_transit'],
                        'success' => 'delivered',
                        'warning' => 'failed',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduled_for')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('delivered_at')
                    ->dateTime()
                    ->placeholder('Not delivered')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('failed_at')
                    ->dateTime()
                    ->placeholder('Not failed')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'assigned' => 'Assigned',
                        'picked_up' => 'Picked up',
                        'in_transit' => 'In transit',
                        'delivered' => 'Delivered',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\Filter::make('unassigned')
                    ->label('Unassigned')
                    ->query(fn (Builder $query): Builder => $query->whereNull('delivery_person_id')),
                Tables\Filters\Filter::make('scheduled_today')
                    ->label('Scheduled today')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('scheduled_for', [now()->startOfDay(), now()->endOfDay()])),
                Tables\Filters\Filter::make('delivered_this_month')
                    ->label('Delivered this month')
                    ->query(fn (Builder $query): Builder => $query
                        ->where('status', 'delivered')
                        ->whereBetween('delivered_at', [now()->startOfMonth(), now()->endOfMonth()])),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Delivery $record): string => route('shopper.deliveries.show', $record)),
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (Delivery $record): string => route('shopper.deliveries.edit', $record))
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false),
                Tables\Actions\Action::make('pickedUp')
                    ->label('Picked up')
                    ->icon('heroicon-o-archive-box-arrow-down')
                    ->color('info')
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && in_array($record->status, ['pending', 'assigned'], true))
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->form([
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                    ])
                    ->action(function (Delivery $record, array $data): void {
                        $record->markPickedUp($data['notes'] ?? null);

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('inTransit')
                    ->label('In transit')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && $record->status === 'picked_up')
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->form([
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                    ])
                    ->action(function (Delivery $record, array $data): void {
                        $record->markInTransit($data['notes'] ?? null);

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('delivered')
                    ->label('Delivered')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && ! in_array($record->status, ['delivered', 'cancelled'], true))
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->form([
                        Forms\Components\TextInput::make('delivered_to')
                            ->label('Delivered To')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                    ])
                    ->action(function (Delivery $record, array $data): void {
                        $record->markDelivered(
                            deliveredTo: $data['delivered_to'] ?? null,
                            notes: $data['notes'] ?? null,
                        );

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('failed')
                    ->label('Failed')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->color('warning')
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && ! in_array($record->status, ['failed', 'delivered', 'cancelled'], true))
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->form([
                        Forms\Components\Textarea::make('failure_reason')
                            ->label('Failure Reason')
                            ->rows(3),
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                    ])
                    ->action(function (Delivery $record, array $data): void {
                        $record->markFailed(
                            failureReason: $data['failure_reason'] ?? null,
                            notes: $data['notes'] ?? null,
                        );

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && $record->status !== 'cancelled')
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->form([
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                    ])
                    ->action(function (Delivery $record, array $data): void {
                        $record->cancel($data['notes'] ?? null);

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('delete', $record) ?? false),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('markDelivered')
                    ->label('Mark delivered')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->action(function ($records): void {
                        $records
                            ->filter(fn (Delivery $delivery): bool => auth()->user()?->can('update', $delivery) && ! in_array($delivery->status, ['delivered', 'cancelled'], true))
                            ->each(fn (Delivery $delivery) => $delivery->markDelivered());

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn (): bool => auth()->user()?->can('delete_deliveries') ?? false),
            ])
            ->filtersFormWidth(MaxWidth::Medium);
    }

    public function render(): View
    {
        return view('livewire.delivery.index')
            ->title('Deliveries');
    }

    private function summary(): array
    {
        $user = Shopper::auth()->user();

        $query = Delivery::query()
            ->when(
                $user?->hasRole('delivery_person'),
                fn (Builder $query) => $query->where('delivery_person_id', $user->id)
            );

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->whereIn('status', ['pending', 'assigned'])->count(),
            'in_progress' => (clone $query)->whereIn('status', ['picked_up', 'in_transit'])->count(),
            'delivered' => (clone $query)->where('status', 'delivered')->count(),
            'failed' => (clone $query)->where('status', 'failed')->count(),
            'scheduled_today' => (clone $query)->whereBetween('scheduled_for', [now()->startOfDay(), now()->endOfDay()])->count(),
        ];
    }
}
