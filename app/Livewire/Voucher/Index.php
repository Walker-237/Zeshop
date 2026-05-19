<?php

declare(strict_types=1);

namespace App\Livewire\Voucher;

use App\Models\Voucher;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('viewAny', Voucher::class);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Voucher::query()
                    ->with(['order', 'customer', 'issuedBy'])
                    ->latest('issued_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.number')
                    ->label('Order')
                    ->placeholder('Manual')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->placeholder('Walk-in / unknown')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('amount')
                    ->money(fn (Voucher $record): string => $record->currency_code)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'issued',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                        'warning' => 'refunded',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('issued_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'issued' => 'Issued',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                        'refunded' => 'Refunded',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Voucher $record): string => route('shopper.vouchers.show', $record)),
                Tables\Actions\Action::make('markPaid')
                    ->label('Mark paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Voucher $record): bool => auth()->user()?->can('update', $record) && $record->status !== 'paid')
                    ->authorize(fn (Voucher $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(fn (Voucher $record) => $record->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ])),
                Tables\Actions\Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Voucher $record): bool => auth()->user()?->can('update', $record) && ! in_array($record->status, ['cancelled', 'refunded'], true))
                    ->authorize(fn (Voucher $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(fn (Voucher $record) => $record->update([
                        'status' => 'cancelled',
                    ])),
            ])
            ->filtersFormWidth(MaxWidth::Medium);
    }

    public function render(): View
    {
        return view('livewire.voucher.index')
            ->title('Vouchers');
    }
}
