<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Walker — Forgot Password</title>
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
      --success: #4caf88;
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
        url('/images/fp.jpg') center/cover no-repeat;
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

    /* ── Step: Request ── */
    #step-request, #step-success { transition: opacity 0.3s ease; }
    #step-success { display: none; }

    /* Icon badge */
    .icon-badge {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      background: rgba(108,99,255,0.15);
      border: 1.5px solid rgba(108,99,255,0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 22px;
    }

    .form-title {
      font-family: 'Sora', sans-serif;
      font-size: 1.65rem;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 8px;
    }

    .form-desc {
      font-size: 0.82rem;
      color: var(--text-secondary);
      line-height: 1.6;
      margin-bottom: 28px;
    }

    /* ── Field ── */
    .field {
      position: relative;
      margin-bottom: 20px;
    }

    .field label {
      display: block;
      font-size: 0.75rem;
      font-weight: 500;
      color: var(--text-secondary);
      margin-bottom: 6px;
      letter-spacing: 0.02em;
    }

    .field input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: var(--radius);
      padding: 11px 14px 11px 40px;
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

    .field-icon {
      position: absolute;
      left: 12px;
      bottom: 11px;
      color: var(--text-muted);
      pointer-events: none;
    }

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
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-primary:hover {
      background: var(--accent-hover);
      box-shadow: 0 6px 24px rgba(108,99,255,0.38);
    }
    .btn-primary:active { transform: scale(0.98); }

    .btn-ghost {
      width: 100%;
      background: transparent;
      color: var(--text-secondary);
      border: 1.5px solid var(--input-border);
      border-radius: var(--radius);
      padding: 11px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.82rem;
      font-weight: 500;
      cursor: pointer;
      transition: border-color var(--transition), color var(--transition), background var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
    }
    .btn-ghost:hover {
      border-color: var(--accent);
      color: var(--text-primary);
      background: rgba(108,99,255,0.06);
    }

    /* ── Success state ── */
    .success-badge {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: rgba(76, 175, 136, 0.15);
      border: 1.5px solid rgba(76, 175, 136, 0.35);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 22px;
    }

    .success-title {
      font-family: 'Sora', sans-serif;
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 8px;
    }

    .success-desc {
      font-size: 0.82rem;
      color: var(--text-secondary);
      line-height: 1.65;
      margin-bottom: 10px;
    }

    .email-highlight {
      font-weight: 500;
      color: var(--accent);
    }

    .resend-row {
      font-size: 0.78rem;
      color: var(--text-muted);
      margin-bottom: 28px;
    }
    .resend-row button {
      background: none;
      border: none;
      color: var(--accent);
      font-size: 0.78rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      cursor: pointer;
      padding: 0;
      transition: color var(--transition);
    }
    .resend-row button:hover { color: var(--accent-hover); text-decoration: underline; }

    /* countdown */
    #countdown { font-variant-numeric: tabular-nums; }

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
      <a href="/" class="back-btn">
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
        <div class="dot"></div>
        <div class="dot active"></div>
        <div class="dot"></div>
      </div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">

    <!-- Step 1: Enter email -->
    <div id="step-request">
      <div class="icon-badge">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#6c63ff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="4" width="20" height="16" rx="3"/>
          <path d="m2 7 10 7 10-7"/>
        </svg>
      </div>

      <h1 class="form-title">Forgot password?</h1>
      <p class="form-desc">No worries — enter your email address and we'll send you a link to reset your password.</p>

      <div class="field">
        <label for="email">Email address</label>
        <input type="email" id="email" placeholder="Enter your email..." />
        <svg class="field-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="4" width="20" height="16" rx="3"/><path d="m2 7 10 7 10-7"/>
        </svg>
      </div>

      <button class="btn-primary" onclick="sendReset()">
        Send reset link
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </button>

      <a href="/auth/login" class="btn-ghost">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to log in
      </a>
    </div>

    <!-- Step 2: Success -->
    <div id="step-success">
      <div class="success-badge">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4caf88" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>

      <h1 class="success-title">Check your inbox</h1>
      <p class="success-desc">
        We've sent a password reset link to<br>
        <span class="email-highlight" id="sent-email"></span>
      </p>
      <p class="success-desc">The link will expire in 15 minutes. If you don't see it, check your spam folder.</p>

      <div class="resend-row">
        Didn't receive it? <button id="resend-btn" onclick="resend()">Resend email</button>
        <span id="countdown-wrap" style="display:none"> in <span id="countdown">30</span>s</span>
      </div>

      <button class="btn-primary" style="margin-bottom:12px" onclick="window.location.href='#'">
        Open email app
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </button>

      <a href="#" class="btn-ghost">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to log in
      </a>
    </div>

  </div>
</div>

<script>
  let timer = null;

  function sendReset() {
    const emailInput = document.getElementById('email');
    const val = emailInput.value.trim();

    if (!val || !val.includes('@')) {
      emailInput.style.borderColor = '#e05a5a';
      emailInput.style.boxShadow = '0 0 0 3px rgba(224,90,90,0.18)';
      emailInput.focus();
      setTimeout(() => {
        emailInput.style.borderColor = '';
        emailInput.style.boxShadow = '';
      }, 2000);
      return;
    }

    document.getElementById('sent-email').textContent = val;

    const req = document.getElementById('step-request');
    const suc = document.getElementById('step-success');

    req.style.opacity = '0';
    setTimeout(() => {
      req.style.display = 'none';
      suc.style.display = 'block';
      requestAnimationFrame(() => { suc.style.opacity = '1'; });
    }, 280);

    startCountdown();
  }

  function startCountdown() {
    const btn = document.getElementById('resend-btn');
    const wrap = document.getElementById('countdown-wrap');
    const countEl = document.getElementById('countdown');
    let secs = 30;

    btn.disabled = true;
    btn.style.opacity = '0.45';
    btn.style.cursor = 'default';
    wrap.style.display = 'inline';
    countEl.textContent = secs;

    timer = setInterval(() => {
      secs--;
      countEl.textContent = secs;
      if (secs <= 0) {
        clearInterval(timer);
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';
        wrap.style.display = 'none';
      }
    }, 1000);
  }

  function resend() {
    startCountdown();
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