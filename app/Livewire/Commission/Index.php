<?php

declare(strict_types=1);

namespace App\Livewire\Commission;

use App\Models\Commission;
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
        $this->authorize('viewAny', Commission::class);

        $this->summary = $this->summary();
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
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime()
                    ->placeholder('Not paid')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('payment_reference')
                    ->label('Reference')
                    ->placeholder('None')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\Filter::make('unpaid')
                    ->label('Unpaid')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'pending')),
                Tables\Filters\Filter::make('paid_this_month')
                    ->label('Paid this month')
                    ->query(fn (Builder $query): Builder => $query
                        ->where('status', 'paid')
                        ->whereBetween('paid_at', [now()->startOfMonth(), now()->endOfMonth()])),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Commission $record): string => route('shopper.commissions.show', $record)),
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (Commission $record): string => route('shopper.commissions.edit', $record))
                    ->visible(fn (Commission $record): bool => auth()->user()?->can('update', $record) ?? false),
                Tables\Actions\Action::make('markPaid')
                    ->label('Mark paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Commission $record): bool => auth()->user()?->can('update', $record) && $record->status !== 'paid')
                    ->authorize(fn (Commission $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->form([
                        Forms\Components\TextInput::make('payment_reference')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                    ])
                    ->action(function (Commission $record, array $data): void {
                        $record->markPaid(
                            paymentReference: $data['payment_reference'] ?? null,
                            notes: $data['notes'] ?? null,
                        );

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Commission $record): bool => auth()->user()?->can('update', $record) && $record->status !== 'cancelled')
                    ->authorize(fn (Commission $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->form([
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                    ])
                    ->action(function (Commission $record, array $data): void {
                        $record->cancel($data['notes'] ?? null);

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Commission $record): bool => auth()->user()?->can('delete', $record) ?? false),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('markPaid')
                    ->label('Mark paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->action(function ($records): void {
                        $records
                            ->filter(fn (Commission $commission): bool => auth()->user()?->can('update', $commission) && $commission->status !== 'paid')
                            ->each(fn (Commission $commission) => $commission->markPaid());

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn (): bool => auth()->user()?->can('delete_commissions') ?? false),
            ])
            ->filtersFormWidth(MaxWidth::Medium);
    }

    public function render(): View
    {
        return view('livewire.commission.index')
            ->title('Commissions');
    }

    private function summary(): array
    {
        $query = Commission::query();

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'paid' => (clone $query)->where('status', 'paid')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
            'pending_amount' => (float) (clone $query)->where('status', 'pending')->sum('amount'),
            'paid_amount' => (float) (clone $query)->where('status', 'paid')->sum('amount'),
        ];
    }
}
