<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table): void {
            $table->timestamp('failed_at')->nullable()->after('delivered_at');
            $table->timestamp('cancelled_at')->nullable()->after('failed_at');
            $table->string('delivered_to')->nullable()->after('cancelled_at');
            $table->text('failure_reason')->nullable()->after('delivered_to');
        });
    }

    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table): void {
            $table->dropColumn([
                'failed_at',
                'cancelled_at',
                'delivered_to',
                'failure_reason',
            ]);
        });
    }
};
