<?php

declare(strict_types=1);

namespace App\Livewire\Voucher;

use App\Models\Voucher;
use Illuminate\Contracts\View\View;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Show extends AbstractPageComponent
{
    public Voucher $voucher;

    public function mount(Voucher $voucher): void
    {
        $this->authorize('view', $voucher);

        $this->voucher = $voucher->load(['order', 'customer', 'issuedBy']);
    }

    public function markPaid(): void
    {
        $this->authorize('update', $this->voucher);

        $this->voucher->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $this->voucher->refresh();
    }

    public function render(): View
    {
        return view('livewire.voucher.show')
            ->title($this->voucher->number);
    }
}
