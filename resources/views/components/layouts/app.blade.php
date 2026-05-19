<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ZeShop — Inventory</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
  :root {
    --ink:    #1d1d1f;
    --navy:   #0b2240;
    --blue:   #0071e3;
    --sky:    #2997ff;
    --pale:   #f5f5f7;
    --white:  #ffffff;
    --muted:  #6e6e73;
    --border: #d2d2d7;
    --gold:   #d4a843;
    --red:    #ff3b30;
    --green:  #30d158;
    --yellow: #ff9f0a;
    --sans:   -apple-system, 'Inter', 'Helvetica Neue', Helvetica, sans-serif;
  }
  body { font-family: var(--sans); background: var(--pale); color: var(--ink); font-size: 14px; -webkit-font-smoothing: antialiased; }
  a { text-decoration: none; color: inherit; }

  /* TOPBAR */
  .topbar {
    background: rgba(255,255,255,0.85);
    backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--border);
    padding: 0 24px;
    display: flex; align-items: center; gap: 16px;
    height: 60px; position: sticky; top: 0; z-index: 100;
  }
  .logo { font-size: 22px; font-weight: 700; color: var(--ink); letter-spacing: -0.5px; }
  .logo span { color: var(--blue); }
  .topbar-nav { display: flex; align-items: center; gap: 2px; margin-left: 32px; }
  .topbar-nav a {
    font-size: 13px; color: var(--muted); padding: 6px 14px;
    border-radius: 8px; transition: all 0.2s; font-weight: 400;
  }
  .topbar-nav a:hover { color: var(--ink); background: var(--pale); }
  .topbar-nav a.active { color: var(--blue); background: #e8f2fd; font-weight: 500; }
  .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
  .topbar-user {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--muted);
  }
  .avatar {
    width: 30px; height: 30px; border-radius: 50%;
    background: var(--navy); color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 600;
  }
  .back-btn {
    font-size: 13px; color: var(--blue);
    display: flex; align-items: center; gap: 4px;
    padding: 6px 14px; border-radius: 8px;
    border: 0.5px solid var(--border); transition: all 0.2s;
  }
  .back-btn:hover { background: var(--pale); }

  /* LAYOUT */
  .shell { display: flex; min-height: calc(100vh - 60px); }

  /* SIDEBAR */
  .sidebar {
    width: 220px; flex-shrink: 0;
    background: var(--white);
    border-right: 0.5px solid var(--border);
    padding: 24px 12px;
    display: flex; flex-direction: column; gap: 4px;
    position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto;
  }
  .sidebar-label {
    font-size: 10px; font-weight: 500; text-transform: uppercase;
    letter-spacing: 0.06em; color: var(--muted); padding: 12px 10px 6px;
  }
  .sidebar-link {
    display: flex; align-items: center; gap: 10px;
    font-size: 13px; color: var(--muted); font-weight: 400;
    padding: 9px 12px; border-radius: 10px; transition: all 0.2s;
  }
  .sidebar-link:hover { color: var(--ink); background: var(--pale); }
  .sidebar-link.active { color: var(--blue); background: #e8f2fd; font-weight: 500; }
  .sidebar-link svg { width: 16px; height: 16px; flex-shrink: 0; }

  /* MAIN */
  .main { flex: 1; padding: 32px; overflow: auto; }

  /* PAGE HEADER */
  .page-header { margin-bottom: 28px; }
  .page-header h1 { font-size: 28px; font-weight: 700; letter-spacing: -0.8px; color: var(--ink); }
  .page-header p { font-size: 13px; color: var(--muted); margin-top: 4px; font-weight: 300; }

  /* STAT CARDS */
  .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px; }
  .stat-card {
    background: var(--white); border: 0.5px solid var(--border);
    border-radius: 16px; padding: 20px 22px;
  }
  .stat-card .label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em; font-weight: 500; margin-bottom: 10px; }
  .stat-card .value { font-size: 32px; font-weight: 700; letter-spacing: -1px; color: var(--ink); }
  .stat-card .sub { font-size: 12px; color: var(--muted); margin-top: 4px; font-weight: 300; }
  .stat-card.danger .value { color: var(--red); }
  .stat-card.warning .value { color: var(--yellow); }
  .stat-card.success .value { color: var(--green); }

  /* TABLE */
  .table-card {
    background: var(--white); border: 0.5px solid var(--border);
    border-radius: 18px; overflow: hidden;
  }
  .table-toolbar {
    padding: 16px 20px; border-bottom: 0.5px solid var(--border);
    display: flex; align-items: center; gap: 12px;
  }
  .search-input {
    flex: 1; max-width: 320px;
    background: var(--pale); border: 1px solid transparent;
    border-radius: 10px; padding: 8px 14px;
    font-family: var(--sans); font-size: 13px; color: var(--ink);
    outline: none; transition: border-color 0.2s, background 0.2s;
  }
  .search-input:focus { border-color: var(--blue); background: var(--white); }
  .search-input::placeholder { color: var(--muted); }
  .filter-btn {
    background: var(--pale) !important; border: 0.5px solid var(--border);
    color: var(--ink); font-family: var(--sans); font-size: 13px;
    padding: 8px 16px; border-radius: 10px; cursor: pointer; transition: all 0.2s;
    background-image: none !important;
  }
  .filter-btn:hover { border-color: var(--blue); color: var(--blue); }
  .filter-btn option {
    color: var(--ink); background: var(--white); padding: 8px;
  }
  .filter-btn option[value=""] {
    color: var(--muted);
  }

  table { width: 100%; border-collapse: collapse; }
  thead { background: var(--pale); }
  th {
    text-align: left; font-size: 11px; font-weight: 500;
    color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;
    padding: 11px 20px; border-bottom: 0.5px solid var(--border);
  }
  td { padding: 14px 20px; border-bottom: 0.5px solid var(--border); font-size: 13px; color: var(--ink); }
  tr:last-child td { border-bottom: none; }
  tbody tr { transition: background 0.15s; }
  tbody tr:hover { background: #fafafa; }

  .badge {
    display: inline-flex; align-items: center;
    font-size: 11px; font-weight: 500;
    padding: 3px 10px; border-radius: 20px;
  }
  .badge.green { background: #e6f9ee; color: #1a7f3c; }
  .badge.yellow { background: #fff8e6; color: #a05c00; }
  .badge.red { background: #fff0ee; color: #c0392b; }

  .sku { font-size: 11px; color: var(--muted); font-family: 'SF Mono', monospace; }

  .adj-btn {
    background: none; border: 0.5px solid var(--border);
    color: var(--blue); font-size: 12px; font-weight: 500;
    padding: 5px 14px; border-radius: 8px; cursor: pointer;
    font-family: var(--sans); transition: all 0.2s;
    text-decoration: none; display: inline-block;
  }
  .adj-btn:hover { background: var(--blue); color: var(--white); border-color: var(--blue); }

  /* ADJUST PAGE */
  .adjust-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start; }
  .card {
    background: var(--white); border: 0.5px solid var(--border);
    border-radius: 18px; padding: 28px;
  }
  .card h2 { font-size: 16px; font-weight: 600; margin-bottom: 20px; letter-spacing: -0.3px; }
  .form-group { margin-bottom: 16px; }
  .form-group label { display: block; font-size: 12px; font-weight: 500; color: var(--muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em; }
  .form-control {
    width: 100%; background: var(--pale); border: 1px solid transparent;
    border-radius: 10px; padding: 10px 14px;
    font-family: var(--sans); font-size: 14px; color: var(--ink);
    outline: none; transition: border-color 0.2s, background 0.2s;
  }
  .form-control:focus { border-color: var(--blue); background: var(--white); }
  .submit-btn {
    width: 100%; background: var(--navy); color: var(--white);
    font-family: var(--sans); font-size: 14px; font-weight: 600;
    padding: 13px; border-radius: 12px; border: none; cursor: pointer;
    transition: opacity 0.2s, transform 0.2s; margin-top: 8px;
  }
  .submit-btn:hover { opacity: 0.88; transform: scale(0.99); }
  .current-stock-box {
    display: flex; align-items: center; justify-content: space-between;
    background: var(--pale); border-radius: 12px; padding: 16px 18px; margin-bottom: 24px;
  }
  .current-stock-box .cs-label { font-size: 12px; color: var(--muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.04em; }
  .current-stock-box .cs-value { font-size: 28px; font-weight: 700; letter-spacing: -0.8px; }
  .history-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 0; border-bottom: 0.5px solid var(--border); font-size: 13px;
  }
  .history-row:last-child { border-bottom: none; }
  .history-row .desc { color: var(--ink); flex: 1; }
  .history-row .qty { font-weight: 600; margin: 0 16px; }
  .history-row .qty.pos { color: var(--green); }
  .history-row .qty.neg { color: var(--red); }
  .history-row .time { font-size: 11px; color: var(--muted); white-space: nowrap; }

  .alert-success {
    background: #e6f9ee; border: 0.5px solid #a3e4b7;
    border-radius: 10px; padding: 12px 16px;
    font-size: 13px; color: #1a7f3c; margin-bottom: 20px;
  }
  .error-msg { font-size: 11px; color: var(--red); margin-top: 4px; }
</style>
@filamentStyles
@livewireStyles
</head>
<body>

<header class="topbar">
  <a href="{{ route('home') }}" class="logo">Ze<span>Shop</span></a>
  <nav class="topbar-nav">
    <a href="{{ route('home') }}">Storefront</a>
    <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">Inventory</a>
    <a href="/cpanel/dashboard">Admin Panel</a>
  </nav>
  <div class="topbar-right">
    <div class="topbar-user">
      <div class="avatar">{{ strtoupper(substr(auth()->user()->first_name ?? 'A', 0, 1)) }}</div>
      <span>{{ auth()->user()->first_name ?? 'Admin' }}</span>
    </div>
  </div>
</header>

<div class="shell">
  <aside class="sidebar">
    <div class="sidebar-label">Stock Management</div>
    <a href="{{ route('inventory.index') }}" class="sidebar-link {{ request()->routeIs('inventory.index') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      Overview
    </a>
    <a href="/cpanel/products" class="sidebar-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
      Products
    </a>
    <a href="/cpanel/setting/locations" class="sidebar-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
      Warehouses
    </a>
    <a href="/cpanel/dashboard" class="sidebar-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>

    <div class="sidebar-label" style="margin-top:12px;">Shopper Admin</div>
    <a href="/cpanel/orders" class="sidebar-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      Orders
    </a>
    <a href="/cpanel/customers" class="sidebar-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
      Customers
    </a>
  </aside>

  <main class="main">
    {{ $slot }}
  </main>
</div>

@filamentScripts
@livewireScripts
</body>
</html>