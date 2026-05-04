<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Walker — Blog</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:            #13111a;
      --sidebar-bg:    #1a1825;
      --panel-bg:      #1e1c28;
      --card-bg:       #242233;
      --card-hover:    #2a2840;
      --accent:        #6c63ff;
      --accent-hover:  #7d75ff;
      --accent-glow:   rgba(108,99,255,0.22);
      --accent2:       #ff6b9d;
      --accent3:       #00d4aa;
      --input-bg:      #2e2b3d;
      --input-border:  #3d3952;
      --text-primary:  #f0eef8;
      --text-secondary:#9e9aae;
      --text-muted:    #5e5a72;
      --white:         #ffffff;
      --radius:        14px;
      --radius-sm:     8px;
      --transition:    0.22s ease;
      --shadow:        0 8px 32px rgba(0,0,0,0.4);
    }

    html, body { height: 100%; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text-primary);
      display: flex;
      overflow: hidden;
    }

    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--input-border); border-radius: 2px; }

    /* ════ SIDEBAR ════ */
    .sidebar {
      width: 240px;
      flex-shrink: 0;
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      height: 100vh;
      border-right: 1px solid rgba(255,255,255,0.05);
      padding: 0 0 20px;
      overflow-y: auto;
    }

    .sidebar-logo {
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      font-size: 1.4rem;
      color: var(--white);
      letter-spacing: 0.05em;
      padding: 26px 24px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.05);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .sidebar-logo span { color: var(--accent); }
    .logo-tag {
      font-size: 0.55rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--text-muted);
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      padding: 2px 7px;
      border-radius: 20px;
      margin-top: 2px;
    }

    .profile-card {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 20px 20px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .profile-avatar {
      width: 46px; height: 46px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      display: flex; align-items: center; justify-content: center;
      font-family: 'Sora', sans-serif;
      font-weight: 600;
      font-size: 1rem;
      color: #fff;
      flex-shrink: 0;
      border: 2px solid var(--accent);
      box-shadow: 0 0 0 3px var(--accent-glow);
      position: relative;
      overflow: hidden;
    }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .profile-info { flex: 1; min-width: 0; }
    .profile-name {
      font-family: 'Sora', sans-serif;
      font-weight: 600;
      font-size: 0.85rem;
      color: var(--text-primary);
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .profile-handle { font-size: 0.72rem; color: var(--text-muted); margin-top: 1px; }

    .blog-stats-row {
      display: flex;
      gap: 0;
      padding: 14px 20px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .bstat { flex: 1; text-align: center; }
    .bstat-num {
      font-family: 'Sora', sans-serif;
      font-weight: 600;
      font-size: 0.9rem;
      color: var(--text-primary);
    }
    .bstat-label { font-size: 0.62rem; color: var(--text-muted); margin-top: 1px; }
    .bstat + .bstat { border-left: 1px solid rgba(255,255,255,0.06); }

    .nav-section-label {
      font-size: 0.62rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--text-muted);
      padding: 16px 24px 8px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 20px;
      border-radius: 0 30px 30px 0;
      margin-right: 14px;
      cursor: pointer;
      color: var(--text-secondary);
      font-size: 0.83rem;
      font-weight: 500;
      transition: var(--transition);
      text-decoration: none;
      position: relative;
    }
    .nav-item:hover { background: rgba(108,99,255,0.1); color: var(--text-primary); }
    .nav-item.active {
      background: rgba(108,99,255,0.18);
      color: var(--accent);
    }
    .nav-item.active::before {
      content: '';
      position: absolute;
      left: 0; top: 6px; bottom: 6px;
      width: 3px;
      background: var(--accent);
      border-radius: 0 2px 2px 0;
    }
    .nav-icon { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.9; }
    .nav-badge {
      margin-left: auto;
      background: var(--accent2);
      color: #fff;
      font-size: 0.6rem;
      font-weight: 600;
      padding: 2px 6px;
      border-radius: 10px;
    }

    /* Categories */
    .category-list { padding: 0 12px; display: flex; flex-direction: column; gap: 2px; }
    .category-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 12px;
      border-radius: var(--radius-sm);
      cursor: pointer;
      transition: var(--transition);
    }
    .category-item:hover { background: rgba(255,255,255,0.05); }
    .category-dot {
      width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    }
    .category-name { font-size: 0.78rem; color: var(--text-secondary); flex: 1; }
    .category-count { font-size: 0.65rem; color: var(--text-muted); }

    /* ════ MAIN ════ */
    .main {
      flex: 1;
      height: 100vh;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
    }

    .topbar {
      position: sticky;
      top: 0;
      z-index: 50;
      background: rgba(19,17,26,0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255,255,255,0.06);
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 28px;
    }

    .search-wrap {
      flex: 1;
      position: relative;
      max-width: 380px;
    }
    .search-wrap input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: 30px;
      padding: 9px 16px 9px 38px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.8rem;
      color: var(--text-primary);
      outline: none;
      transition: border-color var(--transition), box-shadow var(--transition);
    }
    .search-wrap input::placeholder { color: var(--text-muted); }
    .search-wrap input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .search-icon {
      position: absolute;
      left: 12px; top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      pointer-events: none;
    }

    .topbar-actions { display: flex; align-items: center; gap: 10px; margin-left: auto; }
    .icon-btn {
      width: 38px; height: 38px;
      border-radius: 50%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      color: var(--text-secondary);
      transition: var(--transition);
      position: relative;
    }
    .icon-btn:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-glow); }
    .notif-dot {
      position: absolute;
      top: 5px; right: 5px;
      width: 7px; height: 7px;
      background: var(--accent2);
      border-radius: 50%;
      border: 2px solid var(--bg);
    }

    .btn-write {
      display: flex; align-items: center; gap: 7px;
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: 30px;
      padding: 9px 18px;
      font-family: 'Sora', sans-serif;
      font-size: 0.78rem;
      font-weight: 500;
      cursor: pointer;
      transition: background var(--transition), box-shadow var(--transition), transform 0.12s;
      white-space: nowrap;
    }
    .btn-write:hover { background: var(--accent-hover); box-shadow: 0 4px 18px var(--accent-glow); }
    .btn-write:active { transform: scale(0.97); }

    /* Feed content */
    .feed-content { padding: 24px 28px; display: flex; flex-direction: column; gap: 24px; }

    /* ── WRITE POST CARD ── */
    .write-card {
      background: var(--card-bg);
      border: 1.5px solid var(--input-border);
      border-radius: var(--radius);
      overflow: hidden;
      transition: border-color var(--transition), box-shadow var(--transition);
      display: none;
      animation: slideIn 0.35s cubic-bezier(.22,1,.36,1) both;
    }
    .write-card.open { display: block; }

    .write-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .write-card-title {
      font-family: 'Sora', sans-serif;
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--text-primary);
    }
    .write-close {
      background: none; border: none; cursor: pointer;
      color: var(--text-muted); transition: color var(--transition);
    }
    .write-close:hover { color: var(--text-primary); }

    .write-body { padding: 20px; display: flex; flex-direction: column; gap: 14px; }

    .write-field label {
      display: block;
      font-size: 0.7rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 6px;
    }

    .write-input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: var(--radius-sm);
      padding: 10px 14px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.85rem;
      color: var(--text-primary);
      outline: none;
      transition: border-color var(--transition), box-shadow var(--transition);
    }
    .write-input::placeholder { color: var(--text-muted); }
    .write-input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .write-title-input {
      font-family: 'Lora', serif;
      font-size: 1.1rem;
      font-weight: 600;
    }

    .write-textarea {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: var(--radius-sm);
      padding: 12px 14px;
      font-family: 'Lora', serif;
      font-size: 0.9rem;
      color: var(--text-primary);
      outline: none;
      resize: none;
      min-height: 140px;
      line-height: 1.7;
      transition: border-color var(--transition), box-shadow var(--transition);
    }
    .write-textarea::placeholder { color: var(--text-muted); font-style: italic; }
    .write-textarea:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .write-row { display: flex; gap: 12px; }
    .write-row .write-field { flex: 1; }

    .write-select {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: var(--radius-sm);
      padding: 10px 14px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.83rem;
      color: var(--text-primary);
      outline: none;
      cursor: pointer;
      appearance: none;
      transition: border-color var(--transition);
    }
    .write-select:focus { border-color: var(--accent); }
    .write-select option { background: var(--card-bg); }

    .cover-upload {
      border: 2px dashed var(--input-border);
      border-radius: var(--radius-sm);
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: border-color var(--transition), background var(--transition);
    }
    .cover-upload:hover, .cover-upload.dragover {
      border-color: var(--accent);
      background: rgba(108,99,255,0.05);
    }
    .cover-upload p { font-size: 0.78rem; color: var(--text-muted); margin-top: 6px; }
    .cover-upload p span { color: var(--accent); font-weight: 500; }
    .cover-preview {
      width: 100%; max-height: 160px;
      object-fit: cover;
      border-radius: var(--radius-sm);
      display: none;
    }

    .write-toolbar {
      display: flex; align-items: center; gap: 4px;
      padding: 8px 12px;
      background: var(--input-bg);
      border-radius: var(--radius-sm);
      border: 1.5px solid var(--input-border);
      flex-wrap: wrap;
    }
    .tb-btn {
      background: none; border: none; cursor: pointer;
      color: var(--text-muted);
      padding: 5px 8px;
      border-radius: 4px;
      font-size: 0.78rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      transition: var(--transition);
      display: flex; align-items: center; gap: 4px;
    }
    .tb-btn:hover { background: rgba(255,255,255,0.08); color: var(--text-primary); }
    .tb-divider { width: 1px; height: 16px; background: var(--input-border); margin: 0 4px; }

    .write-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px;
      border-top: 1px solid rgba(255,255,255,0.06);
    }
    .write-footer-left { display: flex; gap: 10px; align-items: center; }
    .write-status {
      font-size: 0.72rem; color: var(--text-muted);
      display: flex; align-items: center; gap: 6px;
    }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent3); }

    .btn-draft {
      background: none;
      border: 1.5px solid var(--input-border);
      color: var(--text-secondary);
      border-radius: 20px;
      padding: 8px 18px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.78rem;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
    }
    .btn-draft:hover { border-color: var(--accent); color: var(--text-primary); }

    .btn-publish {
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: 20px;
      padding: 8px 22px;
      font-family: 'Sora', sans-serif;
      font-size: 0.78rem;
      font-weight: 500;
      cursor: pointer;
      transition: background var(--transition), box-shadow var(--transition), transform 0.12s;
    }
    .btn-publish:hover { background: var(--accent-hover); box-shadow: 0 4px 14px var(--accent-glow); }
    .btn-publish:active { transform: scale(0.97); }
    .btn-publish:disabled { opacity: 0.5; cursor: not-allowed; }

    /* Feed tabs */
    .feed-tabs-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .section-title {
      font-family: 'Sora', sans-serif;
      font-size: 1rem;
      font-weight: 600;
      color: var(--text-primary);
    }
    .feed-tabs { display: flex; gap: 6px; }
    .tab-btn {
      padding: 7px 18px;
      border-radius: 20px;
      border: 1.5px solid var(--input-border);
      background: transparent;
      color: var(--text-secondary);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.8rem;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
    }
    .tab-btn.active { background: var(--accent); border-color: var(--accent); color: #fff; }
    .tab-btn:hover:not(.active) { border-color: var(--accent); color: var(--text-primary); }

    /* ── BLOG POST CARD ── */
    .post-card {
      background: var(--card-bg);
      border: 1.5px solid var(--input-border);
      margin: 10px;
      border-radius: var(--radius);
      overflow: hidden;
      transition: border-color var(--transition), box-shadow var(--transition);
      animation: slideIn 0.4s cubic-bezier(.22,1,.36,1) both;
    }
    .post-card:hover {
      border-color: rgba(108,99,255,0.3);
      box-shadow: 0 4px 24px rgba(0,0,0,0.3);
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Cover image */
    .post-cover {
      width: 100%; height: 220px;
      object-fit: cover;
      display: block;
      cursor: pointer;
      transition: transform 0.4s ease;
    }
    .post-card:hover .post-cover { transform: scale(1.015); }
    .post-cover-wrap { overflow: hidden; position: relative; }

    /* Category badge on cover */
    .post-category-badge {
      position: absolute;
      bottom: 12px; left: 16px;
      font-size: 0.62rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      padding: 4px 10px;
      border-radius: 20px;
      color: #fff;
    }

    .post-inner { padding: 20px; }

    .post-author-row {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 14px;
    }
    .post-author-avatar {
      width: 34px; height: 34px; border-radius: 50%;
      font-size: 0.72rem; font-weight: 600; color: #fff;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .post-author-info { flex: 1; }
    .post-author-name {
      font-family: 'Sora', sans-serif;
      font-size: 0.8rem; font-weight: 600;
      color: var(--text-primary);
    }
    .post-meta-row { font-size: 0.67rem; color: var(--text-muted); margin-top: 1px; display: flex; gap: 8px; align-items: center; }
    .post-meta-dot { width: 3px; height: 3px; border-radius: 50%; background: var(--text-muted); }

    .post-more {
      background: none; border: none; cursor: pointer;
      color: var(--text-muted); display: flex; align-items: center;
      transition: color var(--transition);
    }
    .post-more:hover { color: var(--text-primary); }

    .post-title {
      font-family: 'Lora', serif;
      font-size: 1.15rem;
      font-weight: 600;
      color: var(--text-primary);
      line-height: 1.4;
      margin-bottom: 10px;
      cursor: pointer;
      transition: color var(--transition);
    }
    .post-title:hover { color: var(--accent); }

    .post-excerpt {
      font-family: 'Lora', serif;
      font-size: 0.85rem;
      color: var(--text-secondary);
      line-height: 1.75;
      margin-bottom: 16px;
    }

    .post-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }
    .post-tag {
      font-size: 0.65rem;
      font-weight: 500;
      color: var(--accent);
      background: rgba(108,99,255,0.12);
      border: 1px solid rgba(108,99,255,0.25);
      padding: 3px 10px;
      border-radius: 20px;
      cursor: pointer;
      transition: var(--transition);
    }
    .post-tag:hover { background: rgba(108,99,255,0.22); }

    .post-footer {
      display: flex;
      align-items: center;
      gap: 4px;
      padding-top: 14px;
      border-top: 1px solid rgba(255,255,255,0.05);
    }

    .read-more-btn {
      margin-left: auto;
      background: none;
      border: 1.5px solid var(--input-border);
      color: var(--text-secondary);
      border-radius: 20px;
      padding: 6px 16px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.75rem;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      display: flex; align-items: center; gap: 5px;
    }
    .read-more-btn:hover { border-color: var(--accent); color: var(--accent); }

    .action-btn {
      display: flex; align-items: center; gap: 5px;
      background: none; border: none;
      cursor: pointer;
      color: var(--text-muted);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.78rem;
      font-weight: 500;
      padding: 7px 12px;
      border-radius: 20px;
      transition: var(--transition);
    }
    .action-btn:hover { background: rgba(255,255,255,0.06); color: var(--text-secondary); }
    .action-btn.liked { color: var(--accent2); }
    .action-btn.liked svg { fill: var(--accent2); }
    .action-btn svg { transition: transform 0.2s, fill 0.2s; }
    .action-btn:hover svg { transform: scale(1.15); }
    .action-btn.like-btn:hover { color: var(--accent2); }
    .action-btn.comment-btn:hover { color: var(--accent); }
    .action-btn.share-btn:hover { color: var(--accent3); }
    .action-count { font-size: 0.75rem; }
    .save-btn { margin-left: 4px; }
    .save-btn:hover { color: #f5a623; }
    .save-btn.saved { color: #f5a623; }
    .save-btn.saved svg { fill: #f5a623; }

    /* Reading time pill */
    .read-time {
      font-size: 0.65rem;
      color: var(--text-muted);
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      padding: 3px 10px;
      border-radius: 20px;
      display: flex; align-items: center; gap: 4px;
    }

    /* Comments */
    .comments-section {
      border-top: 1px solid rgba(255,255,255,0.05);
      display: none;
      animation: fadeSlide 0.3s ease both;
    }
    .comments-section.open { display: block; }

    @keyframes fadeSlide {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .comments-list { padding: 12px 20px; display: flex; flex-direction: column; gap: 12px; }
    .comment-item { display: flex; gap: 10px; }
    .comment-avatar {
      width: 30px; height: 30px; border-radius: 50%;
      font-size: 0.65rem; font-weight: 600; color: #fff;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .comment-bubble {
      background: var(--input-bg);
      border-radius: 0 12px 12px 12px;
      padding: 8px 12px;
      flex: 1;
    }
    .comment-author {
      font-family: 'Sora', sans-serif;
      font-size: 0.72rem; font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 3px;
    }
    .comment-text { font-size: 0.77rem; color: var(--text-secondary); line-height: 1.5; }
    .comment-meta { font-size: 0.65rem; color: var(--text-muted); margin-top: 4px; }
    .comment-like-btn {
      background: none; border: none; cursor: pointer;
      color: var(--text-muted); font-size: 0.65rem;
      margin-left: 8px; transition: color var(--transition);
    }
    .comment-like-btn:hover { color: var(--accent2); }

    .comment-input-row {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 20px 16px;
      border-top: 1px solid rgba(255,255,255,0.04);
    }
    .comment-input-avatar {
      width: 30px; height: 30px; border-radius: 50%;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      display: flex; align-items: center; justify-content: center;
      font-size: 0.65rem; font-weight: 600; color: #fff;
      flex-shrink: 0;
    }
    .comment-input-wrap { flex: 1; position: relative; }
    .comment-input-wrap input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: 20px;
      padding: 8px 40px 8px 14px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.78rem;
      color: var(--text-primary);
      outline: none;
      transition: border-color var(--transition), box-shadow var(--transition);
    }
    .comment-input-wrap input::placeholder { color: var(--text-muted); }
    .comment-input-wrap input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .comment-send {
      position: absolute; right: 6px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: var(--accent); display: flex; align-items: center;
      transition: color var(--transition), transform 0.15s;
    }
    .comment-send:hover { transform: translateY(-50%) scale(1.2); }

    /* ════ RIGHT PANEL ════ */
    .right-panel {
      width: 280px;
      flex-shrink: 0;
      height: 100vh;
      overflow-y: auto;
      background: var(--sidebar-bg);
      border-left: 1px solid rgba(255,255,255,0.05);
      padding: 22px 18px;
      display: flex;
      flex-direction: column;
      gap: 22px;
    }

    .rp-section-title {
      font-family: 'Sora', sans-serif;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    /* Trending posts */
    .trending-item {
      display: flex; gap: 10px; margin-bottom: 14px; cursor: pointer;
      transition: var(--transition);
    }
    .trending-item:hover .trending-title { color: var(--accent); }
    .trending-thumb {
      width: 60px; height: 50px; border-radius: var(--radius-sm);
      object-fit: cover; flex-shrink: 0;
      background: var(--card-bg);
    }
    .trending-info { flex: 1; min-width: 0; }
    .trending-title {
      font-family: 'Lora', serif;
      font-size: 0.75rem; font-weight: 600;
      color: var(--text-primary);
      line-height: 1.4;
      transition: color var(--transition);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    .trending-meta { font-size: 0.62rem; color: var(--text-muted); margin-top: 3px; }

    /* Newsletter */
    .newsletter-box {
      background: linear-gradient(135deg, rgba(108,99,255,0.15) 0%, rgba(255,107,157,0.1) 100%);
      border: 1px solid rgba(108,99,255,0.2);
      border-radius: var(--radius);
      padding: 18px;
    }
    .newsletter-title {
      font-family: 'Sora', sans-serif;
      font-size: 0.85rem; font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 6px;
    }
    .newsletter-desc { font-size: 0.72rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 12px; }
    .newsletter-input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: 8px;
      padding: 8px 12px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.78rem;
      color: var(--text-primary);
      outline: none;
      margin-bottom: 8px;
      transition: border-color var(--transition);
    }
    .newsletter-input::placeholder { color: var(--text-muted); }
    .newsletter-input:focus { border-color: var(--accent); }
    .newsletter-btn {
      width: 100%;
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 9px;
      font-family: 'Sora', sans-serif;
      font-size: 0.78rem;
      font-weight: 500;
      cursor: pointer;
      transition: background var(--transition);
    }
    .newsletter-btn:hover { background: var(--accent-hover); }

    /* Popular tags */
    .tags-cloud { display: flex; flex-wrap: wrap; gap: 6px; }
    .tag-pill {
      font-size: 0.68rem;
      font-weight: 500;
      padding: 4px 12px;
      border-radius: 20px;
      cursor: pointer;
      transition: var(--transition);
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      color: var(--text-secondary);
    }
    .tag-pill:hover { background: rgba(108,99,255,0.15); border-color: var(--accent); color: var(--accent); }

    /* Suggested writers */
    .writer-item {
      display: flex; align-items: center; gap: 10px; margin-bottom: 10px;
    }
    .writer-avatar {
      width: 36px; height: 36px; border-radius: 50%;
      font-size: 0.72rem; font-weight: 600; color: #fff;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .writer-info { flex: 1; min-width: 0; }
    .writer-name { font-size: 0.78rem; font-weight: 500; color: var(--text-primary); }
    .writer-sub { font-size: 0.63rem; color: var(--text-muted); }
    .writer-follow {
      background: none;
      border: 1.5px solid var(--accent);
      border-radius: 50%;
      width: 28px; height: 28px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; color: var(--accent);
      transition: var(--transition);
    }
    .writer-follow:hover { background: var(--accent); color: #fff; }
    .writer-follow.following { background: var(--accent); color: #fff; border-color: var(--accent); }

    /* Toast */
    .toast {
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%) translateY(80px);
      background: var(--card-bg);
      border: 1px solid var(--input-border);
      border-radius: 30px;
      padding: 12px 22px;
      font-size: 0.82rem;
      color: var(--text-primary);
      display: flex;
      align-items: center;
      gap: 8px;
      z-index: 999;
      box-shadow: 0 8px 32px rgba(0,0,0,0.5);
      transition: transform 0.35s cubic-bezier(.22,1,.36,1), opacity 0.35s;
      opacity: 0;
    }
    .toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }
    .toast-icon { color: var(--accent3); }
  </style>
</head>
<body>

<!-- ═══════ SIDEBAR ═══════ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    Walk<span>er</span>
    <span class="logo-tag">Blog</span>
  </div>

  <div class="profile-card">
    <div class="profile-avatar">KZ</div>
    <div class="profile-info">
      <div class="profile-name">{{ auth()->user()->name }}</div>
      <div class="profile-handle">@ {{ auth()->user()->name }} · Writer</div>
    </div>
  </div>

  <div class="blog-stats-row">
    <div class="bstat">
      <div class="bstat-num">24</div>
      <div class="bstat-label">Posts</div>
    </div>
    <div class="bstat">
      <div class="bstat-num">14.2K</div>
      <div class="bstat-label">Readers</div>
    </div>
    <div class="bstat">
      <div class="bstat-num">8.9K</div>
      <div class="bstat-label">Claps</div>
    </div>
  </div>

  <div class="nav-section-label">Navigation</div>

  <a href="#" class="nav-item active">
    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    Home Feed
  </a>
  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
    My Posts
    <span class="nav-badge">3 drafts</span>
  </a>
  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
    Reading List
  </a>
  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    Writers I Follow
  </a>
  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
    Stats & Analytics
  </a>
  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
    Settings
  </a>

  <div class="nav-section-label" style="margin-top:12px;">Categories</div>
  <div class="category-list">
    <div class="category-item">
      <div class="category-dot" style="background:#6c63ff;"></div>
      <span class="category-name">Technology</span>
      <span class="category-count">142</span>
    </div>
    <div class="category-item">
      <div class="category-dot" style="background:#00d4aa;"></div>
      <span class="category-name">Design</span>
      <span class="category-count">87</span>
    </div>
    <div class="category-item">
      <div class="category-dot" style="background:#ff6b9d;"></div>
      <span class="category-name">Travel</span>
      <span class="category-count">63</span>
    </div>
    <div class="category-item">
      <div class="category-dot" style="background:#f5a623;"></div>
      <span class="category-name">Culture</span>
      <span class="category-count">49</span>
    </div>
    <div class="category-item">
      <div class="category-dot" style="background:#4facfe;"></div>
      <span class="category-name">Science</span>
      <span class="category-count">34</span>
    </div>
    <div class="category-item">
      <div class="category-dot" style="background:#a18cd1;"></div>
      <span class="category-name">Lifestyle</span>
      <span class="category-count">21</span>
    </div>
  </div>
</aside>

<!-- ═══════ MAIN ═══════ -->
<main class="main">
  <div class="topbar">
    <div class="search-wrap">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" placeholder="Search articles, topics, writers..."/>
    </div>
    <div class="topbar-actions">
      <div class="icon-btn" title="Notifications">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        <div class="notif-dot"></div>
      </div>
      <button class="btn-write" onclick="toggleWriteCard()">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        Write Post
      </button>
    </div>
  </div>

  <div class="feed-content">

    <!-- Write Post Card -->
    <form action="{{route('upload')}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="write-card" id="write-card">
        <div class="write-card-header">
          <span class="write-card-title">New Blog Post</span>
          <button class="write-close" onclick="toggleWriteCard()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          </button>
        </div>
        <div class="write-body">
          <div class="write-field">
            <label>Post Title</label>
            <input type="text" class="write-input write-title-input" id="post-title" name="title"placeholder="Write a compelling title..." oninput="updatePublishBtn()"/>
          </div>
          <div class="write-row">
            <div class="write-field">
              <label>Category</label>
              <select class="write-select" id="post-category" name="category" onchange="updatePublishBtn()">
                <option value="">Select category</option>
                <option>Technology</option>
                <option>Design</option>
                <option>Travel</option>
                <option>Culture</option>
                <option>Science</option>
                <option>Personal</option>
                <option>Lifestyle</option>
                <option>Art</option>
                <option>Education</option>
              </select>
            </div>
            <div class="write-field">
              <label>Tags (comma separated)</label>
              <input type="text" class="write-input" id="post-tags" placeholder="e.g. ux, design, tools"/>
            </div>
          </div>
          <div class="write-field">
            <label>Cover Image</label>
            <div class="cover-upload" id="cover-upload"
                 onclick="document.getElementById('cover-input').click()"
                 ondragover="event.preventDefault();this.classList.add('dragover')"
                 ondragleave="this.classList.remove('dragover')"
                 ondrop="handleCoverDrop(event)">
              <img class="cover-preview" id="cover-preview" alt="cover"/>
              <div id="cover-placeholder">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#5e5a72" stroke-width="1.5" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <p>Drop a cover image or <span>browse</span></p>
              </div>
              <input type="file" name="image" id="cover-input" accept="image/*" style="display:none" onchange="handleCoverFile(this)"/>
            </div>
          </div>
          <div class="write-field">
            <label>Content</label>
            <div class="write-toolbar">
              <button class="tb-btn" onclick="showToast('Bold')"><strong>B</strong></button>
              <button class="tb-btn" onclick="showToast('Italic')"><em>I</em></button>
              <button class="tb-btn" onclick="showToast('Underline')"><u>U</u></button>
              <div class="tb-divider"></div>
              <button class="tb-btn" onclick="showToast('H2 heading')">H2</button>
              <button class="tb-btn" onclick="showToast('H3 heading')">H3</button>
              <div class="tb-divider"></div>
              <button class="tb-btn" onclick="showToast('Blockquote')">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
              </button>
              <button class="tb-btn" onclick="showToast('Code block')">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
              </button>
              <button class="tb-btn" onclick="showToast('Insert image')">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              </button>
              <button class="tb-btn" onclick="showToast('Insert link')">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
              </button>
            </div>
            <textarea class="write-textarea" name="content" id="post-content" placeholder="Tell your story…" oninput="updatePublishBtn()"></textarea>
          </div>
        </div>
        <div class="write-footer">
          <div class="write-footer-left">
            <div class="write-status">
              <div class="status-dot"></div>
              Auto-saved
            </div>
          </div>
          <div style="display:flex;gap:8px;">
            <button class="btn-draft" onclick="showToast('Saved to drafts!')">Save Draft</button>
            <button type="submit" class="btn-publish" id="publish-btn" disabled>Publish</button>
          </div>
        </div>
      </div>
    </form>

    <!-- Feed Tabs -->
    <div class="feed-tabs-row">
      <span class="section-title">Articles</span>
      <div class="feed-tabs">
        <button class="tab-btn active" onclick="switchTab(this)">For You</button>
        <button class="tab-btn" onclick="switchTab(this)">Latest</button>
        <button class="tab-btn" onclick="switchTab(this)">Following</button>
        <button class="tab-btn" onclick="switchTab(this)">Trending</button>
      </div>
    </div>

    <!-- Posts -->
     <div id="posts-container">
      @foreach($posts as $post)
      <div class="post-card" style="animation-delay:{{ $loop->index * 0.05 }}s">

        {{-- Cover image (only show if exists) --}}
        @if($post->image)
        <div class="post-cover-wrap">
          <img class="post-cover" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"/>
          @if($post->category)
          <span class="post-category-badge" style="background:rgba(108,99,255,0.85);">{{ $post->category }}</span>
          @endif
        </div>
        @endif

        <div class="post-inner">
          <div class="post-author-row">
            <div class="post-author-avatar" style="background:linear-gradient(135deg,#43e97b,#38f9d7)">
              {{ strtoupper(substr($post->user->name, 0, 1)) }}
            </div>
            <div class="post-author-info">
              <div class="post-author-name">{{ $post->user->name }}</div>
              <div class="post-meta-row">
                <span>{{ $post->created_at->format('M j, Y') }}</span>
                <div class="post-meta-dot"></div>
                <span>@{{ $post->user->username }}</span>
              </div>
            </div>

            {{-- Reading time estimate --}}
            @php $readMins = max(1, ceil(str_word_count($post->content) / 200)); @endphp
            <div class="read-time">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              {{ $readMins }} min read
            </div>

            <button class="post-more">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
            </button>
          </div>

          {{-- Title --}}
          <div class="post-title">{{ $post->title }}</div>

          {{-- Excerpt: trim long content to ~300 chars at a word boundary --}}
          <p class="post-excerpt">
            {{ Str::words($post->content, 50, '…') }}
          </p>

          <div class="post-footer">
            <form action="/like" method="post">
              @csrf
              <input type="hidden" name="post_id" value="{{ $post->id }}"/>
              <button type="submit" 
                class="action-btn like-btn {{ $post->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" 
                    fill="{{ $post->likes->contains('user_id', auth()->id()) ? 'currentColor' : 'none' }}" 
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span class="action-count">{{ $post->likes_count ?? 0 }}</span>
              </button>
            </form>
            <button class="action-btn comment-btn" onclick="toggleComments(this)">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              <span class="action-count">{{ $post->comments_count ?? 0 }}</span>
            </button>
            <button class="action-btn share-btn" onclick="showToast('Link copied!')">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
              <span class="action-count">Share</span>
            </button>
            <button class="action-btn save-btn" onclick="toggleSave(this)">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
            </button>
            <a href="#" class="read-more-btn">
              Read More
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
          </div>
        </div>
        
        <div class="comments-section">
  
  {{-- Loop through this post's comments --}}
  <div class="comments-list">
    @foreach($post->comments as $comment)
    <div class="comment-item">
      
      {{-- Comment author avatar with their initial --}}
      <div class="comment-avatar" 
           style="background:linear-gradient(135deg,var(--accent),var(--accent2))">
        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
      </div>
      
      <div>
        <div class="comment-bubble">
          {{-- Who wrote the comment --}}
          <div class="comment-author">{{ $comment->user->name }}</div>
          {{-- The comment text --}}
          <div class="comment-text">{{ $comment->comments }}</div>
        </div>
        {{-- How long ago it was posted --}}
        <div class="comment-meta">
          {{ $comment->created_at->diffForHumans() }}
        </div>
      </div>

    </div>
    @endforeach
  </div>

  {{-- Comment input form --}}
  <div class="comment-input-row">
    <div class="comment-input-avatar">
      {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </div>
    <form action="{{ route('comment') }}" method="post" style="flex:1;">
      @csrf
      <input type="hidden" name="post_id" value="{{ $post->id }}"/>
      <div class="comment-input-wrap">
        <input type="text" name="comments" placeholder="Share your thoughts..."/>
        <button type="submit" class="comment-send">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" 
               stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <line x1="22" y1="2" x2="11" y2="13"/>
            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
          </svg>
        </button>
      </div>
    </form>
  </div>

</div>

      </div>
      @endforeach
    </div>
  </div>
</main>

<!-- ═══════ RIGHT PANEL ═══════ -->
<aside class="right-panel">

  <!-- Trending -->
  <div>
    <div class="rp-section-title">Trending This Week</div>
    <div class="trending-item" onclick="showToast('Opening article...')">
      <img class="trending-thumb" src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=120&h=100&fit=crop" alt="AI"/>
      <div class="trending-info">
        <div class="trending-title">How AI is Quietly Rewriting the Rules of Creative Work</div>
        <div class="trending-meta">Technology · 8 min</div>
      </div>
    </div>
    <div class="trending-item" onclick="showToast('Opening article...')">
      <img class="trending-thumb" src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=120&h=100&fit=crop" alt="Minimalism"/>
      <div class="trending-info">
        <div class="trending-title">The Minimalist Home Office That Changed My Workflow</div>
        <div class="trending-meta">Design · 5 min</div>
      </div>
    </div>
    <div class="trending-item" onclick="showToast('Opening article...')">
      <img class="trending-thumb" src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=120&h=100&fit=crop" alt="Travel"/>
      <div class="trending-info">
        <div class="trending-title">Slow Travel in Eastern Europe: Notes from Six Months on the Road</div>
        <div class="trending-meta">Travel · 12 min</div>
      </div>
    </div>
    <div style="text-align:center;margin-top:6px;">
      <a href="#" style="font-size:0.72rem;color:var(--accent);text-decoration:none;font-weight:500;">See all trending →</a>
    </div>
  </div>

  <!-- Newsletter -->
  <div class="newsletter-box">
    <div class="newsletter-title">Weekly Digest</div>
    <div class="newsletter-desc">Get the best stories delivered to your inbox every Sunday morning.</div>
    <input class="newsletter-input" type="email" placeholder="your@email.com"/>
    <button class="newsletter-btn" onclick="showToast('Subscribed! Welcome aboard.')">Subscribe</button>
  </div>

  <!-- Writers to Follow -->
  <div>
    <div class="rp-section-title">Writers to Follow</div>
    <div class="writer-item">
      <div class="writer-avatar" style="background:linear-gradient(135deg,#a18cd1,#fbc2eb)">BP</div>
      <div class="writer-info">
        <div class="writer-name">Bond Paul</div>
        <div class="writer-sub">Science · 4.2K readers</div>
      </div>
      <button class="writer-follow" onclick="toggleFollow(this)" title="Follow">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </button>
    </div>
    <div class="writer-item">
      <div class="writer-avatar" style="background:linear-gradient(135deg,#43e97b,#38f9d7)">JC</div>
      <div class="writer-info">
        <div class="writer-name">John Carryn</div>
        <div class="writer-sub">Culture · 9.1K readers</div>
      </div>
      <button class="writer-follow" onclick="toggleFollow(this)" title="Follow">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </button>
    </div>
    <div class="writer-item">
      <div class="writer-avatar" style="background:linear-gradient(135deg,#f6d365,#fda085)">QH</div>
      <div class="writer-info">
        <div class="writer-name">Quinn Hane</div>
        <div class="writer-sub">Lifestyle · 2.8K readers</div>
      </div>
      <button class="writer-follow" onclick="toggleFollow(this)" title="Follow">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </button>
    </div>
    <div class="writer-item">
      <div class="writer-avatar" style="background:linear-gradient(135deg,#667eea,#764ba2)">RT</div>
      <div class="writer-info">
        <div class="writer-name">Rachel Taylor</div>
        <div class="writer-sub">Technology · 18K readers</div>
      </div>
      <button class="writer-follow" onclick="toggleFollow(this)" title="Follow">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </button>
    </div>
    <div style="text-align:center;margin-top:4px;">
      <a href="#" style="font-size:0.72rem;color:var(--accent);text-decoration:none;font-weight:500;">Discover more →</a>
    </div>
  </div>

  <!-- Popular Tags -->
  <div>
    <div class="rp-section-title">Popular Tags</div>
    <div class="tags-cloud">
      <span class="tag-pill" onclick="showToast('Filtering by #design')">#design</span>
      <span class="tag-pill" onclick="showToast('Filtering by #technology')">#technology</span>
      <span class="tag-pill" onclick="showToast('Filtering by #travel')">#travel</span>
      <span class="tag-pill" onclick="showToast('Filtering by #ux')">#ux</span>
      <span class="tag-pill" onclick="showToast('Filtering by #writing')">#writing</span>
      <span class="tag-pill" onclick="showToast('Filtering by #photography')">#photography</span>
      <span class="tag-pill" onclick="showToast('Filtering by #culture')">#culture</span>
      <span class="tag-pill" onclick="showToast('Filtering by #productivity')">#productivity</span>
      <span class="tag-pill" onclick="showToast('Filtering by #ai')">#ai</span>
      <span class="tag-pill" onclick="showToast('Filtering by #nature')">#nature</span>
    </div>
  </div>

  <!-- Footer -->
  <div style="font-size:0.65rem;color:var(--text-muted);line-height:2;padding-top:4px;">
    <a href="#" style="color:var(--text-muted);text-decoration:none;margin-right:10px;">About</a>
    <a href="#" style="color:var(--text-muted);text-decoration:none;margin-right:10px;">Guidelines</a>
    <a href="#" style="color:var(--text-muted);text-decoration:none;">Help</a><br>
    <a href="#" style="color:var(--text-muted);text-decoration:none;margin-right:10px;">Privacy</a>
    <a href="#" style="color:var(--text-muted);text-decoration:none;">Terms</a>
  </div>

</aside>

<div class="toast" id="toast">
  <span class="toast-icon">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
  </span>
  <span id="toast-msg">Done</span>
</div>

<script>
  let toastTimer;
  function showToast(msg) {
    const t = document.getElementById('toast');
    document.getElementById('toast-msg').textContent = msg;
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 3000);
  }

  function switchTab(btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }

  function toggleWriteCard() {
    const card = document.getElementById('write-card');
    card.classList.toggle('open');
    if (card.classList.contains('open')) {
      setTimeout(() => document.getElementById('post-title').focus(), 100);
    }
  }

  function updatePublishBtn() {
    const title = document.getElementById('post-title').value.trim();
    const content = document.getElementById('post-content').value.trim();
    document.getElementById('publish-btn').disabled = !title || !content;
  }

  function handleCoverFile(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = (e) => setCoverPreview(e.target.result);
    reader.readAsDataURL(input.files[0]);
  }

  function handleCoverDrop(e) {
    e.preventDefault();
    document.getElementById('cover-upload').classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = (ev) => setCoverPreview(ev.target.result);
    reader.readAsDataURL(file);
  }

  function setCoverPreview(src) {
    const preview = document.getElementById('cover-preview');
    const placeholder = document.getElementById('cover-placeholder');
    preview.src = src;
    preview.style.display = 'block';
    placeholder.style.display = 'none';
  }

  function publishPost() {
    const title = document.getElementById('post-title').value.trim();
    const content = document.getElementById('post-content').value.trim();
    const category = document.getElementById('post-category').value || 'Uncategorized';
    const tags = document.getElementById('post-tags').value.trim();
    const coverSrc = document.getElementById('cover-preview').src;
    const hasCover = document.getElementById('cover-preview').style.display === 'block';

    const container = document.getElementById('posts-container');
    const words = content.split(/\s+/).length;
    const readMins = Math.max(1, Math.ceil(words / 200));
    const tagList = tags ? tags.split(',').map(t => `<span class="post-tag">#${t.trim().replace(/^#/,'')}</span>`).join('') : '';
    const excerpt = content.length > 220 ? content.slice(0, 220) + '…' : content;

    const categoryColors = {
      Technology: 'rgba(108,99,255,0.85)',
      Design: 'rgba(255,107,157,0.85)',
      Travel: 'rgba(0,212,170,0.85)',
      Culture: 'rgba(245,166,35,0.85)',
      Science: 'rgba(79,172,254,0.85)',
      Lifestyle: 'rgba(161,140,209,0.85)',
      Uncategorized: 'rgba(94,90,114,0.85)'
    };
    const badgeColor = categoryColors[category] || categoryColors.Uncategorized;

    const postEl = document.createElement('div');
    postEl.className = 'post-card';
    postEl.innerHTML = `
      ${hasCover ? `
      <div class="post-cover-wrap">
        <img class="post-cover" src="${coverSrc}" alt="cover"/>
        <span class="post-category-badge" style="background:${badgeColor};">${category}</span>
      </div>` : ''}
      <div class="post-inner">
        <div class="post-author-row">
          <div class="post-author-avatar" style="background:linear-gradient(135deg,var(--accent),var(--accent2))">KZ</div>
          <div class="post-author-info">
            <div class="post-author-name">{$post->user->name}</div>
            <div class="post-meta-row">
              <span>Just now</span>
              <div class="post-meta-dot"></div>
              <span>@{$post->user->name}</span>
            </div>
          </div>
          <div class="read-time">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            ${readMins} min read
          </div>
          <button class="post-more">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
          </button>
        </div>
        <div class="post-title" onclick="showToast('Opening article...')">${title.replace(/</g,'&lt;')}</div>
        <p class="post-excerpt">${excerpt.replace(/</g,'&lt;')}</p>
        ${tagList ? `<div class="post-tags">${tagList}</div>` : ''}
        <div class="post-footer">
          <button class="action-btn like-btn" onclick="toggleLike(this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <span class="action-count">0</span>
          </button>
          <button class="action-btn comment-btn" onclick="toggleComments(this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span class="action-count">0</span>
          </button>
          <button class="action-btn share-btn" onclick="showToast('Link copied!')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            <span class="action-count">Share</span>
          </button>
          <button class="action-btn save-btn" onclick="toggleSave(this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
          </button>
          <button class="read-more-btn" onclick="showToast('Opening article...')">
            Read More
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </button>
        </div>
      </div>
      <div class="comments-section">
        <div class="comments-list"></div>
        <div class="comment-input-row">
          <div class="comment-input-avatar">KZ</div>
          <div class="comment-input-wrap">
            <input type="text" placeholder="Share your thoughts..." onkeydown="submitComment(event, this)"/>
            <button class="comment-send" onclick="submitComment({key:'Enter'}, this.parentElement.querySelector('input'))">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </button>
          </div>
        </div>
      </div>
    `;

    container.insertBefore(postEl, container.firstChild);
    postEl.scrollIntoView({ behavior: 'smooth', block: 'start' });

    // Reset
    document.getElementById('post-title').value = '';
    document.getElementById('post-content').value = '';
    document.getElementById('post-tags').value = '';
    document.getElementById('post-category').value = '';
    document.getElementById('cover-preview').style.display = 'none';
    document.getElementById('cover-placeholder').style.display = 'block';
    document.getElementById('publish-btn').disabled = true;
    document.getElementById('write-card').classList.remove('open');
    showToast('Article published!');
  }

  function toggleLike(btn) {
    const isLiked = btn.classList.toggle('liked');
    const svg = btn.querySelector('svg');
    const count = btn.querySelector('.action-count');
    const raw = count.textContent;
    const num = parseFloat(raw.replace('k','')) * (raw.includes('k') ? 1000 : 1);
    const next = isLiked ? num + 1 : num - 1;
    count.textContent = next >= 1000 ? (next/1000).toFixed(1) + 'k' : next;
    if (isLiked) {
      svg.setAttribute('fill', 'currentColor'); svg.setAttribute('stroke', 'none');
      btn.style.transform = 'scale(1.2)';
      setTimeout(() => btn.style.transform = '', 200);
      showToast('Added to your liked posts!');
    } else {
      svg.setAttribute('fill', 'none'); svg.setAttribute('stroke', 'currentColor');
    }
  }

  function toggleSave(btn) {
    const isSaved = btn.classList.toggle('saved');
    const svg = btn.querySelector('svg');
    if (isSaved) { svg.setAttribute('fill','currentColor'); svg.setAttribute('stroke','none'); showToast('Saved to reading list!'); }
    else { svg.setAttribute('fill','none'); svg.setAttribute('stroke','currentColor'); }
  }

  function toggleComments(btn) {
    const card = btn.closest('.post-card');
    const section = card.querySelector('.comments-section');
    section.classList.toggle('open');
    if (section.classList.contains('open')) section.querySelector('input').focus();
  }

  function submitComment(event, input) {
    if (event.key !== 'Enter') return;
    const text = input.value.trim();
    if (!text) return;
    const section = input.closest('.comments-section');
    const list = section.querySelector('.comments-list');
    const item = document.createElement('div');
    item.className = 'comment-item';
    item.style.animation = 'slideIn 0.3s ease both';
    item.innerHTML = `
      <div class="comment-avatar" style="background:linear-gradient(135deg,var(--accent),var(--accent2))">KZ</div>
      <div>
        <div class="comment-bubble">
          <div class="comment-author">{$post->user->name} Zuena</div>
          <div class="comment-text">${text.replace(/</g,'&lt;')}</div>
        </div>
        <div class="comment-meta">Just now · <button class="comment-like-btn" onclick="toggleCommentLike(this)">Like</button></div>
      </div>
    `;
    list.appendChild(item);
    input.value = '';
    const countEl = section.closest('.post-card').querySelector('.comment-btn .action-count');
    const c = parseInt(countEl.textContent.replace(/[k,]/g,'')) * (countEl.textContent.includes('k') ? 1000 : 1);
    const next = c + 1;
    countEl.textContent = next >= 1000 ? (next/1000).toFixed(1) + 'k' : next;
    showToast('Response posted!');
    item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  function toggleCommentLike(btn) {
    const liked = btn.dataset.liked === 'true';
    btn.dataset.liked = !liked;
    btn.textContent = liked ? 'Like' : 'Liked';
    btn.style.color = liked ? '' : 'var(--accent2)';
  }

  function toggleFollow(btn) {
    const isFollowing = btn.classList.toggle('following');
    btn.innerHTML = isFollowing
      ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>'
      : '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
    const name = btn.closest('.writer-item').querySelector('.writer-name').textContent;
    showToast(isFollowing ? `Now following ${name}` : `Unfollowed ${name}`);
  }
</script>
</body>
</html>