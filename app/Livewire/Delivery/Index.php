<?php

declare(strict_types=1);

namespace App\Livewire\Delivery;

use App\Models\Delivery;
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

    public function mount(): void
    {
        $this->authorize('viewAny', Delivery::class);
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
            ])
            ->actions([
                Tables\Actions\Action::make('pickedUp')
                    ->label('Picked up')
                    ->icon('heroicon-o-archive-box-arrow-down')
                    ->color('info')
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && in_array($record->status, ['pending', 'assigned'], true))
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(fn (Delivery $record) => $record->update([
                        'status' => 'picked_up',
                        'picked_up_at' => now(),
                    ])),
                Tables\Actions\Action::make('inTransit')
                    ->label('In transit')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && $record->status === 'picked_up')
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(fn (Delivery $record) => $record->update([
                        'status' => 'in_transit',
                    ])),
                Tables\Actions\Action::make('delivered')
                    ->label('Delivered')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && $record->status !== 'delivered')
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(fn (Delivery $record) => $record->update([
                        'status' => 'delivered',
                        'delivered_at' => now(),
                    ])),
                Tables\Actions\Action::make('failed')
                    ->label('Failed')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Delivery $record): bool => auth()->user()?->can('update', $record) && ! in_array($record->status, ['failed', 'delivered'], true))
                    ->authorize(fn (Delivery $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(fn (Delivery $record) => $record->update([
                        'status' => 'failed',
                    ])),
            ])
            ->filtersFormWidth(MaxWidth::Medium);
    }

    public function render(): View
    {
        return view('livewire.delivery.index')
            ->title('Deliveries');
    }
}
