<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table): void {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('id')
                ->constrained('messages')
                ->nullOnDelete();
            $table->timestamp('starred_at')->nullable()->after('archived_at');

            $table->index(['parent_id', 'created_at']);
            $table->index(['recipient_id', 'archived_at']);
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table): void {
            $table->dropIndex('messages_parent_id_created_at_index');
            $table->dropIndex('messages_recipient_id_archived_at_index');
            $table->dropConstrainedForeignId('parent_id');
            $table->dropColumn('starred_at');
        });
    }
};
