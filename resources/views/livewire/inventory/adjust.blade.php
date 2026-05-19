<div>
  <div class="page-header" style="display:flex;align-items:center;gap:16px;">
    <a href="{{ route('shopper.inventory.index') }}" class="back-btn">← Back</a>
    <div>
      <h1>Adjust Stock</h1>
      <p>{{ $product->name }}</p>
    </div>
  </div>

  @if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="adjust-grid">
    <div class="card">
      <div class="current-stock-box">
        <div class="cs-label">Current Stock</div>
        <div class="cs-value" style="color: {{ $product->stock <= 0 ? 'var(--red)' : ($product->stock <= ($product->security_stock ?? 5) ? 'var(--yellow)' : 'var(--green)') }}">
          {{ $product->stock }} units
        </div>
      </div>

      <h2>Set New Quantity</h2>

      <form wire:submit="save">
        <div class="form-group">
          <label>Warehouse</label>
          <select wire:model="inventoryId" class="form-control">
            @foreach ($inventories as $inv)
              <option value="{{ $inv->id }}">{{ $inv->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>New Quantity</label>
          <input type="number" wire:model="quantity" min="0" class="form-control">
          @error('quantity') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label>Reason / Note</label>
          <input type="text" wire:model="description" placeholder="e.g. Restocked from supplier" class="form-control">
        </div>

        <button type="submit" class="submit-btn">Save Adjustment</button>
      </form>
    </div>

    <div class="card">
      <h2>Stock History</h2>
      @forelse ($histories as $h)
        <div class="history-row">
          <div class="desc">{{ $h->description ?? $h->event ?? 'Adjustment' }}</div>
          <div class="qty {{ $h->quantity >= 0 ? 'pos' : 'neg' }}">
            {{ $h->quantity >= 0 ? '+' : '' }}{{ $h->quantity }}
          </div>
          <div class="time">{{ $h->created_at->diffForHumans() }}</div>
        </div>
      @empty
        <div style="color:var(--muted);font-size:13px;padding:20px 0;text-align:center;">No history yet.</div>
      @endforelse
    </div>
  </div>
</div>