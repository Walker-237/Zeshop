<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    protected $fillable = [
        'parent_id',
        'sender_id',
        'recipient_id',
        'subject',
        'body',
        'read_at',
        'archived_at',
        'starred_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'archived_at' => 'datetime',
            'starred_at' => 'datetime',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user): void {
            $query
                ->where('sender_id', $user->id)
                ->orWhere('recipient_id', $user->id);
        });
    }

    public function scopeRootMessages(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function markRead(): bool
    {
        return $this->update([
            'read_at' => $this->read_at ?? now(),
        ]);
    }

    public function markUnread(): bool
    {
        return $this->update([
            'read_at' => null,
        ]);
    }

    public function archive(): bool
    {
        return $this->update([
            'archived_at' => $this->archived_at ?? now(),
        ]);
    }

    public function restore(): bool
    {
        return $this->update([
            'archived_at' => null,
        ]);
    }

    public function star(): bool
    {
        return $this->update([
            'starred_at' => $this->starred_at ?? now(),
        ]);
    }

    public function unstar(): bool
    {
        return $this->update([
            'starred_at' => null,
        ]);
    }
}
