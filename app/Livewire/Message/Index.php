<?php

declare(strict_types=1);

namespace App\Livewire\Message;

use App\Models\Message;
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
        $this->authorize('viewAny', Message::class);

        $this->summary = $this->summary();
    }

    public function table(Table $table): Table
    {
        $user = Shopper::auth()->user();

        return $table
            ->query(
                Message::query()
                    ->with(['sender', 'recipient'])
                    ->when($user, fn (Builder $query) => $query->visibleTo($user))
                    ->latest()
            )
            ->columns([
                Tables\Columns\IconColumn::make('read_at')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('primary')
                    ->state(fn (Message $record): bool => filled($record->read_at)),
                Tables\Columns\IconColumn::make('starred_at')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->state(fn (Message $record): bool => filled($record->starred_at)),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->weight(fn (Message $record): string => blank($record->read_at) ? 'bold' : 'medium')
                    ->description(fn (Message $record): string => str($record->body)->limit(90)->toString())
                    ->prefix(fn (Message $record): string => $record->parent_id ? 'Re: ' : ''),
                Tables\Columns\TextColumn::make('sender.full_name')
                    ->label('From')
                    ->placeholder('System')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('recipient.full_name')
                    ->label('To')
                    ->placeholder('Unknown')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Sent')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('archived_at')
                    ->label('Archived')
                    ->dateTime()
                    ->placeholder('No')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('unread')
                    ->label('Unread')
                    ->query(fn (Builder $query): Builder => $query->whereNull('read_at')),
                Tables\Filters\Filter::make('starred')
                    ->label('Starred')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('starred_at')),
                Tables\Filters\Filter::make('archived')
                    ->label('Archived')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('archived_at')),
                Tables\Filters\Filter::make('active')
                    ->label('Active')
                    ->query(fn (Builder $query): Builder => $query->whereNull('archived_at'))
                    ->default(),
                Tables\Filters\SelectFilter::make('mailbox')
                    ->options([
                        'inbox' => 'Inbox',
                        'sent' => 'Sent',
                    ])
                    ->query(function (Builder $query, array $data) use ($user): Builder {
                        if (! $user || blank($data['value'] ?? null)) {
                            return $query;
                        }

                        return $data['value'] === 'sent'
                            ? $query->where('sender_id', $user->id)
                            : $query->where('recipient_id', $user->id);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Message $record): string => route('shopper.messages.thread', $record))
                    ->openUrlInNewTab(false),
                Tables\Actions\Action::make('star')
                    ->label('Star')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->visible(fn (Message $record): bool => auth()->user()?->can('update', $record) && blank($record->starred_at))
                    ->authorize(fn (Message $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(function (Message $record): void {
                        $record->star();

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('unstar')
                    ->label('Unstar')
                    ->icon('heroicon-s-star')
                    ->visible(fn (Message $record): bool => auth()->user()?->can('update', $record) && filled($record->starred_at))
                    ->authorize(fn (Message $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(function (Message $record): void {
                        $record->unstar();

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('markRead')
                    ->label('Mark read')
                    ->icon('heroicon-o-envelope-open')
                    ->color('success')
                    ->visible(fn (Message $record): bool => auth()->user()?->can('update', $record) && blank($record->read_at))
                    ->authorize(fn (Message $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(function (Message $record): void {
                        $record->markRead();

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('markUnread')
                    ->label('Mark unread')
                    ->icon('heroicon-o-envelope')
                    ->visible(fn (Message $record): bool => auth()->user()?->can('update', $record) && filled($record->read_at))
                    ->authorize(fn (Message $record): bool => auth()->user()?->can('update', $record) ?? false)
                    ->action(function (Message $record): void {
                        $record->markUnread();

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Message $record): bool => auth()->user()?->can('delete', $record) && blank($record->archived_at))
                    ->authorize(fn (Message $record): bool => auth()->user()?->can('delete', $record) ?? false)
                    ->action(function (Message $record): void {
                        $record->archive();

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->visible(fn (Message $record): bool => auth()->user()?->can('delete', $record) && filled($record->archived_at))
                    ->authorize(fn (Message $record): bool => auth()->user()?->can('delete', $record) ?? false)
                    ->action(function (Message $record): void {
                        $record->restore();

                        $this->summary = $this->summary();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('markRead')
                    ->label('Mark read')
                    ->icon('heroicon-o-envelope-open')
                    ->deselectRecordsAfterCompletion()
                    ->action(function ($records): void {
                        $records
                            ->filter(fn (Message $message): bool => auth()->user()?->can('update', $message))
                            ->each(fn (Message $message) => $message->markRead());

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\BulkAction::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->action(function ($records): void {
                        $records
                            ->filter(fn (Message $message): bool => auth()->user()?->can('delete', $message))
                            ->each(fn (Message $message) => $message->archive());

                        $this->summary = $this->summary();
                    }),
                Tables\Actions\BulkAction::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->deselectRecordsAfterCompletion()
                    ->action(function ($records): void {
                        $records
                            ->filter(fn (Message $message): bool => auth()->user()?->can('delete', $message))
                            ->each(fn (Message $message) => $message->restore());

                        $this->summary = $this->summary();
                    }),
            ])
            ->filtersFormWidth(MaxWidth::Medium);
    }

    public function render(): View
    {
        return view('livewire.message.index')
            ->title('Messages');
    }

    private function summary(): array
    {
        $user = Shopper::auth()->user();

        $query = Message::query()
            ->when($user, fn (Builder $query) => $query->visibleTo($user));

        return [
            'total' => (clone $query)->whereNull('archived_at')->count(),
            'unread' => (clone $query)->whereNull('archived_at')->whereNull('read_at')->count(),
            'sent' => $user ? (clone $query)->whereNull('archived_at')->where('sender_id', $user->id)->count() : 0,
            'starred' => (clone $query)->whereNull('archived_at')->whereNotNull('starred_at')->count(),
            'archived' => (clone $query)->whereNotNull('archived_at')->count(),
        ];
    }
}
