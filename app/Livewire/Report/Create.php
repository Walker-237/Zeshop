<?php

declare(strict_types=1);

namespace App\Livewire\Report;

use App\Actions\Report\GenerateReportAction;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Create extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->authorize('create', Report::class);

        $this->form->fill([
            'type' => 'sales',
            'title' => 'Sales Report - ' . now()->format('Y-m-d'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        'sales' => 'Sales',
                        'commissions' => 'Commissions',
                        'deliveries' => 'Deliveries',
                        'inventory' => 'Inventory',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('period_start')
                    ->label('Period Start')
                    ->native(false),
                Forms\Components\DatePicker::make('period_end')
                    ->label('Period End')
                    ->native(false)
                    ->afterOrEqual('period_start'),
            ])
            ->statePath('data');
    }

    public function create(GenerateReportAction $action): void
    {
        $data = $this->form->getState();

        $action->execute(
            type: $data['type'],
            title: $data['title'],
            periodStart: $data['period_start'] ?? null,
            periodEnd: $data['period_end'] ?? null,
        );

        Notification::make()
            ->title('Report generated')
            ->success()
            ->send();

        $this->redirectRoute('shopper.reports.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.report.create')
            ->title('Generate Report');
    }
}
