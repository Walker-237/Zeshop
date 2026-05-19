<?php

declare(strict_types=1);

use App\Livewire\Inventory\Index as InventoryIndex;
use App\Livewire\Commission\Create as CommissionCreate;
use App\Livewire\Commission\Index as CommissionIndex;
use App\Livewire\Delivery\Create as DeliveryCreate;
use App\Livewire\Delivery\Index as DeliveryIndex;
use App\Livewire\Report\Create as ReportCreate;
use App\Livewire\Report\Index as ReportIndex;
use App\Livewire\Message\Create as MessageCreate;
use App\Livewire\Message\Index as MessageIndex;
use App\Livewire\Message\Thread as MessageThread;
use App\Livewire\Voucher\Create as VoucherCreate;
use App\Livewire\Voucher\Index as VoucherIndex;
use App\Livewire\Voucher\Show as VoucherShow;
use App\Livewire\Staff\Create as StaffCreate;
use App\Livewire\Staff\Edit as StaffEdit;
use Illuminate\Support\Facades\Route;

Route::prefix('commissions')->as('commissions.')->group(function (): void {
    Route::get('/', CommissionIndex::class)->name('index');
    Route::get('/create', CommissionCreate::class)->name('create');
});

Route::prefix('deliveries')->as('deliveries.')->group(function (): void {
    Route::get('/', DeliveryIndex::class)->name('index');
    Route::get('/create', DeliveryCreate::class)->name('create');
});

Route::prefix('reports')->as('reports.')->group(function (): void {
    Route::get('/', ReportIndex::class)->name('index');
    Route::get('/create', ReportCreate::class)->name('create');
});

Route::prefix('messages')->as('messages.')->group(function (): void {
    Route::get('/', MessageIndex::class)->name('index');
    Route::get('/create', MessageCreate::class)->name('create');
    Route::get('/{message}', MessageThread::class)->name('thread');
});

Route::prefix('vouchers')->as('vouchers.')->group(function (): void {
    Route::get('/', VoucherIndex::class)->name('index');
    Route::get('/create', VoucherCreate::class)->name('create');
    Route::get('/{voucher}', VoucherShow::class)->name('show');
});

Route::get('/setting/team/create', StaffCreate::class)->name('settings.users.create');
Route::get('/setting/team/{user}/edit', StaffEdit::class)->name('settings.users.edit');

// Route::get('/inventory', InventoryIndex::class)->name('inventory.index');
