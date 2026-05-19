<?php

declare(strict_types=1);

namespace App\Livewire\Commission;

use App\Models\Commission;
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
        $this->authorize('viewAny', Commission::class);
    }

    public function table(Table $table): Table
    {
        $user = Shopper::auth()->user();

        return $table
            ->query(
                Commission::query()
                    ->with(['seller', 'order'])
                    ->when(
                        $user?->hasRole('seller') && ! $user->can('edit_commissions'),
                        fn (Builder $query) => $query->where('seller_id', $user->id)
                    )
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('seller.full_name')
                    ->label('Seller')
                    ->placeholder('Unassigned')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('order.number')
                    ->label('Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('markPaid')
                    ->label('Mark paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Commission $record): bool => auth()->user()?->can('update', $record) && $record->status !== 'paid')
                    ->authorize(fn (Commission $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(fn (Commission $record) => $record->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ])),
                Tables\Actions\Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Commission $record): bool => auth()->user()?->can('update', $record) && $record->status !== 'cancelled')
                    ->authorize(fn (Commission $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(fn (Commission $record) => $record->update([
                        'status' => 'cancelled',
                    ])),
            ])
            ->filtersFormWidth(MaxWidth::Medium);
    }

    public function render(): View
    {
        return view('livewire.commission.index')
            ->title('Commissions');
    }
}
