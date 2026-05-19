<div>
  <div class="page-header">
    <h1>Inventory</h1>
    <p>Monitor stock levels across all products</p>
  </div>

  @php
    $allProducts = \Shopper\Core\Models\Product::where('is_visible', true)->get();
    $totalProducts = $allProducts->count();
    $outOfStock = $allProducts->filter(fn($p) => $p->stock <= 0)->count();
    $lowStock = $allProducts->filter(fn($p) => $p->stock > 0 && $p->stock <= ($p->security_stock ?? 5))->count();
    $inStock = $allProducts->filter(fn($p) => $p->stock > ($p->security_stock ?? 5))->count();
  @endphp

  <div class="stats-row">
    <div class="stat-card">
      <div class="label">Total Products</div>
      <div class="value">{{ $totalProducts }}</div>
      <div class="sub">visible in store</div>
    </div>
    <div class="stat-card success">
      <div class="label">In Stock</div>
      <div class="value">{{ $inStock }}</div>
      <div class="sub">above safety level</div>
    </div>
    <div class="stat-card warning">
      <div class="label">Low Stock</div>
      <div class="value">{{ $lowStock }}</div>
      <div class="sub">needs restocking soon</div>
    </div>
    <div class="stat-card danger">
      <div class="label">Out of Stock</div>
      <div class="value">{{ $outOfStock }}</div>
      <div class="sub">unavailable to buyers</div>
    </div>
  </div>

  <div class="table-card">
    <div class="table-toolbar">
      <input type="text" class="search-input" placeholder="Search products…" id="inv-search">
      <select class="filter-btn" id="inv-filter">
        <option value="">All Stock Status</option>
        <option value="in">In Stock</option>
        <option value="low">Low Stock</option>
        <option value="out">Out of Stock</option>
      </select>
    </div>

    <table id="inv-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>SKU</th>
          <th>Brand</th>
          <th>Stock</th>
          <th>Safety Level</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($allProducts as $product)
          @php
            $stock = $product->stock;
            $safety = $product->security_stock ?? 5;
            $status = $stock <= 0 ? 'out' : ($stock <= $safety ? 'low' : 'in');
          @endphp
          <tr data-stock="{{ $status }}" data-name="{{ strtolower($product->name) }}">
            <td>
              <div style="font-weight:500;">{{ $product->name }}</div>
            </td>
            <td><span class="sku">{{ $product->sku ?? '—' }}</span></td>
            <td style="color:var(--muted);">{{ $product->brand->name ?? '—' }}</td>
            <td style="font-weight:600;font-size:15px;">{{ $stock }}</td>
            <td style="color:var(--muted);">{{ $safety }}</td>
            <td>
              @if($status === 'out')
                <span class="badge red">Out of Stock</span>
              @elseif($status === 'low')
                <span class="badge yellow">Low Stock</span>
              @else
                <span class="badge green">In Stock</span>
              @endif
            </td>
            <td>
              <a href="{{ route('shopper.inventory.adjust', $product->id) }}" class="adj-btn">Adjust</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script>
    const search = document.getElementById('inv-search');
    const filter = document.getElementById('inv-filter');
    function filterTable() {
      const q = search.value.toLowerCase();
      const f = filter.value;
      document.querySelectorAll('#inv-table tbody tr').forEach(row => {
        const name = row.dataset.name;
        const stock = row.dataset.stock;
        const matchQ = name.includes(q);
        const matchF = !f || stock === f;
        row.style.display = matchQ && matchF ? '' : 'none';
      });
    }
    search.addEventListener('input', filterTable);
    filter.addEventListener('change', filterTable);
  </script>
</div>
