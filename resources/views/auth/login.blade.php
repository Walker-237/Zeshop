<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In — ZeShop</title>
<link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
<link rel="icon" type="image/png" sizes="16x16" href="/cpanel/images/favicons/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="32x32" href="/cpanel/images/favicons/favicon-32x32.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    --red:    #ff3b30;
    --green:  #30d158;
    --sans:   -apple-system, 'Inter', 'Helvetica Neue', Helvetica, sans-serif;
  }

  body {
    font-family: var(--sans);
    min-height: 100vh;
    display: flex;
    -webkit-font-smoothing: antialiased;
  }

  /* ── LEFT PANEL — form ── */
  .left {
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px 64px;
    background: var(--white);
  }

  .logo {
    font-size: 26px;
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -0.5px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 40px;
  }
  .logo span { color: var(--blue); }

  .form-eyebrow {
    font-size: 13px;
    color: var(--muted);
    font-weight: 300;
    margin-bottom: 6px;
  }
  .form-title {
    font-size: 36px;
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -1px;
    margin-bottom: 32px;
  }

  /* Alert */
  .alert-error {
    background: #fff0ef;
    border: 0.5px solid #ffcfcc;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    color: var(--red);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .alert-error svg { width: 14px; height: 14px; flex-shrink: 0; }

  /* Form */
  .form-group { margin-bottom: 18px; }
  .form-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: 7px;
  }
  .form-label a {
    font-size: 12px;
    font-weight: 400;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s;
  }
  .form-label a:hover { color: var(--blue); }

  .input-wrap { position: relative; display: flex; align-items: center; }
  .input-icon { position: absolute; left: 14px; color: var(--muted); pointer-events: none; }
  .input-icon svg { width: 16px; height: 16px; display: block; }

  .form-input {
    width: 100%;
    padding: 13px 14px 13px 42px;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-family: var(--sans);
    font-size: 14px;
    color: var(--ink);
    background: var(--pale);
    outline: none;
    transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
  }
  .form-input::placeholder { color: #b0b0b5; font-weight: 300; }
  .form-input:focus {
    border-color: var(--blue);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(0,113,227,0.10);
  }
  .form-input.has-error { border-color: var(--red); box-shadow: 0 0 0 3px rgba(255,59,48,0.08); }

  .toggle-pw {
    position: absolute; right: 14px;
    background: none; border: none; padding: 0;
    cursor: pointer; color: var(--muted); transition: color 0.2s;
  }
  .toggle-pw:hover { color: var(--blue); }
  .toggle-pw svg { width: 16px; height: 16px; display: block; }

  /* Remember row */
  .remember-row {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 24px;
  }
  .custom-check { position: relative; width: 16px; height: 16px; flex-shrink: 0; }
  .custom-check input { position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; margin: 0; }
  .check-box {
    width: 16px; height: 16px; border-radius: 5px;
    border: 1px solid var(--border); background: var(--pale);
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
  }
  .custom-check input:checked ~ .check-box { background: var(--blue); border-color: var(--blue); }
  .check-box svg { display: none; width: 10px; height: 10px; }
  .custom-check input:checked ~ .check-box svg { display: block; }
  .remember-row span { font-size: 13px; color: var(--muted); font-weight: 300; }

  /* Submit */
  .btn-submit {
    width: 100%;
    padding: 14px;
    background: var(--blue);
    color: var(--white);
    font-family: var(--sans);
    font-size: 15px;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    letter-spacing: -0.2px;
    margin-bottom: 22px;
  }
  .btn-submit:hover { background: #0062c4; box-shadow: 0 6px 20px rgba(0,113,227,0.3); transform: scale(0.99); }
  .btn-submit:active { transform: scale(0.97); }

  .form-footer {
    font-size: 13px;
    color: var(--muted);
    text-align: center;
  }
  .form-footer a { color: var(--blue); font-weight: 500; text-decoration: none; }
  .form-footer a:hover { text-decoration: underline; }

  /* ── RIGHT PANEL — illustration ── */
  .right {
    width: 50%;
    background: #dde8f5;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  .right::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(11,34,64,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
  }

  .blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0.35;
  }
  .blob-1 { width: 340px; height: 340px; background: #a8c8f0; top: -80px; right: -80px; }
  .blob-2 { width: 260px; height: 260px; background: #b8d4f8; bottom: -60px; left: -60px; }

  .illustration {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 28px;
  }

  .illo-wrap svg { width: 100%; max-width: 420px; height: auto; }

  .trust-pills {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    max-width: 300px;
  }
  .trust-pill {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(12px);
    border: 0.5px solid rgba(255,255,255,0.9);
    border-radius: 12px;
    padding: 10px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 500;
    color: var(--navy);
  }
  .trust-pill span { font-size: 18px; }
  .trust-pill-sub { font-size: 11px; font-weight: 300; color: var(--muted); display: block; }

  @media (max-width: 768px) {
    body { flex-direction: column; }
    .left { width: 100%; padding: 40px 28px; }
    .right { width: 100%; min-height: 280px; }
    .illo-wrap svg { width: 220px; }
  }
</style>
</head>
<body>

<!-- LEFT: Form -->
<div class="left">

  <a href="{{ route('home') }}" class="logo">Ze<span>Shop</span></a>

  <p class="form-eyebrow">Welcome back !</p>
  <h1 class="form-title">Sign in</h1>

  @if ($errors->any())
    <div class="alert-error">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ $errors->first() }}
    </div>
  @endif

  @if (session('error'))
    <div class="alert-error">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
      <label class="form-label" for="email">Email</label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </span>
        <input
          id="email"
          type="email"
          name="email"
          class="form-input @error('email') has-error @enderror"
          value="{{ old('email') }}"
          placeholder="you@example.com"
          autocomplete="email"
          required
          autofocus
        >
      </div>
    </div>

    <div class="form-group">
      <label class="form-label" for="password">
        Password
        <a href="#">Forgot Password?</a>
      </label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
        </span>
        <input
          id="password"
          type="password"
          name="password"
          class="form-input @error('password') has-error @enderror"
          placeholder="••••••••"
          autocomplete="current-password"
          required
        >
        <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="Show password">
          <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>
    </div>

    <div class="remember-row">
      <label class="custom-check">
        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <div class="check-box">
          <svg viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg>
        </div>
      </label>
      <span>Keep me signed in</span>
    </div>

    <button type="submit" class="btn-submit">Sign In →</button>
  </form>

  <p class="form-footer">
    Don't have an account? <a href="{{ route('register') }}">Sign up</a>
  </p>

</div>

<!-- RIGHT: Illustration -->
<div class="right">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="illustration">
    <div class="illo-wrap">
      <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="800px" height="605.3px" viewBox="0 0 800 605.3" style="enable-background:new 0 0 800 605.3;" xml:space="preserve">
<style type="text/css">
	.st0{fill:#007BFF;stroke:#211F44;stroke-width:2;stroke-miterlimit:10;}
	.st1{opacity:0.2;fill:#0B2252;}
	.st2{fill:url(#SVGID_1_);}
	.st3{fill:#0B2252;}
	.st4{fill:url(#SVGID_2_);}
	.st5{fill:#101111;}
	.st6{fill:#007BFF;}
	.st7{fill:#FF9F91;}
	.st8{fill:#FFAA9D;}
	.st9{fill:#14336A;}
	.st10{fill:#2B3872;}
</style>
<g>
	<path class="st0" d="M446,296c-0.3-1.7-1.9-2.8-3.6-2.4l-42.6,8.1l0,0l0,0c-0.1,0-0.1,0-0.2,0l0,0c0,0-0.1,0-0.1,0c0,0-0.1,0-0.1,0
		l0,0c-0.4,0.1-0.8,0.4-1.1,0.7l0,0c0,0,0,0-0.1,0c0,0,0,0-0.1,0.1l0,0c-0.2,0.2-0.4,0.5-0.5,0.8l0,0c0,0,0,0.1-0.1,0.1
		c0,0,0,0,0,0.1l0,0c0,0.1-0.1,0.1-0.1,0.2l0,0l-22,72.2l-239.6-0.1c-1,0-1.9,0.5-2.4,1.2c-0.6,0.8-0.8,1.8-0.5,2.7l35.4,128.5
		c0.4,1.3,1.6,2.3,3,2.3c0,0,0,0,0,0l167.2,0l0,0c0,0,0,0,0,0l14.9,0c7,0,12.1,1.8,15.2,5.5c2.7,3.1,4,7.8,4,13.8
		c0,10.6-8.6,19.2-19.3,19.2l-225.9-0.1c-1.7,0-3.1,1.4-3.1,3.1c0,1.7,1.4,3.1,3.1,3.1l225.9,0.1c2.3,0,4.5-0.3,6.6-0.9
		c4.3-1.1,8.1-3.4,11.4-6.6c4.8-4.8,7.4-11.2,7.4-17.9c0-7.5-1.8-13.5-5.5-17.8c-4.3-5.1-11-7.6-19.9-7.6l-10.8,0l60.1-197l40.8-7.8
		c0.8-0.2,1.5-0.6,2-1.3C446,297.6,446.2,296.8,446,296z M373.6,382.1l-8.2,26.8l-42.2,0l4.7-26.8L373.6,382.1z M364.4,412.3
		l-8.9,29.2l-38,0l5.2-29.2L364.4,412.3z M258.6,408.9l0-26.8l65.9,0l-4.7,26.8L258.6,408.9z M344.5,477.5l-8.2,26.8l-30,0l4.7-26.8
		L344.5,477.5z M258.6,441.5l0-29.3l60.6,0l-5.2,29.2L258.6,441.5z M258.6,474.1l0-29.3l54.8,0l-5.2,29.2L258.6,474.1z M354.5,444.9
		l-8.9,29.2l-33.9,0l5.2-29.2L354.5,444.9z M307.7,477.5l-4.7,26.8l-44.4,0l0-26.8L307.7,477.5z M205.6,477.5l4.7,26.8l-36.7,0
		l-7.4-26.8L205.6,477.5z M255.2,444.9l0,29.2l-46.8,0l-5.1-29.3L255.2,444.9z M199.9,444.9l5.1,29.3l-39.7,0l-8.1-29.3L199.9,444.9
		z M255.2,412.2l0,29.2l-52.5,0l-5.1-29.3L255.2,412.2z M194.1,412.2l5.1,29.3l-42.9,0l-8.1-29.3L194.1,412.2z M255.2,382l0,26.8
		l-58.3,0l-4.7-26.8L255.2,382z M193.6,408.9l-46.2,0l-7.4-26.8l48.9,0L193.6,408.9z M255.2,477.5l0,26.8l-41.4,0l-4.7-26.8
		L255.2,477.5z"/>
	<path class="st0" d="M185.6,559.6c-8.6,0-15.5,7-15.5,15.5c0,8.6,7,15.5,15.5,15.5c1.4,0,2.7-0.2,4-0.5c6.6-1.8,11.5-7.8,11.5-15
		c0-4.1-1.6-8-4.5-11C193.6,561.2,189.7,559.6,185.6,559.6z M185.6,584.5c-2.5,0-4.9-1-6.6-2.8c-1.8-1.8-2.7-4.1-2.7-6.6
		c0-4.3,3-8,7-9.1c0.8-0.2,1.6-0.3,2.4-0.3c5.2,0,9.4,4.2,9.4,9.4c0,2.5-1,4.9-2.8,6.6C190.4,583.5,188.1,584.5,185.6,584.5z"/>
	<path class="st0" d="M318,559.6c-8.6,0-15.5,7-15.5,15.5c0,4.1,1.6,8,4.5,11c2.9,2.9,6.8,4.6,11,4.6c1.4,0,2.7-0.2,4-0.5
		c6.6-1.8,11.5-7.8,11.5-15C333.5,566.6,326.5,559.6,318,559.6z M318,584.5c-5.2,0-9.4-4.2-9.4-9.4c0-4.3,3-8,7-9.1
		c0.8-0.2,1.6-0.3,2.4-0.3c5.2,0,9.4,4.2,9.4,9.4C327.4,580.3,323.1,584.5,318,584.5z"/>
	<path class="st0" d="M318,569.1c-1.6,0-3.1,0.6-4.3,1.8c-1.1,1.1-1.8,2.6-1.8,4.3c0,3.3,2.7,6,6,6c0.5,0,1.1-0.1,1.6-0.2
		c2.6-0.7,4.5-3,4.5-5.8C324,571.8,321.3,569.1,318,569.1z M318,577.8c-0.7,0-1.4-0.3-1.9-0.8c-0.5-0.5-0.8-1.2-0.8-1.9
		c0-1.2,0.8-2.3,2-2.6c0.2-0.1,0.4-0.1,0.7-0.1c0.7,0,1.4,0.3,1.9,0.8c0.5,0.5,0.8,1.2,0.8,1.9C320.6,576.6,319.4,577.8,318,577.8z"/>
	<path class="st0" d="M185.6,569.1c-3.3,0-6,2.7-6,6c0,3.3,2.7,6,6,6c0.5,0,1.1-0.1,1.6-0.2c2.6-0.7,4.5-3,4.5-5.8
		c0-1.6-0.6-3.1-1.8-4.3C188.7,569.7,187.2,569.1,185.6,569.1z M185.6,577.8c-0.7,0-1.4-0.3-1.9-0.8c-0.5-0.5-0.8-1.2-0.8-1.9
		c0-1.2,0.8-2.3,2-2.6c0.2-0.1,0.4-0.1,0.7-0.1c1.5,0,2.6,1.2,2.6,2.7c0,0.7-0.3,1.4-0.8,1.9C186.9,577.5,186.3,577.8,185.6,577.8z"/>
	<path class="st0" d="M151.9,503.7c0.1,0,0.3,0,0.4-0.1c0,0,0,0,0,0c0.9-0.2,1.4-1.2,1.2-2.1L139,448.9c-0.1-0.4-0.4-0.8-0.8-1
		c-0.4-0.2-0.8-0.3-1.3-0.2c-0.9,0.2-1.4,1.2-1.2,2.1l14.5,52.6C150.5,503.1,151.1,503.7,151.9,503.7z"/>
	<path class="st0" d="M124.2,454.6c0.4-0.1,0.8-0.4,1-0.8c0.2-0.4,0.3-0.8,0.2-1.3l-8.3-29.9c-0.1-0.4-0.4-0.8-0.8-1
		c-0.4-0.2-0.9-0.3-1.3-0.2c-0.4,0.1-0.8,0.4-1,0.8c-0.2,0.4-0.3,0.8-0.2,1.3l8.3,29.9c0.2,0.7,0.9,1.2,1.6,1.2
		C123.9,454.7,124.1,454.7,124.2,454.6C124.2,454.6,124.2,454.6,124.2,454.6z"/>
	<path class="st0" d="M130.1,477.4c0.1,0,0.3,0,0.4-0.1c0,0,0,0,0,0c0.4-0.1,0.8-0.4,1-0.8s0.3-0.8,0.2-1.3l-4.3-15.6
		c-0.1-0.4-0.4-0.8-0.8-1c-0.4-0.2-0.8-0.3-1.3-0.2c-0.4,0.1-0.8,0.4-1,0.8c-0.2,0.4-0.3,0.8-0.2,1.3l4.3,15.6
		C128.6,476.8,129.3,477.4,130.1,477.4z"/>
</g>
<ellipse class="st1" cx="390.6" cy="585.6" rx="390.6" ry="11.1"/>
<g>
	<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="5363.6987" y1="548.3779" x2="5430.1011" y2="548.3779" gradientTransform="matrix(1 0 0 1 -4892.647 0)">
		<stop offset="0" style="stop-color:#FFAA9D"/>
		<stop offset="0.9662" style="stop-color:#FF9F91"/>
	</linearGradient>
	<polygon class="st2" points="471.1,540.5 471.1,559.2 535.1,559.2 537.5,537.6"/>
	<path class="st3" d="M471.1,559.2l-12,13.5c-1,1.1-1,2.6-0.4,3.8c0.5,0.9,1.5,1.6,2.8,1.6h69.1c0.6,0,1.2-0.2,1.6-0.6
		c0.4-0.4,0.7-0.9,0.8-1.6l2.1-16.7H471.1z"/>
	<linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="-424.8233" y1="548.3589" x2="-357.5445" y2="548.3589" gradientTransform="matrix(-1 0 0 1 224.6386 0)">
		<stop offset="0" style="stop-color:#FFAA9D"/>
		<stop offset="0.9662" style="stop-color:#FF9F91"/>
	</linearGradient>
	<polygon class="st4" points="647.6,540.4 649.5,559.2 585.4,559.2 582.2,537.5"/>
	<path class="st3" d="M649.5,559.2l12,13.5c1,1.1,1,2.6,0.4,3.8c-0.5,0.9-1.5,1.6-2.8,1.6h-69.1c-0.6,0-1.2-0.2-1.6-0.6
		c-0.4-0.4-0.7-0.9-0.8-1.6l-2.1-16.7H649.5z"/>
	<path class="st5" d="M503.2,213.8c0,0-24.5,83.6-29.1,147.2c-4.5,63.6-4.3,181.6-4.3,181.6h68.5c0,0,16-161.2,22.4-161.7
		c6.4-0.6,19.1,161.7,19.1,161.7h71.6c0,0-16.1-277.5-41.7-328.8H503.2z"/>
	<path class="st6" d="M610,88c-13-9.5-34.4-15.1-54.3-15.1c-18.4,0-36.9,5.9-52.9,13.4c-22.7,10.7-21.8,155-17.8,164.9
		c6.7,16.6,131.6,16.8,141.5-1.6C632.4,238.7,623.9,98.1,610,88z"/>
	<g>
		<path class="st7" d="M547.6,76.3c1.2-6.1,1-12.4,1.5-16.2c0,0,15.7-0.3,15.7-0.1c0.2,2,1.3,14.7,1.4,16.2
			C566.7,82,546.4,82.7,547.6,76.3z"/>
		<path class="st8" d="M576.9,29.7c-2-1.9-13.7-2.9-19.3-2.9c-2.3,0-6-2.1-9.2-1.8c-4.7,0.5-8.8,3.6-10,4.7c-2,1.9-0.1,22.8,1,26.8
			c1.2,4,6.8,14.2,18.3,14.2s17.1-10.2,18.3-14.2C577.1,52.5,579,31.6,576.9,29.7z"/>
		<path class="st9" d="M577.8,27.6c1.7-0.9,4.3-9.6-4.4-10.9c0,0,2.6-8.1-7.1-7.8c-9.6,0.3-26.8,5.6-28.9,20.3
			c-2.1,14.7,0.3,26.7,2.3,32.7c1,3,6.4,11.9,17.8,11.9c11.5,0,16.2-9,17.1-12c1.6-4.9,4.8-13.6,3.9-24.6c0.6-0.1,1.3-0.3,1.8-0.6
			C587,33.3,576.1,28.5,577.8,27.6z M568.1,59.9c-4.5-2-6.2-3-10.6-3c-4.4,0-5.9,0.4-10.3,2.4c-5,2.2-9.7-17.3-5.6-23
			c4.1-5.7,5.5-6,6.8-10.4c0,0,7.3,6.5,14.9,5.7c0,0,2.4-0.5,2.2-3.6c0,0,2.7,4.3,8.2,8.2C576.8,38.7,573,62.2,568.1,59.9z"/>
	</g>
	<g>
		<path class="st8" d="M365.4,78.5c0,0-3.8-16.8-8.8-22.7c-4-4.8-4.9,3.8-4.9,3.8s-21-3.8-32.8-6.7c-2.7-0.7-4.7,2.6-2.9,4.7
			c7,8.1,19,19.9,29.8,21H365.4z"/>
		<path class="st6" d="M541.8,88.6c0,0-8.7-4.4-29-2.4c-20.3,2.1-43.7,21.9-82.9,19.5c-39.3-2.4-63.8-28.6-63.8-28.6h-25.7
			c0,0,7.8,95.9,91.8,94.5c84-1.4,116.9-13,116.9-13L541.8,88.6z"/>
	</g>
	<g>
		<path class="st8" d="M749.9,78.4c0,0,3.8-16.8,8.8-22.7c4-4.8,4.9,3.8,4.9,3.8s21-3.8,32.8-6.7c2.7-0.7,4.7,2.6,2.9,4.7
			c-7,8.1-19,19.9-29.8,21H749.9z"/>
		<path class="st6" d="M573.5,88.5c0,0,8.7-4.4,29-2.4c20.3,2.1,43.7,21.9,82.9,19.5c39.3-2.4,63.8-28.6,63.8-28.6h25.7
			c0,0-7.8,95.9-91.8,94.5c-84-1.4-116.9-13-116.9-13L573.5,88.5z"/>
	</g>
</g>
<g>
	<path class="st10" d="M280.9,291.9h6.1c0.9,0,1.6,0.7,1.6,1.6l0,0c0,0.9-0.7,1.6-1.6,1.6h-6.1c-0.9,0-1.6-0.7-1.6-1.6
		c0-0.4,0.2-0.8,0.5-1.1C280.1,292.1,280.5,291.9,280.9,291.9z"/>
	<path class="st10" d="M303.8,293.5c0,0.4-0.2,0.9-0.5,1.1c-0.3,0.3-0.7,0.5-1.1,0.5h-6.1c-0.9,0-1.6-0.7-1.6-1.6l0,0
		c0-0.9,0.7-1.6,1.6-1.6h6.1C303.1,291.9,303.8,292.6,303.8,293.5z"/>
	<path class="st10" d="M293.1,282.8v6.1c0,0.9-0.7,1.6-1.6,1.6l0,0c-0.9,0-1.6-0.7-1.6-1.6v-6.1c0-0.9,0.7-1.6,1.6-1.6
		c0.4,0,0.8,0.2,1.1,0.5S293.1,282.4,293.1,282.8z"/>
	<path class="st10" d="M291.6,296.4L291.6,296.4c0.9,0,1.6,0.7,1.6,1.6v6.1c0,0.9-0.7,1.6-1.6,1.6c-0.4,0-0.8-0.2-1.1-0.5
		c-0.3-0.3-0.5-0.7-0.5-1.1V298C290,297.2,290.7,296.4,291.6,296.4z"/>
</g>
<path class="st10" d="M279.3,130.2c-4.5,0-8.1,3.6-8.1,8.1c0,4.5,3.6,8.1,8.1,8.1s8.1-3.6,8.1-8.1
	C287.4,133.8,283.8,130.2,279.3,130.2z M279.3,143.8c-3,0-5.5-2.5-5.5-5.5c0-3,2.5-5.5,5.5-5.5s5.5,2.5,5.5,5.5
	C284.8,141.3,282.4,143.8,279.3,143.8z"/>
<path class="st10" d="M438.5,406c-3.5,0-6.3,2.8-6.3,6.3c0,3.5,2.8,6.3,6.3,6.3c3.5,0,6.3-2.8,6.3-6.3
	C444.7,408.8,441.9,406,438.5,406z M438.5,415.7c-1.9,0-3.5-1.6-3.5-3.5c0-1.9,1.6-3.5,3.5-3.5c1.9,0,3.5,1.6,3.5,3.5
	C442,414.2,440.4,415.7,438.5,415.7z"/>
<g>
	<path class="st10" d="M447.7,58.3h6.3c0.9,0,1.6,0.7,1.6,1.6l0,0c0,0.9-0.7,1.6-1.6,1.6h-6.3c-0.9,0-1.6-0.7-1.6-1.6
		c0-0.4,0.2-0.9,0.5-1.1C446.9,58.5,447.3,58.3,447.7,58.3z"/>
	<path class="st10" d="M471.3,59.9c0,0.5-0.2,0.9-0.5,1.2c-0.3,0.3-0.7,0.5-1.1,0.5h-6.3c-0.9,0-1.6-0.7-1.6-1.6l0,0
		c0-0.9,0.7-1.6,1.6-1.6h6.3C470.5,58.3,471.2,59,471.3,59.9z"/>
	<path class="st10" d="M460.3,49v6.3c0,0.9-0.7,1.6-1.6,1.6l0,0c-0.9,0-1.6-0.7-1.6-1.6V49c0-0.9,0.7-1.6,1.6-1.6
		c0.4,0,0.9,0.2,1.1,0.5C460.1,48.1,460.3,48.5,460.3,49z"/>
	<path class="st10" d="M458.7,63L458.7,63c0.9,0,1.6,0.7,1.6,1.6v6.3c0,0.9-0.7,1.6-1.6,1.6c-0.4,0-0.9-0.2-1.1-0.5
		c-0.3-0.3-0.5-0.7-0.5-1.1v-6.3C457.1,63.7,457.8,63,458.7,63z"/>
</g>
</svg>
    </div>

    <div class="trust-pills">
      <div class="trust-pill">
        <span>🛡️</span>
        <div>
          Buyer Protection
          <span class="trust-pill-sub">100% money-back guarantee</span>
        </div>
      </div>
      <div class="trust-pill">
        <span>🚚</span>
        <div>
          Free Shipping
          <span class="trust-pill-sub">On all orders over 49 FCFA</span>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function togglePw() {
  const input = document.getElementById('password');
  const icon  = document.getElementById('eye-icon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
  } else {
    input.type = 'password';
    icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
  }
}
</script>
</body>
</html>