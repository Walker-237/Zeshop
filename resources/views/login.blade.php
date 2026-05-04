<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Walker — Log in</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #1e1d24;
      --panel-bg: #28262f;
      --accent: #6c63ff;
      --accent-hover: #7d75ff;
      --input-bg: #35323e;
      --input-border: #45424f;
      --input-focus: #6c63ff;
      --text-primary: #f0eef8;
      --text-secondary: #9e9aae;
      --text-muted: #6e6a7c;
      --white: #ffffff;
      --radius: 10px;
      --transition: 0.22s ease;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    /* ── Card ── */
    .card {
      display: flex;
      width: 860px;
      max-width: 100%;
      min-height: 520px;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 32px 80px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,255,255,0.05);
      animation: fadeUp 0.6s cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Left Panel ── */
    .left {
      position: relative;
      flex: 0 0 42%;
      background:
        linear-gradient(160deg, rgba(60,30,100,0.6) 0%, rgba(20,10,50,0.75) 100%),
        url('/images/l.jpg') center/cover no-repeat;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 24px 26px 32px;
      overflow: hidden;
    }

    .left::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at 60% 80%, rgba(108,99,255,0.25) 0%, transparent 70%);
    }

    .top-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      z-index: 1;
    }

    .logo {
      font-family: 'Sora', sans-serif;
      font-weight: 600;
      font-size: 1.25rem;
      color: var(--white);
      letter-spacing: 0.04em;
    }

    .back-btn {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.72rem;
      font-weight: 500;
      color: rgba(255,255,255,0.75);
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 20px;
      padding: 5px 12px;
      cursor: pointer;
      transition: var(--transition);
      text-decoration: none;
      backdrop-filter: blur(6px);
    }
    .back-btn:hover { background: rgba(255,255,255,0.18); color: #fff; }

    .left-footer { position: relative; z-index: 1; }

    .tagline {
      font-family: 'Sora', sans-serif;
      font-size: 1.35rem;
      font-weight: 400;
      color: var(--white);
      line-height: 1.45;
      margin-bottom: 18px;
    }

    .dots { display: flex; gap: 6px; }
    .dot {
      width: 18px; height: 4px;
      border-radius: 2px;
      background: rgba(255,255,255,0.28);
      transition: var(--transition);
    }
    .dot.active { background: var(--white); width: 26px; }

    /* ── Right Panel ── */
    .right {
      flex: 1;
      background: var(--panel-bg);
      padding: 44px 44px 36px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-title {
      font-family: 'Sora', sans-serif;
      font-size: 1.65rem;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 6px;
    }

    .form-sub {
      font-size: 0.82rem;
      color: var(--text-secondary);
      margin-bottom: 28px;
    }
    .form-sub a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition);
    }
    .form-sub a:hover { color: var(--accent-hover); text-decoration: underline; }

    /* ── Fields ── */
    .field {
      position: relative;
      margin-bottom: 12px;
    }

    .field input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: var(--radius);
      padding: 11px 14px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.82rem;
      color: var(--text-primary);
      outline: none;
      transition: border-color var(--transition), box-shadow var(--transition);
    }
    .field input::placeholder { color: var(--text-muted); }
    .field input:focus {
      border-color: var(--input-focus);
      box-shadow: 0 0 0 3px rgba(108,99,255,0.18);
    }

    .eye-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      transition: color var(--transition);
      padding: 0;
    }
    .eye-btn:hover { color: var(--text-secondary); }

    /* ── Remember / Forgot row ── */
    .meta-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }

    .checkbox-wrap {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .checkbox-wrap input[type="checkbox"] {
      appearance: none;
      width: 16px;
      height: 16px;
      border: 1.5px solid var(--input-border);
      border-radius: 4px;
      background: var(--input-bg);
      cursor: pointer;
      position: relative;
      flex-shrink: 0;
      transition: background var(--transition), border-color var(--transition);
    }
    .checkbox-wrap input[type="checkbox"]:checked {
      background: var(--accent);
      border-color: var(--accent);
    }
    .checkbox-wrap input[type="checkbox"]:checked::after {
      content: '';
      position: absolute;
      left: 3.5px;
      top: 1px;
      width: 5px;
      height: 9px;
      border: 2px solid #fff;
      border-top: none;
      border-left: none;
      transform: rotate(45deg);
    }
    .checkbox-wrap label {
      font-size: 0.77rem;
      color: var(--text-secondary);
      cursor: pointer;
    }

    .forgot-link {
      font-size: 0.77rem;
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition);
    }
    .forgot-link:hover { color: var(--accent-hover); text-decoration: underline; }

    /* ── CTA ── */
    .btn-primary {
      width: 100%;
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: var(--radius);
      padding: 12px;
      font-family: 'Sora', sans-serif;
      font-size: 0.88rem;
      font-weight: 500;
      cursor: pointer;
      transition: background var(--transition), transform 0.12s ease, box-shadow var(--transition);
      letter-spacing: 0.01em;
      margin-bottom: 12px;
    }
    .btn-primary:hover {
      background: var(--accent-hover);
      box-shadow: 0 6px 24px rgba(108,99,255,0.38);
    }
    .btn-primary:active { transform: scale(0.98); }

    .or-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 12px;
    }
    .or-row span { font-size: 0.72rem; color: var(--text-muted); white-space: nowrap; }
    .or-row::before, .or-row::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--input-border);
    }

    .social-row { display: flex; gap: 12px; }

    .btn-social {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: var(--radius);
      padding: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.8rem;
      font-weight: 500;
      color: var(--text-primary);
      cursor: pointer;
      transition: border-color var(--transition), background var(--transition);
    }
    .btn-social:hover {
      border-color: var(--accent);
      background: rgba(108,99,255,0.08);
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
      .left { display: none; }
      .right { padding: 36px 28px; }
      .card { width: 100%; border-radius: 14px; }
    }
  
    /* ═══════════════════════════════
       BUBBLE BACKGROUND
    ═══════════════════════════════ */
    #bubble-bg {
      position: fixed;
      inset: 0;
      overflow: hidden;
      background: linear-gradient(135deg, #0f0b1e 0%, #0a1228 100%);
      z-index: 0;
    }
    body {
      background: transparent;
      position: relative;
      z-index: 1;
    }
    .card { position: relative; z-index: 2; }

    #bubbles-inner {
      position: absolute;
      inset: 0;
      filter: url(#bubble-goo) blur(40px);
    }

    .bubble {
      position: absolute;
      border-radius: 50%;
      mix-blend-mode: hard-light;
    }
    .bubble-orbit {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* colours */
    .b1 { background: radial-gradient(circle at center, rgba(18,113,255,0.85) 0%, rgba(18,113,255,0) 50%);
          width: 80%; height: 80%; top: 10%; left: 10%;
          animation: floatY 30s ease-in-out infinite; }

    .o1 { transform-origin: calc(50% - 400px) center;
          animation: spin 20s linear infinite; }
    .b2 { background: radial-gradient(circle at center, rgba(221,74,255,0.85) 0%, rgba(221,74,255,0) 50%);
          width: 80%; height: 80%; }

    .o2 { transform-origin: calc(50% + 400px) center;
          animation: spin 40s linear infinite; }
    .b3 { background: radial-gradient(circle at center, rgba(0,220,255,0.85) 0%, rgba(0,220,255,0) 50%);
          position: absolute;
          width: 80%; height: 80%;
          top: calc(50% + 200px); left: calc(50% - 500px); }

    .b4 { background: radial-gradient(circle at center, rgba(200,50,50,0.75) 0%, rgba(200,50,50,0) 50%);
          width: 80%; height: 80%; top: 10%; left: 10%; opacity: .7;
          animation: floatX 40s ease-in-out infinite; }

    .o3 { transform-origin: calc(50% - 800px) calc(50% + 200px);
          animation: spin 20s linear infinite; }
    .b5 { background: radial-gradient(circle at center, rgba(180,180,50,0.85) 0%, rgba(180,180,50,0) 50%);
          position: absolute;
          width: 160%; height: 160%;
          top: calc(50% - 80%); left: calc(50% - 80%); }

    .b6 { background: radial-gradient(circle at center, rgba(140,100,255,0.75) 0%, rgba(140,100,255,0) 50%);
          width: 100%; height: 100%; top: 0; left: 0; opacity: .7;
          pointer-events: none;
          transition: transform 0.08s linear; }

    @keyframes floatY {
      0%,100% { transform: translateY(-50px); }
      50%      { transform: translateY(50px); }
    }
    @keyframes floatX {
      0%,100% { transform: translateX(-50px); }
      50%      { transform: translateX(50px); }
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }

  </style>
</head>
<body>

<!-- ═══ BUBBLE BACKGROUND ═══ -->
<div id="bubble-bg" aria-hidden="true">
  <svg style="position:absolute;width:0;height:0;overflow:hidden">
    <defs>
      <filter id="bubble-goo">
        <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"/>
        <feColorMatrix in="blur" mode="matrix" result="goo"
          values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -8"/>
        <feBlend in="SourceGraphic" in2="goo"/>
      </filter>
    </defs>
  </svg>
  <div id="bubbles-inner">
    <div class="bubble b1"></div>
    <div class="bubble-orbit o1"><div class="bubble b2"></div></div>
    <div class="bubble-orbit o2"><div class="bubble b3"></div></div>
    <div class="bubble b4"></div>
    <div class="bubble-orbit o3"><div class="bubble b5"></div></div>
    <div class="bubble b6" id="mouse-bubble"></div>
  </div>
</div>


<div class="card">

  <!-- LEFT -->
  <div class="left">
    <div class="top-bar">
      <div class="logo">Walker</div>
      <a href="#" class="back-btn">
        Back to website
        <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
          <path d="M2 5h6M5.5 2.5 8 5l-2.5 2.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
    <div class="left-footer">
      <p class="tagline">Capturing Moments,<br>Creating Memories</p>
      <div class="dots">
        <div class="dot"></div>
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <h1 class="form-title">Welcome back</h1>
    <p class="form-sub">Don't have an account? <a href="/signup">Sign up</a></p>

    <form action="{{route('login')}}" method="post">
      @csrf

      <div class="field">
        <input type="email" placeholder="Email address" name="email" />
      </div>
  
      <div class="field">
        <input type="password" id="pwd" placeholder="Password" name="password" />
        <button class="eye-btn" onclick="togglePwd()" aria-label="Toggle password">
          <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>
  
      <div class="meta-row">
        <div class="checkbox-wrap">
          <input type="checkbox" id="remember" checked />
          <label for="remember">Remember me</label>
        </div>
        <a href="/forgot-password" class="forgot-link">Forgot password?</a>
      </div>
  
      <input type="submit" value="Login" class="btn-primary">

    </form>


    <div class="or-row"><span>Or continue with</span></div>

    <div class="social-row">
      <button class="btn-social">
        <svg width="16" height="16" viewBox="0 0 48 48">
          <path fill="#4285F4" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 5.1 29.6 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21c10.5 0 20-7.5 20-21 0-1.3-.2-2.7-.5-4z"/>
          <path fill="#34A853" d="M6.3 14.7l7 5.1C15.1 16.5 19.2 14 24 14c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 5.1 29.6 3 24 3 16.3 3 9.7 7.8 6.3 14.7z"/>
          <path fill="#FBBC05" d="M24 45c5.5 0 10.5-1.9 14.4-5l-6.7-5.5C29.7 36.1 27 37 24 37c-6.1 0-11.2-4-13-9.6l-7 5.4C7.5 40.5 15.2 45 24 45z"/>
          <path fill="#EA4335" d="M44.5 20H24v8.5h11.8c-.8 2.4-2.3 4.4-4.3 5.8l6.7 5.5C42.2 36.5 45 30.7 45 24c0-1.3-.2-2.7-.5-4z"/>
        </svg>
        Google
      </button>
      <button class="btn-social">
        <svg width="15" height="15" viewBox="0 0 814 1000" fill="currentColor">
          <path d="M788.1 340.9c-5.8 4.5-108.2 62.2-108.2 190.5 0 148.4 130.3 200.9 134.2 202.2-.6 3.2-20.7 71.9-68.7 141.9-42.8 61.6-87.5 123.1-155.5 123.1s-85.5-39.5-164-39.5c-76 0-103.7 40.8-165.9 40.8s-105-57.8-155.5-127.4C46.7 790.7 0 663 0 541.8c0-207.1 134.8-316.6 267.9-316.6 70.2 0 128.7 45.5 172.8 45.5 42.3 0 109.2-48.7 190.1-48.7 45.7 0 179.6 3.2 263.5 120.3zm-234.5-79.7c38.8-50.1 66.5-119.7 66.5-189.3 0-9.7-.7-19.4-2.5-27.7-61.5 2.5-139 41.5-183.8 97.3-34.2 40.8-68.7 110.4-68.7 181.1 0 10.3 1.9 20.7 2.5 24 4.5.6 11.7 1.3 18.9 1.3 55.9 0 126.6-38.8 167.1-86.7z"/>
        </svg>
        Apple
      </button>
    </div>
  </div>

</div>

<script>
  function togglePwd() {
    const pwd = document.getElementById('pwd');
    const icon = document.getElementById('eye-icon');
    if (pwd.type === 'password') {
      pwd.type = 'text';
      icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
      pwd.type = 'password';
      icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
  }

  // ── Interactive mouse bubble ──
  (function() {
    const el = document.getElementById('mouse-bubble');
    let cx = window.innerWidth / 2, cy = window.innerHeight / 2;
    let tx = 0, ty = 0, vx = 0, vy = 0;
    const stiffness = 0.06, damping = 0.82;
    document.addEventListener('mousemove', e => { cx = e.clientX; cy = e.clientY; });
    function tick() {
      const dx = cx - window.innerWidth/2 - tx;
      const dy = cy - window.innerHeight/2 - ty;
      vx = (vx + dx * stiffness) * damping;
      vy = (vy + dy * stiffness) * damping;
      tx += vx; ty += vy;
      el.style.transform = 'translate(' + tx + 'px,' + ty + 'px)';
      requestAnimationFrame(tick);
    }
    tick();
  })();
</script>

</body>
</html>