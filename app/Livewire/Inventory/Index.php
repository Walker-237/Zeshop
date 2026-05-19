<?php

declare(strict_types=1);

namespace App\Livewire\Inventory;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopper\Core\Models\Product;

class Index extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->with(['brand', 'inventoryHistories'])
                    ->where('is_visible', true)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->placeholder('—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => match (true) {
                        $record->stock <= 0 => 'danger',
                        $record->stock <= ($record->security_stock ?? 5) => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('security_stock')
                    ->label('Safety Stock')
                    ->placeholder('—'),
                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stock_status')
                    ->label('Stock Status')
                    ->options([
                        'in_stock'  => 'In Stock',
                        'low_stock' => 'Low Stock',
                        'out'       => 'Out of Stock',
                    ])
                    ->query(function ($query, $data) {
                        if (! $data['value']) {
                            return;
                        }
                        $ids = Product::all()->filter(function ($p) use ($data) {
                            return match ($data['value']) {
                                'out'       => $p->stock <= 0,
                                'low_stock' => $p->stock > 0 && $p->stock <= ($p->security_stock ?? 5),
                                'in_stock'  => $p->stock > ($p->security_stock ?? 5),
                                default     => true,
                            };
                        })->pluck('id');
                        $query->whereIn('id', $ids);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('adjust')
                    ->label('Adjust Stock')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->url(fn (Product $record) => route('inventory.adjust', $record->id)),
            ])
            ->defaultSort('name');
    }

    public function render(): View
    {
        return view('livewire.inventory.index');
    }
}