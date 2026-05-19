<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ZeShop — Curated Goods, Unbeatable Prices</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
<link rel="icon" type="image/png" sizes="16x16" href="/cpanel/images/favicons/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="32x32" href="/cpanel/images/favicons/favicon-32x32.png">
<link rel="apple-touch-icon" sizes="180x180" href="/cpanel/images/favicons/apple-touch-icon.png">
<link rel="manifest" href="/cpanel/images/favicons/site.webmanifest">
<meta name="msapplication-config" content="/cpanel/images/favicons/browserconfig.xml">
<meta name="theme-color" content="#0b2240">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --ink:       #1d1d1f;
    --navy:      #0b2240;
    --blue:      #0071e3;
    --mid:       #0077ed;
    --sky:       #2997ff;
    --pale:      #f5f5f7;
    --white:     #ffffff;
    --off:       #f5f5f7;
    --muted:     #6e6e73;
    --border:    #d2d2d7;
    --gold:      #d4a843;
    --red:       #ff3b30;
    --green:     #30d158;
    --sans:      -apple-system, 'Inter', 'Helvetica Neue', Helvetica, sans-serif;
    --display:   -apple-system, 'Inter', 'Helvetica Neue', Helvetica, sans-serif;
  }

  body { font-family: var(--sans); background: var(--off); color: var(--ink); font-size: 14px; -webkit-font-smoothing: antialiased; }
  a { text-decoration: none; color: inherit; }
  ul { list-style: none; }
  img { display: block; width: 100%; }
  button { cursor: pointer; font-family: var(--sans); border: none; outline: none; }

  .announce {
    background: var(--navy);
    color: #a8c8f0;
    text-align: center;
    font-size: 12px;
    font-weight: 400;
    padding: 8px 20px;
  }
  .announce span { color: var(--gold); font-weight: 500; }
  .announce a { color: #6aaee0; text-decoration: underline; margin-left: 8px; }

  .topnav {
    background: rgba(255,255,255,0.85);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--border);
    padding: 0 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    height: 60px;
    position: sticky;
    top: 0;
    z-index: 100;
  }
  .logo {
    font-family: var(--display);
    font-size: 24px;
    font-weight: 700;
    color: var(--ink);
    white-space: nowrap;
    letter-spacing: -0.5px;
  }
  .logo span { color: var(--blue); }

  .search-wrap {
    flex: 1;
    display: flex;
    max-width: 560px;
    background: var(--pale);
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid transparent;
    transition: border-color 0.2s, background 0.2s;
  }
  .search-wrap:focus-within { border-color: var(--blue); background: var(--white); }
  .search-wrap select {
    border: none;
    border-right: 0.5px solid var(--border);
    background: transparent;
    color: var(--ink);
    font-family: var(--sans);
    font-size: 13px;
    padding: 0 10px;
    width: 130px;
    cursor: pointer;
    outline: none;
  }
  .search-wrap input {
    flex: 1;
    border: none;
    padding: 0 14px;
    font-family: var(--sans);
    font-size: 14px;
    outline: none;
    color: var(--ink);
    background: transparent;
  }
  .search-wrap input::placeholder { color: var(--muted); }
  .search-wrap button {
    background: var(--blue);
    color: var(--white);
    padding: 0 18px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 0 9px 9px 0;
    transition: background 0.2s;
  }
  .search-wrap button:hover { background: #0062c4; }

  .topnav-actions { display: flex; align-items: center; gap: 8px; margin-left: auto; }
  .action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    font-size: 10px;
    font-weight: 400;
    color: var(--muted);
    background: none;
    cursor: pointer;
    transition: color 0.2s;
    padding: 6px 10px;
    border-radius: 8px;
    text-decoration: none;
  }
  .action-btn:hover { color: var(--blue); background: var(--pale); }
  .action-btn svg { width: 20px; height: 20px; }
  .cart-btn { position: relative; }
  .cart-badge {
    position: absolute;
    top: 2px;
    right: 4px;
    background: var(--red);
    color: #fff;
    font-size: 9px;
    font-weight: 600;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1.5px solid var(--white);
  }

  .catnav {
    background: rgba(255,255,255,0.9);
    backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--border);
    padding: 0 24px;
    display: flex;
    align-items: center;
    overflow-x: auto;
    scrollbar-width: none;
  }
  .catnav::-webkit-scrollbar { display: none; }
  .catnav a {
    color: var(--muted);
    font-size: 13px;
    font-weight: 400;
    padding: 12px 16px;
    white-space: nowrap;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
  }
  .catnav a:hover { color: var(--ink); }
  .catnav a.active { color: var(--blue); border-bottom-color: var(--blue); font-weight: 500; }
  .catnav a.flash { color: #ff6b00; font-weight: 500; }

  .hero {
    padding: 24px 24px 0;
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 12px;
  }
  .hero-main {
    background: linear-gradient(145deg, #0b2240 0%, #0d3060 50%, #0f3a75 100%);
    border-radius: 18px;
    padding: 52px 56px;
    position: relative;
    overflow: hidden;
    min-height: 340px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .hero-main::before {
    content: '';
    position: absolute;
    right: -80px; top: -80px;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(41,151,255,0.15) 0%, transparent 70%);
    pointer-events: none;
  }
  .hero-tag {
    background: rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.85);
    font-size: 12px;
    font-weight: 500;
    padding: 5px 14px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 20px;
    width: fit-content;
    border: 0.5px solid rgba(255,255,255,0.2);
  }
  .hero-title {
    font-family: var(--display);
    font-size: 46px;
    font-weight: 700;
    color: var(--white);
    line-height: 1.1;
    max-width: 480px;
    margin-bottom: 16px;
    letter-spacing: -1.5px;
  }
  .hero-sub {
    color: rgba(168,200,240,0.85);
    font-size: 15px;
    font-weight: 300;
    line-height: 1.6;
    max-width: 380px;
    margin-bottom: 32px;
  }
  .hero-btns { display: flex; gap: 10px; }
  .btn-primary {
    background: var(--white);
    color: var(--navy);
    font-size: 14px;
    font-weight: 600;
    padding: 12px 28px;
    border-radius: 22px;
    transition: opacity 0.2s, transform 0.2s;
    text-decoration: none;
    display: inline-block;
  }
  .btn-primary:hover { opacity: 0.9; transform: scale(0.98); }
  .btn-outline {
    background: transparent;
    color: rgba(255,255,255,0.85);
    font-size: 14px;
    font-weight: 400;
    padding: 12px 24px;
    border-radius: 22px;
    border: 1px solid rgba(255,255,255,0.25);
    transition: all 0.2s;
    text-decoration: none;
    display: inline-block;
  }
  .btn-outline:hover { border-color: rgba(255,255,255,0.6); color: var(--white); }

  .hero-stats {
    display: flex;
    gap: 32px;
    margin-top: 36px;
    padding-top: 28px;
    border-top: 0.5px solid rgba(255,255,255,0.12);
  }
  .hero-stat strong {
    display: block;
    font-size: 26px;
    font-weight: 700;
    color: var(--white);
    letter-spacing: -0.8px;
  }
  .hero-stat span { font-size: 12px; color: rgba(168,200,240,0.75); font-weight: 300; }

  .hero-aside { display: flex; flex-direction: column; gap: 8px; }
  .mini-card {
    background: var(--white);
    border: 0.5px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    flex: 1;
    text-decoration: none;
  }
  .mini-card:hover { transform: scale(1.01); box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
  .mini-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .mini-icon svg { width: 20px; height: 20px; }
  .mini-card-text strong { font-size: 13px; font-weight: 600; color: var(--ink); display: block; }
  .mini-card-text span { font-size: 12px; color: var(--muted); font-weight: 300; }

  .trust {
    background: var(--navy);
    padding: 16px 24px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    margin-top: 12px;
  }
  .trust-item {
    display: flex; align-items: center; gap: 12px;
    padding: 4px 20px;
    border-right: 0.5px solid rgba(255,255,255,0.1);
  }
  .trust-item:first-child { padding-left: 0; }
  .trust-item:last-child { border-right: none; }
  .trust-icon { color: var(--sky); flex-shrink: 0; }
  .trust-icon svg { width: 24px; height: 24px; }
  .trust-text strong { display: block; font-size: 13px; color: var(--white); font-weight: 500; }
  .trust-text span { font-size: 11px; color: rgba(168,200,240,0.65); font-weight: 300; }

  .section { padding: 32px 24px 0; }
  .sec-header {
    display: flex; align-items: baseline; justify-content: space-between;
    margin-bottom: 16px;
  }
  .sec-title { font-size: 24px; font-weight: 700; color: var(--ink); letter-spacing: -0.7px; }
  .sec-title span { color: var(--blue); }
  .sec-link { font-size: 13px; color: var(--blue); }
  .sec-link:hover { text-decoration: underline; }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
    padding: 0 24px 24px;
  }
  .products-grid.six { grid-template-columns: repeat(6, 1fr); }
  .products-grid.four { grid-template-columns: repeat(4, 1fr); }

  .product-card {
    background: var(--white);
    border: 0.5px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s;
    position: relative;
    text-decoration: none;
    display: block;
  }
  .product-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.1); transform: translateY(-3px); }
  .product-card:hover .card-actions { opacity: 1; transform: translateY(0); }

  .card-img {
    height: 160px;
    background: var(--pale);
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
  }
  .card-img img { width: 100%; height: 100%; object-fit: cover; }
  .card-img.tall { height: 200px; }
  .card-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 48px; background: var(--pale);
  }

  .card-badge {
    position: absolute; top: 10px; left: 10px;
    font-size: 10px; font-weight: 600;
    padding: 3px 9px; border-radius: 20px;
    z-index: 2;
  }
  .badge-new { background: var(--green); color: #fff; }
  .badge-sale { background: var(--blue); color: #fff; }
  .badge-hot { background: var(--red); color: #fff; }

  .card-wishlist {
    position: absolute; top: 10px; right: 10px;
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(10px);
    border: 0.5px solid rgba(0,0,0,0.08);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.2s; z-index: 2;
  }
  .card-wishlist svg { width: 14px; height: 14px; stroke: var(--muted); fill: none; transition: all 0.2s; }
  .card-wishlist:hover svg { stroke: var(--red); }
  .card-wishlist.active svg { stroke: var(--red); fill: var(--red); }

  .card-actions {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,0.65);
    backdrop-filter: blur(8px);
    display: flex; gap: 1px;
    opacity: 0; transform: translateY(4px);
    transition: opacity 0.2s, transform 0.2s; z-index: 2;
  }
  .card-actions button {
    flex: 1; padding: 9px 4px; font-size: 11px; font-weight: 500;
    color: rgba(255,255,255,0.9); background: none; border: none; transition: background 0.2s;
  }
  .card-actions button:hover { background: rgba(255,255,255,0.12); }
  .card-actions button.add-cart-btn { background: var(--blue); color: var(--white); }
  .card-actions button.add-cart-btn:hover { background: #0062c4; }

  .card-body { padding: 12px 14px 14px; }
  .card-brand { font-size: 11px; color: var(--muted); margin-bottom: 3px; }
  .card-name { font-size: 13px; color: var(--ink); line-height: 1.4; margin-bottom: 6px; font-weight: 400; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .card-price { display: flex; align-items: baseline; gap: 6px; }
  .price-now { font-size: 15px; font-weight: 600; color: var(--ink); }
  .price-old { font-size: 12px; color: #aaa; text-decoration: line-through; font-weight: 300; }
  .price-save { font-size: 11px; color: var(--blue); font-weight: 500; }
  .price-no-stock { font-size: 12px; color: var(--red); font-weight: 400; }

  .promo-row {
    padding: 0 24px 24px;
    display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;
  }
  .promo-banner {
    border-radius: 18px; padding: 30px 32px;
    position: relative; overflow: hidden;
    cursor: pointer; min-height: 148px;
    display: flex; flex-direction: column; justify-content: center;
    transition: transform 0.2s, opacity 0.2s;
    text-decoration: none;
  }
  .promo-banner:hover { transform: scale(0.99); opacity: 0.92; }
  .pb-dark { background: linear-gradient(135deg, #0b2240, #123a6e); }
  .pb-mid { background: linear-gradient(135deg, #0071e3, #2997ff); }
  .pb-warm { background: #f5f5f7; border: 0.5px solid var(--border); }
  .pb-tag { font-size: 11px; font-weight: 500; letter-spacing: 0.04em; text-transform: uppercase; margin-bottom: 8px; color: rgba(255,255,255,0.65); }
  .pb-warm .pb-tag { color: var(--muted); }
  .pb-title { font-size: 20px; font-weight: 700; line-height: 1.2; color: var(--white); max-width: 200px; margin-bottom: 10px; letter-spacing: -0.5px; }
  .pb-warm .pb-title { color: var(--ink); }
  .pb-cta { font-size: 13px; color: rgba(255,255,255,0.75); }
  .pb-warm .pb-cta { color: var(--blue); }

  .flash-section {
    padding: 0 24px 24px;
    display: grid; grid-template-columns: 220px 1fr;
    border-radius: 18px; overflow: hidden;
  }
  .flash-panel {
    background: linear-gradient(160deg, #0b2240, #0d3060);
    padding: 36px 28px;
    display: flex; flex-direction: column; justify-content: center;
  }
  .flash-label { font-size: 11px; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; color: rgba(255,193,7,0.85); margin-bottom: 10px; }
  .flash-title { font-size: 28px; font-weight: 700; color: var(--white); line-height: 1.15; margin-bottom: 20px; letter-spacing: -0.8px; }
  .countdown { display: flex; gap: 8px; margin-bottom: 24px; }
  .count-block {
    background: rgba(255,255,255,0.08);
    border: 0.5px solid rgba(255,255,255,0.12);
    border-radius: 10px; padding: 10px; text-align: center; min-width: 50px;
  }
  .count-block strong { display: block; font-size: 22px; font-weight: 700; color: var(--white); line-height: 1; }
  .count-block span { font-size: 9px; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(168,200,240,0.6); font-weight: 300; }
  .flash-all-btn {
    background: var(--white); color: var(--navy);
    font-size: 13px; font-weight: 600; padding: 11px 20px;
    border-radius: 22px; border: none; width: 100%;
    cursor: pointer; transition: opacity 0.2s, transform 0.2s;
  }
  .flash-all-btn:hover { opacity: 0.9; transform: scale(0.98); }
  .flash-grid {
    background: var(--white);
    border: 0.5px solid var(--border); border-left: none;
    display: grid; grid-template-columns: repeat(4, 1fr);
  }
  .flash-card {
    padding: 18px; cursor: pointer; transition: background 0.2s;
    border-right: 0.5px solid var(--border);
    text-decoration: none; display: block;
  }
  .flash-card:last-child { border-right: none; }
  .flash-card:hover { background: var(--pale); }
  .flash-card-img {
    height: 110px; background: var(--pale); border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px; position: relative; overflow: hidden;
  }
  .flash-card-img img { width: 100%; height: 100%; object-fit: cover; }
  .flash-card-img-placeholder { font-size: 40px; }
  .discount-pill {
    position: absolute; bottom: 6px; right: 6px;
    background: var(--red); color: #fff;
    font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 20px; z-index: 2;
  }
  .flash-name { font-size: 12px; color: var(--ink); font-weight: 400; margin-bottom: 6px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .flash-prices { display: flex; align-items: baseline; gap: 6px; margin-bottom: 8px; }
  .flash-now { font-size: 15px; font-weight: 600; color: var(--ink); }
  .flash-old { font-size: 11px; color: #bbb; text-decoration: line-through; font-weight: 300; }
  .progress-wrap { background: #ebebed; border-radius: 20px; height: 3px; overflow: hidden; margin-bottom: 4px; }
  .progress-bar { height: 100%; border-radius: 20px; background: var(--blue); }
  .progress-label { font-size: 10px; color: var(--muted); font-weight: 300; }

  .cat-pills {
    padding: 8px 24px 16px; display: flex; gap: 6px;
    overflow-x: auto; scrollbar-width: none;
  }
  .cat-pills::-webkit-scrollbar { display: none; }
  .cat-pill {
    background: var(--white); border: 0.5px solid var(--border);
    color: var(--ink); font-size: 13px; font-weight: 400;
    padding: 7px 18px; border-radius: 22px; white-space: nowrap;
    cursor: pointer; transition: all 0.2s;
  }
  .cat-pill:hover { border-color: var(--blue); color: var(--blue); }
  .cat-pill.active { background: var(--ink); border-color: var(--ink); color: var(--white); }

  .collections-grid {
    padding: 0 24px 24px;
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;
  }
  .collection-card {
    border-radius: 18px; overflow: hidden; cursor: pointer;
    transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s;
    position: relative; min-height: 170px;
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 22px; text-decoration: none;
  }
  .collection-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,0.12); }
  .collection-card:nth-child(4n+1) { background: linear-gradient(145deg, #0b2240, #0d3a6e); }
  .collection-card:nth-child(4n+2) { background: var(--pale); border: 0.5px solid var(--border); }
  .collection-card:nth-child(4n+3) { background: linear-gradient(145deg, #1a3a6e, #0d2a55); }
  .collection-card:nth-child(4n+4) { background: #fdf6ea; border: 0.5px solid #e8d8b0; }
  .col-name { font-size: 18px; font-weight: 700; line-height: 1.2; margin-bottom: 5px; letter-spacing: -0.4px; }
  .collection-card:nth-child(4n+1) .col-name,
  .collection-card:nth-child(4n+3) .col-name { color: var(--white); }
  .collection-card:nth-child(4n+2) .col-name,
  .collection-card:nth-child(4n+4) .col-name { color: var(--ink); }
  .col-count { font-size: 12px; display: flex; align-items: center; gap: 4px; font-weight: 300; }
  .collection-card:nth-child(4n+1) .col-count,
  .collection-card:nth-child(4n+3) .col-count { color: rgba(168,200,240,0.7); }
  .collection-card:nth-child(4n+2) .col-count,
  .collection-card:nth-child(4n+4) .col-count { color: var(--muted); }

  .brands-bar {
    background: var(--white);
    border-top: 0.5px solid var(--border); border-bottom: 0.5px solid var(--border);
    padding: 16px 24px; display: flex; align-items: center;
    overflow-x: auto; scrollbar-width: none; margin: 0 0 24px;
  }
  .brands-bar::-webkit-scrollbar { display: none; }
  .brands-label {
    font-size: 11px; font-weight: 500; letter-spacing: 0.04em; text-transform: uppercase;
    color: var(--muted); margin-right: 24px; white-space: nowrap;
    padding-right: 24px; border-right: 0.5px solid var(--border);
  }
  .brand-item {
    font-size: 14px; font-weight: 500; color: var(--muted);
    padding: 0 20px; border-right: 0.5px solid var(--border);
    white-space: nowrap; cursor: pointer; transition: color 0.2s;
    text-decoration: none; display: flex; align-items: center; gap: 8px;
  }
  .brand-item:last-child { border-right: none; }
  .brand-item:hover { color: var(--blue); }
  .brand-logo { width: 24px; height: 24px; object-fit: contain; border-radius: 4px; }

  footer { background: #1d1d1f; padding: 48px 24px 0; margin-top: 8px; }
  .footer-grid {
    display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr; gap: 40px;
    padding-bottom: 40px; border-bottom: 0.5px solid rgba(255,255,255,0.1);
  }
  .footer-brand .logo { font-size: 22px; margin-bottom: 12px; color: var(--white); }
  .footer-brand p { font-size: 13px; color: #86868b; line-height: 1.7; max-width: 240px; margin-bottom: 16px; font-weight: 300; }
  .socials { display: flex; gap: 8px; }
  .social-btn {
    width: 32px; height: 32px; border-radius: 8px;
    background: rgba(255,255,255,0.08); color: #86868b;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.2s, color 0.2s;
  }
  .social-btn svg { width: 14px; height: 14px; }
  .social-btn:hover { background: var(--blue); color: var(--white); }
  .footer-col h4 { font-size: 12px; font-weight: 500; color: var(--white); letter-spacing: 0.02em; text-transform: uppercase; margin-bottom: 16px; }
  .footer-col ul li { margin-bottom: 10px; }
  .footer-col ul li a { font-size: 13px; color: #86868b; transition: color 0.2s; font-weight: 300; }
  .footer-col ul li a:hover { color: var(--white); }
  .newsletter-form { display: flex; margin-top: 10px; }
  .newsletter-form input {
    flex: 1; padding: 10px 14px; font-family: var(--sans); font-size: 13px;
    border: 0.5px solid rgba(255,255,255,0.12); border-right: none;
    background: rgba(255,255,255,0.06); color: var(--white);
    border-radius: 8px 0 0 8px; outline: none;
  }
  .newsletter-form input::placeholder { color: #86868b; }
  .newsletter-form button {
    background: var(--blue); color: var(--white); font-size: 13px; font-weight: 500;
    padding: 10px 16px; border-radius: 0 8px 8px 0; cursor: pointer; transition: opacity 0.2s; white-space: nowrap;
  }
  .newsletter-form button:hover { opacity: 0.88; }
  .footer-bottom { padding: 16px 0; display: flex; justify-content: space-between; align-items: center; }
  .footer-bottom span { font-size: 12px; color: #515154; font-weight: 300; }
  .footer-legal { display: flex; gap: 20px; }
  .footer-legal a { font-size: 12px; color: #515154; transition: color 0.2s; }
  .footer-legal a:hover { color: #86868b; }

  .empty-state { padding: 40px 24px; text-align: center; color: var(--muted); font-size: 14px; }
</style>
</head>
<body>

{{-- ANNOUNCEMENT BAR --}}
@include('components.header')

{{-- HERO --}}
<section class="hero">
  <div class="hero-main">
    <div class="hero-tag">New Season Collection</div>
    <h1 class="hero-title">Curated goods,<br>unbeatable prices.</h1>
    <p class="hero-sub">Millions of products from thousands of trusted sellers. Your perfect find is just a search away.</p>
    <div class="hero-btns">
      <a href="{{ route('products.index') }}" class="btn-primary">Shop Now</a>
      <a href="{{ route('products.index') }}" class="btn-outline">Browse Categories</a>
    </div>
    <div class="hero-stats">
      <div class="hero-stat">
        <strong>{{ number_format(\Shopper\Core\Models\Product::where('is_visible', true)->count()) }}+</strong>
        <span>Products</span>
      </div>
      <div class="hero-stat">
        <strong>{{ number_format(\Shopper\Core\Models\Brand::where('is_enabled', true)->count()) }}+</strong>
        <span>Brands</span>
      </div>
      <div class="hero-stat">
        <strong>{{ number_format(\Shopper\Core\Models\Category::where('is_enabled', true)->count()) }}+</strong>
        <span>Categories</span>
      </div>
    </div>
  </div>

  <div class="hero-aside">
    <a href="{{ route('products.index') }}" class="mini-card">
      <div class="mini-icon" style="background:#fff3e0;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#ff9f0a" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
      </div>
      <div class="mini-card-text">
        <strong>Flash Offers</strong>
        <span>Deals up to 70% off today</span>
      </div>
    </a>
    <a href="{{ route('products.index') }}" class="mini-card">
      <div class="mini-icon" style="background:#e8f5e9;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#30d158" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
      </div>
      <div class="mini-card-text">
        <strong>New Arrivals</strong>
        <span>{{ \Shopper\Core\Models\Product::where('is_visible', true)->whereDate('created_at', '>=', now()->subDays(7))->count() }}+ items added this week</span>
      </div>
    </a>
    <a href="{{ route('products.index') }}" class="mini-card">
      <div class="mini-icon" style="background:#e3f2fd;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#0071e3" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div class="mini-card-text">
        <strong>Top Rated</strong>
        <span>Editor's picks &amp; bestsellers</span>
      </div>
    </a>
    <a href="{{ route('products.index') }}" class="mini-card">
      <div class="mini-icon" style="background:#f3e5f5;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#9c27b0" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg>
      </div>
      <div class="mini-card-text">
        <strong>Seller Spotlight</strong>
        <span>Discover top stores near you</span>
      </div> 
    </a>
  </div>
</section>

{{-- TRUST BAR --}}
<div class="trust">
  <div class="trust-item">
    <span class="trust-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></span>
    <div class="trust-text"><strong>Free Shipping</strong><span>On orders over $49</span></div>
  </div>
  <div class="trust-item">
    <span class="trust-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
    <div class="trust-text"><strong>Buyer Protection</strong><span>Money back guarantee</span></div>
  </div>
  <div class="trust-item">
    <span class="trust-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg></span>
    <div class="trust-text"><strong>Easy Returns</strong><span>30-day hassle free</span></div>
  </div>
  <div class="trust-item">
    <span class="trust-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></span>
    <div class="trust-text"><strong>24/7 Support</strong><span>Always here to help</span></div>
  </div>
</div>

{{-- TRENDING NOW --}}
<section class="section">
  <div class="sec-header">
    <h2 class="sec-title">Trending <span>Now</span></h2>
    <a href="{{ route('products.index') }}" class="sec-link">View all →</a>
  </div>
</section>

@if($trending->isEmpty())
  <div class="empty-state">No products yet. Add some from the admin panel.</div>
@else
<div class="products-grid">
  @foreach($trending as $product)
    @include('partials.product-card', ['product' => $product])
  @endforeach
</div>
@endif

{{-- PROMO BANNERS --}}
<div class="promo-row">
  <a href="{{ route('products.index') }}" class="promo-banner pb-dark">
    <div class="pb-tag">Limited Time</div>
    <div class="pb-title">Tech Week Mega Sale</div>
    <div class="pb-cta">Shop gadgets →</div>
  </a>
  <a href="{{ route('products.index') }}" class="promo-banner pb-mid">
    <div class="pb-tag">New Collection</div>
    <div class="pb-title">Spring Fashion Lookbook</div>
    <div class="pb-cta">Explore styles →</div>
  </a>
  <a href="{{ route('products.index') }}" class="promo-banner pb-warm">
    <div class="pb-tag">Editor's Pick</div>
    <div class="pb-title">Home Refresh Essentials</div>
    <div class="pb-cta">Redesign your space →</div>
  </a>
</div>

{{-- FLASH DEALS --}}
<div class="flash-section">
  <div class="flash-panel">
    <div class="flash-label">⚡ Today Only</div>
    <div class="flash-title">Flash Deals</div>
    <div class="countdown">
      <div class="count-block"><strong id="hh">08</strong><span>Hrs</span></div>
      <div class="count-block"><strong id="mm">34</strong><span>Min</span></div>
      <div class="count-block"><strong id="ss">12</strong><span>Sec</span></div>
    </div>
    <a href="{{ route('products.index') }}" class="flash-all-btn">All Flash Deals</a>
  </div>
  <div class="flash-grid">
    @forelse($flashDeals as $product)
        @php
            $img = $product->getFirstMediaUrl('thumbnail') ?: $product->getFirstMediaUrl('uploads');
            $price   = $product->prices->first()->amount ?? 0;
            $compare = $product->prices->first()->compare_amount ?? 0;
            $pct     = $compare > 0 ? round((1 - $price / $compare) * 100) : 0;
            $tall    = $tall ?? false;
        @endphp

    <a href="{{ route('products.show', $product->slug) }}" class="product-card">
        <div class="card-img {{ $tall ? 'tall' : '' }}">
            @if($img)
                <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy">
            @else
                <div class="card-img-placeholder">🛍️</div>
            @endif

            @if($pct > 0)
                <span class="card-badge badge-sale">-{{ $pct }}%</span>
            @endif

            <div class="card-wishlist">
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </div>

            <div class="card-actions">
                <button type="button">Quick View</button>
                <button type="button" class="add-cart-btn">Add to Cart</button>
            </div>
        </div>

        <div class="card-body">
            <div class="card-brand">{{ $product->brand->name ?? '' }}</div>
            <div class="card-name">{{ $product->name }}</div>
            <div class="card-price">
                @if($price > 0)
                    <span class="price-now">{{ number_format($price, 2) }} FCFA</span>
                    @if($compare > 0)
                        <span class="price-old">{{ number_format($compare, 2) }} FCFA</span>
                    @endif
                @else
                    <span class="price-no-stock">No price set</span>
                @endif
            </div>
        </div>
    </a>
    @empty
      <div style="grid-column:1/-1; display:flex; align-items:center; justify-content:center; color:var(--muted); font-size:13px; padding:40px;">
        No deals available right now.
      </div>
    @endforelse
  </div>
</div>

{{-- BROWSE EVERYTHING --}}
<section class="section">
  <div class="sec-header">
    <h2 class="sec-title">Browse <span>Everything</span></h2>
    <a href="{{ route('products.index') }}" class="sec-link">See all products →</a>
  </div>
</section>

<div class="cat-pills">
  <a href="{{ route('products.index') }}" class="cat-pill active">All</a>
  @foreach($categories as $cat)
    <a href="{{ route('categories.show', $cat->slug) }}" class="cat-pill">{{ $cat->name }}</a>
  @endforeach
</div>

@if($browse->isEmpty())
  <div class="empty-state">No products yet.</div>
@else
<div class="products-grid six">
  @foreach($browse as $product)
    @include('partials.product-card', ['product' => $product])
  @endforeach
</div>
@endif

{{-- COLLECTIONS --}}
@if($collections->isNotEmpty())
<section class="section">
  <div class="sec-header">
    <h2 class="sec-title">Curated <span>Collections</span></h2>
    <a href="{{ route('products.index') }}" class="sec-link">All collections →</a>
  </div>
</section>
<div class="collections-grid">
  @foreach($collections as $collection)
    <a href="{{ route('products.index', ['collection' => $collection->slug]) }}" class="collection-card" style="position:relative;">
        @php $colImg = $collection->getFirstMediaUrl('thumbnail'); @endphp
        @if($colImg)
            <img src="{{ $colImg }}" alt="{{ $collection->name }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;border-radius:18px;">
            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.35);border-radius:18px;z-index:1;"></div>
        @endif
        <div style="position:relative;z-index:2;">
            <div class="col-name" style="color:white;">{{ $collection->name }}</div>
            <div class="col-count" style="color:rgba(255,255,255,0.7);">
                <span>{{ $collection->products_count ?? '—' }} products</span>
                <span style="margin-left:auto">→</span>
            </div>
        </div>
    </a>
  @endforeach
</div>
@endif

{{-- YOU MIGHT ALSO LIKE --}}
@if($suggested->isNotEmpty())
<section class="section">
  <div class="sec-header">
    <h2 class="sec-title">You Might Also <span>Like</span></h2>
    <a href="{{ route('products.index') }}" class="sec-link">View more →</a>
  </div>
</section>
<div class="products-grid four">
  @foreach($suggested as $product)
    @include('partials.product-card', ['product' => $product, 'tall' => true])
  @endforeach
</div>
@endif

{{-- BRANDS BAR --}}
@if($brands->isNotEmpty())
<div class="brands-bar">
  <span class="brands-label">Trusted Brands</span>
  @foreach($brands as $brand)
    <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="brand-item">
      @if($brand->getFirstMediaUrl('logo'))
        <img src="{{ $brand->getFirstMediaUrl('logo') }}" alt="{{ $brand->name }}" class="brand-logo">
      @endif
      {{ $brand->name }}
    </a>
  @endforeach
</div>
@endif

{{-- FOOTER --}}
<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="logo">Ze<span>Shop</span></div>
      <p>Your one-stop marketplace for millions of products. Quality, value, and trust — delivered.</p>
      <div class="socials">
        <div class="social-btn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></div>
        <div class="social-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></div>
        <div class="social-btn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></div>
      </div>
    </div>
    <div class="footer-col">
      <h4>Shop</h4>
      <ul>
        <li><a href="{{ route('products.index') }}">New Arrivals</a></li>
        <li><a href="{{ route('products.index') }}">Flash Deals</a></li>
        <li><a href="{{ route('products.index') }}">Bestsellers</a></li>
        <li><a href="{{ route('products.index') }}">Collections</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Account</h4>
      <ul>
        @auth
          <li><a href="{{ route('account') }}">My Account</a></li>
          <li><a href="{{ route('account') }}">My Orders</a></li>
        @else
          <li><a href="{{ route('login') }}">Sign In</a></li>
          <li><a href="{{ route('register') }}">Register</a></li>
        @endauth
        <li><a href="#">Wishlist</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Company</h4>
      <ul>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Newsletter</h4>
      <p style="font-size:13px;color:#86868b;line-height:1.6;margin-bottom:14px;font-weight:300;">Get the best deals straight to your inbox.</p>
      <div class="newsletter-form">
        <input type="email" placeholder="Your email address">
        <button type="button">Subscribe</button>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ date('Y') }} ZeShop. All rights reserved.</span>
    <div class="footer-legal">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Use</a>
    </div>
  </div>
</footer>

<script>
// Global Add to Cart function
window.addToCart = function(e, productId) {
  e.preventDefault();
  e.stopPropagation();
  const btn = e.target;
  const orig = btn.textContent;
  const origBg = btn.style.background;
  
  btn.textContent = '✓ Added!';
  btn.style.background = 'var(--green)';
  btn.disabled = true;

  fetch('{{ route("cart.add") }}', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: 1
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update cart badges across all pages
      const badges = document.querySelectorAll('.cart-badge');
      badges.forEach(badge => {
        badge.textContent = data.cartCount;
      });
      setTimeout(() => {
        btn.textContent = orig;
        btn.style.background = origBg;
        btn.disabled = false;
      }, 1400);
    }
  })
  .catch(err => {
    console.error('Error:', err);
    btn.textContent = orig;
    btn.style.background = origBg;
    btn.disabled = false;
  });
};

function startTimer() {
  let total = 8*3600 + 34*60 + 12;
  setInterval(() => {
    if (total <= 0) return;
    total--;
    const h = Math.floor(total/3600);
    const m = Math.floor((total%3600)/60);
    const s = total%60;
    document.getElementById('hh').textContent = String(h).padStart(2,'0');
    document.getElementById('mm').textContent = String(m).padStart(2,'0');
    document.getElementById('ss').textContent = String(s).padStart(2,'0');
  }, 1000);
}
startTimer();
</script>
</body>
</html>