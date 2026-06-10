<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>API Documentation</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --brand: rgb(59, 91, 255);
      --brand-dim: rgba(59, 91, 255, 0.12);
      --brand-glow: rgba(59, 91, 255, 0.35);
      --bg: #09090f;
      --surface: #0f1018;
      --surface-2: #14151f;
      --border: rgba(255,255,255,0.07);
      --border-active: rgba(59, 91, 255, 0.4);
      --text: #e8eaf0;
      --text-muted: #6b6f85;
      --text-dim: #9497ac;
      --green: #2af598;
      --orange: #ff9a3c;
      --red: #ff4f6a;
      --cyan: #00d4ff;
      --yellow: #ffd166;
      --mono: 'JetBrains Mono', monospace;
      --sans: 'Sora', sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--sans);
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Background grid */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(59,91,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59,91,255,0.03) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0; left: 0; bottom: 0;
      width: 260px;
      background: var(--surface);
      border-right: 1px solid var(--border);
      overflow-y: auto;
      z-index: 100;
      display: flex;
      flex-direction: column;
    }

    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-track { background: transparent; }
    .sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

    .sidebar-header {
      padding: 28px 20px 20px;
      border-bottom: 1px solid var(--border);
      position: sticky;
      top: 0;
      background: var(--surface);
      z-index: 1;
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-icon {
      width: 32px; height: 32px;
      background: var(--brand);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-family: var(--mono);
      font-size: 12px;
      font-weight: 600;
      color: white;
      flex-shrink: 0;
    }

    .logo-text {
      font-size: 14px;
      font-weight: 600;
      color: var(--text);
      letter-spacing: -0.01em;
    }

    .logo-version {
      font-size: 10px;
      font-family: var(--mono);
      color: var(--brand);
      background: var(--brand-dim);
      border: 1px solid rgba(59,91,255,0.25);
      padding: 1px 6px;
      border-radius: 4px;
      margin-top: 4px;
    }

    .nav-section {
      padding: 16px 12px 8px;
    }

    .nav-section-label {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--text-muted);
      padding: 0 8px;
      margin-bottom: 4px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 7px 10px;
      border-radius: 6px;
      font-size: 13px;
      color: var(--text-dim);
      text-decoration: none;
      transition: all 0.15s ease;
      cursor: pointer;
    }

    .nav-item:hover {
      background: var(--brand-dim);
      color: var(--text);
    }

    .nav-item.active {
      background: var(--brand-dim);
      color: var(--brand);
      font-weight: 500;
    }

    .nav-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--border);
      flex-shrink: 0;
      transition: background 0.15s;
    }

    .nav-item.active .nav-dot,
    .nav-item:hover .nav-dot {
      background: var(--brand);
    }

    /* Main content */
    .main {
      margin-left: 260px;
      min-height: 100vh;
      position: relative;
      z-index: 1;
    }

    /* Top bar */
    .topbar {
      position: sticky;
      top: 0;
      height: 56px;
      background: rgba(9,9,15,0.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 40px;
      gap: 16px;
      z-index: 50;
    }

    .topbar-title {
      font-size: 13px;
      color: var(--text-muted);
      font-family: var(--mono);
    }

    .topbar-title span {
      color: var(--brand);
    }

    .topbar-spacer { flex: 1; }

    .badge-auth {
      font-size: 11px;
      font-family: var(--mono);
      background: rgba(255,209,102,0.12);
      color: var(--yellow);
      border: 1px solid rgba(255,209,102,0.25);
      padding: 3px 10px;
      border-radius: 4px;
    }

    /* Content */
    .content {
      padding: 48px 40px 80px;
      max-width: 860px;
    }

    /* Hero */
    .hero {
      margin-bottom: 56px;
      padding-bottom: 48px;
      border-bottom: 1px solid var(--border);
    }

    .hero-tag {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-family: var(--mono);
      font-size: 11px;
      color: var(--brand);
      background: var(--brand-dim);
      border: 1px solid rgba(59,91,255,0.3);
      padding: 4px 12px;
      border-radius: 20px;
      margin-bottom: 20px;
    }

    .hero-tag::before {
      content: '';
      width: 6px; height: 6px;
      background: var(--brand);
      border-radius: 50%;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }

    .hero h1 {
      font-size: 40px;
      font-weight: 700;
      letter-spacing: -0.03em;
      line-height: 1.1;
      margin-bottom: 14px;
    }

    .hero h1 em {
      font-style: normal;
      color: var(--brand);
    }

    .hero p {
      font-size: 15px;
      color: var(--text-dim);
      max-width: 520px;
      line-height: 1.7;
    }

    /* Section */
    .section {
      margin-bottom: 64px;
      animation: fadeUp 0.4s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
    }

    .section-icon {
      width: 36px; height: 36px;
      background: var(--brand-dim);
      border: 1px solid rgba(59,91,255,0.25);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .section-title {
      font-size: 20px;
      font-weight: 600;
      letter-spacing: -0.02em;
    }

    .section-id {
      font-family: var(--mono);
      font-size: 11px;
      color: var(--text-muted);
    }

    /* Endpoint badge */
    .endpoint-card {
      background: var(--surface-2);
      border: 1px solid var(--border);
      border-radius: 10px;
      margin-bottom: 24px;
      overflow: hidden;
      transition: border-color 0.2s;
    }

    .endpoint-card:hover {
      border-color: var(--border-active);
    }

    .endpoint-bar {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 18px;
      border-bottom: 1px solid var(--border);
      background: rgba(0,0,0,0.2);
    }

    .method {
      font-family: var(--mono);
      font-size: 11px;
      font-weight: 600;
      padding: 3px 9px;
      border-radius: 4px;
      letter-spacing: 0.05em;
    }

    .method-post { background: rgba(42,245,152,0.12); color: var(--green); border: 1px solid rgba(42,245,152,0.25); }
    .method-get { background: rgba(0,212,255,0.12); color: var(--cyan); border: 1px solid rgba(0,212,255,0.25); }
    .method-put { background: rgba(255,154,60,0.12); color: var(--orange); border: 1px solid rgba(255,154,60,0.25); }
    .method-delete { background: rgba(255,79,106,0.12); color: var(--red); border: 1px solid rgba(255,79,106,0.25); }

    .endpoint-path {
      font-family: var(--mono);
      font-size: 13px;
      color: var(--text);
      flex: 1;
    }

    .endpoint-desc {
      font-size: 12px;
      color: var(--text-muted);
    }

    .endpoint-body {
      padding: 18px;
    }

    /* Table */
    .table-wrap {
      overflow-x: auto;
      border-radius: 8px;
      border: 1px solid var(--border);
      margin-bottom: 16px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    thead tr {
      background: rgba(59,91,255,0.06);
    }

    th {
      text-align: left;
      padding: 10px 16px;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--text-muted);
      border-bottom: 1px solid var(--border);
      white-space: nowrap;
    }

    td {
      padding: 10px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.04);
      color: var(--text-dim);
      vertical-align: top;
    }

    tr:last-child td { border-bottom: none; }
    tr:hover td { background: rgba(255,255,255,0.015); }

    td:first-child {
      font-family: var(--mono);
      font-size: 12px;
      color: var(--cyan);
    }

    .type-badge {
      font-family: var(--mono);
      font-size: 11px;
      background: rgba(255,255,255,0.06);
      padding: 2px 7px;
      border-radius: 3px;
      color: var(--text-dim);
    }

    .req-yes {
      font-size: 11px;
      font-weight: 600;
      color: var(--green);
      font-family: var(--mono);
    }

    .req-no {
      font-size: 11px;
      color: var(--text-muted);
      font-family: var(--mono);
    }

    .val-tag {
      font-family: var(--mono);
      font-size: 11px;
      color: var(--yellow);
    }

    /* Code block */
    .code-block {
      background: rgba(0,0,0,0.4);
      border: 1px solid var(--border);
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 16px;
    }

    .code-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 14px;
      border-bottom: 1px solid var(--border);
      background: rgba(255,255,255,0.02);
    }

    .code-lang {
      font-family: var(--mono);
      font-size: 11px;
      color: var(--text-muted);
      letter-spacing: 0.05em;
    }

    .copy-btn {
      font-family: var(--mono);
      font-size: 10px;
      color: var(--text-muted);
      background: none;
      border: 1px solid var(--border);
      padding: 3px 8px;
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.15s;
    }

    .copy-btn:hover {
      color: var(--brand);
      border-color: var(--brand-glow);
    }

    .copy-btn.copied {
      color: var(--green);
      border-color: rgba(42,245,152,0.3);
    }

    pre {
      padding: 16px;
      overflow-x: auto;
      font-family: var(--mono);
      font-size: 12.5px;
      line-height: 1.7;
      color: var(--text-dim);
    }

    pre::-webkit-scrollbar { height: 4px; }
    pre::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

    .json-key { color: #79b8ff; }
    .json-str { color: #9ecbff; }
    .json-num { color: #b392f0; }
    .json-bool { color: var(--orange); }
    .json-null { color: var(--text-muted); }

    /* Auth box */
    .auth-box {
      background: linear-gradient(135deg, rgba(59,91,255,0.08) 0%, rgba(59,91,255,0.03) 100%);
      border: 1px solid rgba(59,91,255,0.25);
      border-radius: 10px;
      padding: 20px 24px;
      margin-bottom: 24px;
    }

    .auth-box h3 {
      font-size: 14px;
      font-weight: 600;
      color: var(--brand);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .auth-box p {
      font-size: 13px;
      color: var(--text-dim);
      margin-bottom: 12px;
    }

    /* Divider */
    .divider {
      height: 1px;
      background: var(--border);
      margin: 48px 0;
    }

    /* Pill tag */
    .pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11px;
      font-family: var(--mono);
      background: var(--brand-dim);
      color: var(--brand);
      border: 1px solid rgba(59,91,255,0.25);
      padding: 2px 8px;
      border-radius: 20px;
    }

    .pill-green {
      background: rgba(42,245,152,0.08);
      color: var(--green);
      border-color: rgba(42,245,152,0.2);
    }

    .pill-yellow {
      background: rgba(255,209,102,0.08);
      color: var(--yellow);
      border-color: rgba(255,209,102,0.2);
    }

    .pill-red {
      background: rgba(255,79,106,0.08);
      color: var(--red);
      border-color: rgba(255,79,106,0.2);
    }

    /* Routes table special */
    .routes-section .method-cell {
      white-space: nowrap;
    }

    /* Subsection */
    .sub-label {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin: 16px 0 8px;
      padding-left: 2px;
    }

    
    .resource-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    @media (max-width: 720px) {
      .resource-grid { grid-template-columns: 1fr; }
    }

    /* Scrollbar main */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 3px; }

    /* Anchor offset */
    [id] { scroll-margin-top: 72px; }

    /* Mobile */
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .main { margin-left: 0; }
      .content { padding: 24px 20px 60px; }
      .hero h1 { font-size: 28px; }
      .topbar { padding: 0 20px; }
    }
  </style>
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-logo">
      <div class="logo-icon">API</div>
      <div>
        <div class="logo-text">API Docs</div>
        <div class="logo-version">v1.3</div>
      </div>
    </div>
  </div>

  <nav>
    <div class="nav-section">
      <div class="nav-section-label">Pendahuluan</div>
      <a class="nav-item active" href="#overview"><div class="nav-dot"></div>Overview</a>
      <a class="nav-item" href="#authentication"><div class="nav-dot"></div>Authentication</a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Auth System</div>
      <a class="nav-item" href="#user-auth"><div class="nav-dot"></div>User Auth</a>
      <a class="nav-item" href="#mitra-auth"><div class="nav-dot"></div>Mitra Auth</a>
      <a class="nav-item" href="#admin-auth"><div class="nav-dot"></div>Admin Auth</a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Master Data</div>
      <a class="nav-item" href="#package-category"><div class="nav-dot"></div>Package Category</a>
      <a class="nav-item" href="#job-category"><div class="nav-dot"></div>Job Category</a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Task & Transaction</div>
      <a class="nav-item" href="#task-request"><div class="nav-dot"></div>Task Request</a>
      <a class="nav-item" href="#task-proof"><div class="nav-dot"></div>Proof of Work</a>
      <a class="nav-item" href="#task-rating"><div class="nav-dot"></div>Task Rating</a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Location</div>
      <a class="nav-item" href="#update-location"><div class="nav-dot"></div>Update Location</a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Verifikasi</div>
      <a class="nav-item" href="#mitra-verification"><div class="nav-dot"></div>Mitra Verification</a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Analytics</div>
      <a class="nav-item" href="#omzet"><div class="nav-dot"></div>Omzet &amp; Laba</a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Resources</div>
      <a class="nav-item" href="#resources"><div class="nav-dot"></div>API Resources</a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Routes List</div>
      <a class="nav-item" href="#public-routes"><div class="nav-dot"></div>Public Routes</a>
      <a class="nav-item" href="#user-routes"><div class="nav-dot"></div>User Routes</a>
      <a class="nav-item" href="#mitra-routes"><div class="nav-dot"></div>Mitra Routes</a>
      <a class="nav-item" href="#admin-routes"><div class="nav-dot"></div>Admin Routes</a>
    </div>
  </nav>
</aside>

<div class="main">
  <div class="topbar">
    <span class="topbar-title"><span>docs</span> / request-validation</span>
    <div class="topbar-spacer"></div>
    <span class="badge-auth">JWT Bearer</span>
  </div>

  <div class="content">

    <div class="hero" id="overview">
      <div class="hero-tag">REST API</div>
      <h1>API <em>Documentation</em></h1>
      <p>Referensi lengkap endpoint, validasi form request, dan model relasi dari platform. Multi-auth guard diterapkan untuk User, Mitra, dan Admin secara independen.</p>
    </div>

    <div class="section" id="authentication">
      <div class="section-header">
        <div class="section-icon">🔐</div>
        <div>
          <div class="section-title">Authentication Overview</div>
          <div class="section-id">Multi-guard JWT System</div>
        </div>
      </div>
      <div class="auth-box">
        <h3>🔑 Bearer Token</h3>
        <p>Aplikasi ini memiliki 3 aktor dengan token yang berbeda. Pastikan mengirim token ke endpoint sesuai aktor yang dituju.</p>
        <div class="code-block">
          <div class="code-header">
            <span class="code-lang">HTTP HEADER</span>
            <button class="copy-btn" onclick="copyCode(this, 'Authorization: Bearer <token>')">copy</button>
          </div>
          <pre>Authorization: Bearer &lt;token&gt;</pre>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <span class="pill">auth:user</span>
          <span class="pill">auth:mitra</span>
          <span class="pill pill-red">auth:admin</span>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <div class="section" id="user-auth">
      <div class="section-header">
        <div class="section-icon">👤</div>
        <div>
          <div class="section-title">User Authentication</div>
          <div class="section-id">POST /auth/login | POST /auth/user/register</div>
        </div>
      </div>
      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/auth/user/register</span>
          <span class="endpoint-desc">Daftar Akun User</span>
        </div>
        <div class="endpoint-body">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>first_name</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">max:100</span></td></tr>
                <tr><td>last_name</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">max:100</span></td></tr>
                <tr><td>email</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">email, unique:users</span></td></tr>
                <tr><td>phone</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">max:20</span></td></tr>
                <tr><td>password</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">min:8, confirmed</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-put">PUT</span>
          <span class="endpoint-path">/auth/user/update</span>
          <span class="endpoint-desc">Update Profil User (Terdapat field koordinat)</span>
        </div>
        <div class="endpoint-body">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th></tr></thead>
              <tbody>
                <tr><td>first_name</td><td><span class="type-badge">string</span></td><td><span class="req-no">Optional</span></td></tr>
                <tr><td>tanggal_lahir</td><td><span class="type-badge">date</span></td><td><span class="req-no">Optional</span></td></tr>
                <tr><td>latitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-no">Optional</span></td></tr>
                <tr><td>longitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-no">Optional</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="section" id="mitra-auth">
      <div class="section-header">
        <div class="section-icon">🏢</div>
        <div>
          <div class="section-title">Mitra Authentication</div>
          <div class="section-id">POST /auth/mitra/register</div>
        </div>
      </div>
      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/auth/mitra/register</span>
          <span class="endpoint-desc">Register Mitra Baru</span>
        </div>
        <div class="endpoint-body">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>first_name</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">max:100</span></td></tr>
                <tr><td>email</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">email, unique:mitras</span></td></tr>
                <tr><td>password</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">min:8, confirmed</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="section" id="admin-auth">
      <div class="section-header">
        <div class="section-icon">💼</div>
        <div>
          <div class="section-title">Admin Authentication</div>
          <div class="section-id">POST /auth/admin/login | /auth/admin/register</div>
        </div>
      </div>
      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/auth/admin/login</span>
          <span class="endpoint-desc">Login Khusus Admin (Terpisah dari User/Mitra)</span>
        </div>
        <div class="endpoint-body">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th></tr></thead>
              <tbody>
                <tr><td>email</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>password</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="section" id="package-category">
      <div class="section-header">
        <div class="section-icon">📦</div>
        <div>
          <div class="section-title">Package Category Request</div>
          <div class="section-id">Kategori Paket (Dokumen, Barang, dll)</div>
        </div>
      </div>
      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/package-categories</span>
          <span class="endpoint-desc">Tambah / Edit Kategori Paket (Role: Admin)</span>
        </div>
        <div class="endpoint-body">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>name</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">unique:package_categories</span></td></tr>
                <tr><td>additional_price</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">min:0</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="divider"></div>

    <div class="section" id="job-category">
      <div class="section-header">
        <div class="section-icon">🛠️</div>
        <div>
          <div class="section-title">Job Category Request</div>
          <div class="section-id">Kategori Pekerjaan (Khusus, Sedang, Ringan)</div>
        </div>
      </div>
      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/job-categories</span>
          <span class="endpoint-desc">Tambah / Edit Kategori Pekerjaan (Role: Admin)</span>
        </div>
        <div class="endpoint-body">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>name</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">unique:job_categories</span></td></tr>
                <tr><td>additional_price</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">min:0</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="section" id="task-request">
      <div class="section-header">
        <div class="section-icon">🚚</div>
        <div>
          <div class="section-title">Task Request</div>
          <div class="section-id">POST /tasks (Struktur Lengkap Terbaru)</div>
        </div>
      </div>
      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/tasks</span>
          <span class="endpoint-desc">Buat Transaksi Pengiriman</span>
        </div>
        <div class="endpoint-body">
          
          <div class="sub-label">Lokasi & Relasi Master Data</div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th></tr></thead>
              <tbody>
                <tr><td>package_category_id</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>job_category_id</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>pickup_address</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>pickup_latitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>pickup_longitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>destination_address</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>destination_latitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>destination_longitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td></tr>
              </tbody>
            </table>
          </div>

          <div class="sub-label">Detail Penerima & Instruksi</div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th></tr></thead>
              <tbody>
                <tr><td>title</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>instruction_detail</td><td><span class="type-badge">string</span></td><td><span class="req-no">No</span></td></tr>
                <tr><td>receiver_name</td><td><span class="type-badge">string</span></td><td><span class="req-no">No</span></td></tr>
                <tr><td>receiver_phone</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td></tr>
              </tbody>
            </table>
          </div>

          <div class="sub-label">Perhitungan Biaya Terperinci</div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th></tr></thead>
              <tbody>
                <tr><td>base_fee</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>job_category_fee</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>distance_km</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>distance_fee</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>tips_fee</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>discount</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td></tr>
                <tr><td>total_estimated_fee</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td></tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

    <!-- ===== PROOF OF WORK ===== -->
    <div class="section" id="task-proof">
      <div class="section-header">
        <div class="section-icon">📸</div>
        <div>
          <div class="section-title">Proof of Work</div>
          <div class="section-id">Mitra submit bukti — User konfirmasi / tolak</div>
        </div>
      </div>

      <div class="auth-box">
        <h3>📋 Status Flow</h3>
        <p>Setelah mitra mengambil task, alur bukti pekerjaan adalah sebagai berikut:</p>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-top:4px;">
          <span class="pill pill-yellow">ACCEPTED / PICKED_UP</span>
          <span style="color:var(--text-muted);font-size:13px;">→</span>
          <span class="pill pill-yellow">PROOF_SUBMITTED</span>
          <span style="color:var(--text-muted);font-size:13px;">→</span>
          <span class="pill pill-green">COMPLETED</span>
        </div>
        <p style="margin-top:10px;font-size:12px;color:var(--text-muted)">Jika user reject, status kembali ke <code style="color:var(--yellow);font-family:var(--mono)">ACCEPTED</code> dan mitra bisa upload ulang.</p>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/mitra/tasks/{id}/submit-proof</span>
          <span class="endpoint-desc">Mitra Upload Bukti Pekerjaan</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill">auth:mitra</span></div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>proof_of_work</td><td><span class="type-badge">file/image</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">image, mimes:jpg,jpeg,png,webp, max:5MB</span></td></tr>
              </tbody>
            </table>
          </div>
          <p style="font-size:12px;color:var(--text-muted);margin-top:8px;">Hanya mitra yang assign ke task (<code style="color:var(--cyan);font-family:var(--mono)">mitra_id</code> match). Status task harus <code style="color:var(--yellow);font-family:var(--mono)">ACCEPTED</code> atau <code style="color:var(--yellow);font-family:var(--mono)">PICKED_UP</code>. Jika ada bukti lama (resubmit), file lama otomatis dihapus.</p>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/tasks/{id}/confirm</span>
          <span class="endpoint-desc">User Konfirmasi Pekerjaan Selesai</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill">auth:user</span></div>
          <p style="font-size:12px;color:var(--text-muted);">Tidak ada request body. Task harus berstatus <code style="color:var(--yellow);font-family:var(--mono)">PROOF_SUBMITTED</code>. Status akan berubah menjadi <code style="color:var(--green);font-family:var(--mono)">COMPLETED</code>.</p>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/tasks/{id}/reject-proof</span>
          <span class="endpoint-desc">User Tolak Bukti — Mitra Upload Ulang</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill">auth:user</span></div>
          <p style="font-size:12px;color:var(--text-muted);">Tidak ada request body. Task harus berstatus <code style="color:var(--yellow);font-family:var(--mono)">PROOF_SUBMITTED</code>. File bukti lama dihapus, status kembali ke <code style="color:var(--yellow);font-family:var(--mono)">ACCEPTED</code>.</p>
        </div>
      </div>
    </div>

    <!-- ===== TASK RATING ===== -->
    <div class="section" id="task-rating">
      <div class="section-header">
        <div class="section-icon">⭐</div>
        <div>
          <div class="section-title">Task Rating Request</div>
          <div class="section-id">Berlaku untuk User menilai Mitra, atau sebaliknya</div>
        </div>
      </div>
      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">.../rate-mitra (atau) /rate-user</span>
          <span class="endpoint-desc">Simpan Penilaian ke TaskRating</span>
        </div>
        <div class="endpoint-body">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>rating</td><td><span class="type-badge">integer</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">between:1,5</span></td></tr>
                <tr><td>review</td><td><span class="type-badge">string</span></td><td><span class="req-no">No</span></td><td><span class="val-tag">max:1000</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <!-- ===== UPDATE LOCATION ===== -->
    <div class="section" id="update-location">
      <div class="section-header">
        <div class="section-icon">📍</div>
        <div>
          <div class="section-title">Update Location</div>
          <div class="section-id">Tersedia untuk User dan Mitra</div>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-put">PUT</span>
          <span class="endpoint-path">/auth/user/update-location</span>
          <span class="endpoint-desc">Update Koordinat GPS User</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill">auth:user</span></div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>latitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">between:-90,90</span></td></tr>
                <tr><td>longitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">between:-180,180</span></td></tr>
              </tbody>
            </table>
          </div>
          <div class="sub-label">Response</div>
          <div class="code-block">
            <div class="code-header">
              <span class="code-lang">JSON</span>
              <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
            </div>
            <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Lokasi berhasil diperbarui"</span>,
  <span class="json-key">"latitude"</span>: <span class="json-num">-3.3241</span>,
  <span class="json-key">"longitude"</span>: <span class="json-num">114.6204</span>
}</pre>
          </div>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-put">PUT</span>
          <span class="endpoint-path">/auth/mitra/update-location</span>
          <span class="endpoint-desc">Update Koordinat GPS Mitra</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill">auth:mitra</span></div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>latitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">between:-90,90</span></td></tr>
                <tr><td>longitude</td><td><span class="type-badge">numeric</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">between:-180,180</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <!-- ===== MITRA VERIFICATION ===== -->
    <div class="section" id="mitra-verification">
      <div class="section-header">
        <div class="section-icon">🪪</div>
        <div>
          <div class="section-title">Mitra Verification</div>
          <div class="section-id">Upload KTP & SIM — Review oleh Admin</div>
        </div>
      </div>

      <div class="auth-box">
        <h3>📋 Status Verifikasi</h3>
        <p>Setiap mitra hanya memiliki satu data verifikasi. Jika ditolak, mitra bisa submit ulang dan file lama akan otomatis dihapus.</p>
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px;">
          <span class="pill pill-yellow">PENDING</span>
          <span class="pill pill-green">APPROVED</span>
          <span class="pill pill-red">REJECTED</span>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-post">POST</span>
          <span class="endpoint-path">/mitra/verification</span>
          <span class="endpoint-desc">Mitra Submit / Resubmit Dokumen Verifikasi</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill">auth:mitra</span></div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>foto_ktp</td><td><span class="type-badge">file/image</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">image, mimes:jpg,jpeg,png,webp, max:5MB</span></td></tr>
                <tr><td>foto_sim</td><td><span class="type-badge">file/image</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">image, mimes:jpg,jpeg,png,webp, max:5MB</span></td></tr>
              </tbody>
            </table>
          </div>
          <p style="font-size:12px;color:var(--text-muted);margin-top:8px;">Mitra yang sudah berstatus <code style="color:var(--green);font-family:var(--mono)">APPROVED</code> tidak bisa submit ulang. Menggunakan <code style="color:var(--cyan);font-family:var(--mono)">updateOrCreate</code> — satu mitra hanya boleh punya satu record verifikasi.</p>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-get">GET</span>
          <span class="endpoint-path">/mitra/verification/status</span>
          <span class="endpoint-desc">Mitra Cek Status Verifikasi Sendiri</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill">auth:mitra</span></div>
          <div class="sub-label">Response</div>
          <div class="code-block">
            <div class="code-header">
              <span class="code-lang">JSON</span>
              <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
            </div>
            <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"id"</span>: <span class="json-num">1</span>,
    <span class="json-key">"mitra_id"</span>: <span class="json-num">3</span>,
    <span class="json-key">"foto_ktp"</span>: <span class="json-str">"https://domain.com/storage/verifications/ktp/file.jpg"</span>,
    <span class="json-key">"foto_sim"</span>: <span class="json-str">"https://domain.com/storage/verifications/sim/file.jpg"</span>,
    <span class="json-key">"status"</span>: <span class="json-str">"PENDING"</span>,
    <span class="json-key">"rejection_note"</span>: <span class="json-null">null</span>,
    <span class="json-key">"created_at"</span>: <span class="json-str">"2026-06-08T10:00:00Z"</span>
  }
}</pre>
          </div>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-get">GET</span>
          <span class="endpoint-path">/admin/verifications?status=PENDING</span>
          <span class="endpoint-desc">Admin — List Semua Pengajuan Verifikasi</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill pill-red">auth:admin</span></div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Query Param</th><th>Type</th><th>Required</th><th>Nilai</th></tr></thead>
              <tbody>
                <tr><td>status</td><td><span class="type-badge">string</span></td><td><span class="req-no">Optional</span></td><td><span class="val-tag">PENDING | APPROVED | REJECTED</span></td></tr>
              </tbody>
            </table>
          </div>
          <p style="font-size:12px;color:var(--text-muted);">Jika <code style="color:var(--cyan);font-family:var(--mono)">?status</code> tidak dikirim, semua pengajuan dari semua status akan ditampilkan.</p>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-get">GET</span>
          <span class="endpoint-path">/admin/verifications/{id}</span>
          <span class="endpoint-desc">Admin — Detail Satu Pengajuan</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill pill-red">auth:admin</span></div>
          <p style="font-size:12px;color:var(--text-muted);">Mengembalikan detail verifikasi beserta relasi data mitra.</p>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-put">PUT</span>
          <span class="endpoint-path">/admin/verifications/{id}/status</span>
          <span class="endpoint-desc">Admin — Approve atau Reject Verifikasi</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill pill-red">auth:admin</span></div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Field</th><th>Type</th><th>Required</th><th>Validation</th></tr></thead>
              <tbody>
                <tr><td>status</td><td><span class="type-badge">string</span></td><td><span class="req-yes">Yes</span></td><td><span class="val-tag">in:APPROVED,REJECTED</span></td></tr>
                <tr><td>rejection_note</td><td><span class="type-badge">string</span></td><td><span class="req-no">Wajib jika REJECTED</span></td><td><span class="val-tag">required_if:status,REJECTED, max:500</span></td></tr>
              </tbody>
            </table>
          </div>
          <p style="font-size:12px;color:var(--text-muted);margin-top:8px;">Verifikasi yang sudah <code style="color:var(--green);font-family:var(--mono)">APPROVED</code> tidak bisa diubah ulang.</p>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <!-- ===== OMZET & LABA ===== -->
    <div class="section" id="omzet">
      <div class="section-header">
        <div class="section-icon">💰</div>
        <div>
          <div class="section-title">Omzet &amp; Laba Bersih</div>
          <div class="section-id">Kalkulasi revenue dari task COMPLETED — Khusus Admin</div>
        </div>
      </div>

      <div class="auth-box">
        <h3>📊 Formula Perhitungan</h3>
        <p>Semua kalkulasi hanya menggunakan task berstatus <code style="color:var(--green);font-family:var(--mono)">COMPLETED</code>. Task yang dibatalkan atau masih berjalan tidak dihitung.</p>
        <div class="code-block" style="margin-top:12px;">
          <div class="code-header"><span class="code-lang">FORMULA</span></div>
          <pre>Omzet       = SUM(total_estimated_fee) dari task COMPLETED
Laba Bersih = Omzet × 20%</pre>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-get">GET</span>
          <span class="endpoint-path">/admin/omzet</span>
          <span class="endpoint-desc">Total Omzet, Laba Bersih &amp; Breakdown Biaya</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill pill-red">auth:admin</span></div>
          <div class="sub-label">Query Parameters (Opsional)</div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Query Param</th><th>Type</th><th>Required</th><th>Contoh</th></tr></thead>
              <tbody>
                <tr><td>from</td><td><span class="type-badge">date</span></td><td><span class="req-no">Optional</span></td><td><span class="val-tag">2026-01-01</span></td></tr>
                <tr><td>to</td><td><span class="type-badge">date</span></td><td><span class="req-no">Optional</span></td><td><span class="val-tag">2026-06-30</span></td></tr>
              </tbody>
            </table>
          </div>
          <p style="font-size:12px;color:var(--text-muted);margin-top:8px;">Filter berdasarkan <code style="color:var(--cyan);font-family:var(--mono)">updated_at</code> task (saat task berubah ke COMPLETED). Jika tidak dikirim, menghitung semua task COMPLETED tanpa batasan waktu.</p>
          <div class="sub-label">Response</div>
          <div class="code-block">
            <div class="code-header">
              <span class="code-lang">JSON</span>
              <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
            </div>
            <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"total_completed_tasks"</span>: <span class="json-num">142</span>,
    <span class="json-key">"omzet"</span>: <span class="json-num">13490000</span>,
    <span class="json-key">"omzet_formatted"</span>: <span class="json-str">"Rp 13.490.000"</span>,
    <span class="json-key">"laba_bersih"</span>: <span class="json-num">2698000</span>,
    <span class="json-key">"laba_bersih_formatted"</span>: <span class="json-str">"Rp 2.698.000"</span>,
    <span class="json-key">"persentase_laba"</span>: <span class="json-str">"20%"</span>,
    <span class="json-key">"breakdown"</span>: {
      <span class="json-key">"total_base_fee"</span>: <span class="json-num">2840000</span>,
      <span class="json-key">"total_job_category_fee"</span>: <span class="json-num">1420000</span>,
      <span class="json-key">"total_distance_fee"</span>: <span class="json-num">9940000</span>,
      <span class="json-key">"total_tips_fee"</span>: <span class="json-num">710000</span>,
      <span class="json-key">"total_discount"</span>: <span class="json-num">0</span>
    },
    <span class="json-key">"filter"</span>: {
      <span class="json-key">"from"</span>: <span class="json-str">"2026-01-01"</span>,
      <span class="json-key">"to"</span>: <span class="json-str">"2026-06-30"</span>
    }
  }
}</pre>
          </div>
        </div>
      </div>

      <div class="endpoint-card">
        <div class="endpoint-bar">
          <span class="method method-get">GET</span>
          <span class="endpoint-path">/admin/omzet/monthly</span>
          <span class="endpoint-desc">Breakdown Omzet Per Bulan (untuk grafik dashboard)</span>
        </div>
        <div class="endpoint-body">
          <div style="margin-bottom:10px;"><span class="pill pill-red">auth:admin</span></div>
          <div class="sub-label">Query Parameters (Opsional)</div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Query Param</th><th>Type</th><th>Required</th><th>Default</th></tr></thead>
              <tbody>
                <tr><td>year</td><td><span class="type-badge">integer</span></td><td><span class="req-no">Optional</span></td><td><span class="val-tag">Tahun berjalan (now()->year)</span></td></tr>
              </tbody>
            </table>
          </div>
          <div class="sub-label">Response</div>
          <div class="code-block">
            <div class="code-header">
              <span class="code-lang">JSON</span>
              <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
            </div>
            <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"year"</span>: <span class="json-num">2026</span>,
  <span class="json-key">"data"</span>: [
    {
      <span class="json-key">"bulan"</span>: <span class="json-num">1</span>,
      <span class="json-key">"total_tasks"</span>: <span class="json-num">24</span>,
      <span class="json-key">"omzet"</span>: <span class="json-num">2280000</span>,
      <span class="json-key">"laba_bersih"</span>: <span class="json-num">456000</span>
    },
    {
      <span class="json-key">"bulan"</span>: <span class="json-num">2</span>,
      <span class="json-key">"total_tasks"</span>: <span class="json-num">31</span>,
      <span class="json-key">"omzet"</span>: <span class="json-num">2945000</span>,
      <span class="json-key">"laba_bersih"</span>: <span class="json-num">589000</span>
    }
  ]
}</pre>
          </div>
          <p style="font-size:12px;color:var(--text-muted);margin-top:8px;">Bulan yang tidak memiliki task COMPLETED tidak akan muncul di array. Response hanya berisi bulan yang ada datanya.</p>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <div class="section" id="resources">
      <div class="section-header">
        <div class="section-icon">📋</div>
        <div>
          <div class="section-title">API Resources</div>
          <div class="section-id">Response shapes</div>
        </div>
      </div>
      <div class="resource-grid">

        <div>
          <div class="sub-label">User Resource</div>
          <div class="code-block">
            <div class="code-header">
              <span class="code-lang">JSON</span>
              <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
            </div>
            <pre><span class="json-key">{
  "id"</span>: <span class="json-num">1</span>,
  <span class="json-key">"first_name"</span>: <span class="json-str">"John"</span>,
  <span class="json-key">"last_name"</span>: <span class="json-str">"Doe"</span>,
  <span class="json-key">"email"</span>: <span class="json-str">"john@example.com"</span>,
  <span class="json-key">"latitude"</span>: <span class="json-num">-3.324</span>,
  <span class="json-key">"longitude"</span>: <span class="json-num">114.620</span>
  <span class="json-key">"rating"</span>: <span class="json-num">4.2</span>
}</pre>
          </div>
        </div>

        <div>
          <div class="sub-label">Mitra Resource</div>
          <div class="code-block">
            <div class="code-header">
              <span class="code-lang">JSON</span>
              <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
            </div>
            <pre><span class="json-key">{
  "id"</span>: <span class="json-num">1</span>,
  <span class="json-key">"first_name"</span>: <span class="json-str">"Mitra"</span>,
  <span class="json-key">"is_available"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"current_latitude"</span>: <span class="json-num">-3.324</span>,
  <span class="json-key">"current_longitude"</span>: <span class="json-num">114.620</span>
  <span class="json-key">"rating"</span>: <span class="json-num">4.2</span>
}</pre>
          </div>
        </div>

        <div>
          <div class="sub-label">JobCategory Resource</div>
          <div class="code-block">
            <div class="code-header">
              <span class="code-lang">JSON</span>
              <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
            </div>
            <pre><span class="json-key">{
  "id"</span>: <span class="json-num">1</span>,
  <span class="json-key">"name"</span>: <span class="json-str">"Khusus"</span>,
  <span class="json-key">"additional_price"</span>: <span class="json-num">25000</span>
}</pre>
          </div>
        </div>

        <div>
          <div class="sub-label">Admin Resource</div>
          <div class="code-block">
            <div class="code-header">
              <span class="code-lang">JSON</span>
              <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
            </div>
            <pre><span class="json-key">{
  "id"</span>: <span class="json-num">1</span>,
  <span class="json-key">"first_name"</span>: <span class="json-str">"Super"</span>,
  <span class="json-key">"last_name"</span>: <span class="json-str">"Admin"</span>,
  <span class="json-key">"email"</span>: <span class="json-str">"admin@platform.com"</span>
}</pre>
          </div>
        </div>

      </div>

      <div style="margin-top:16px;">
        <div class="sub-label">MitraVerification Resource</div>
        <div class="code-block">
          <div class="code-header">
            <span class="code-lang">JSON</span>
            <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
          </div>
          <pre><span class="json-key">{
  "id"</span>: <span class="json-num">1</span>,
  <span class="json-key">"mitra_id"</span>: <span class="json-num">3</span>,
  <span class="json-key">"mitra"</span>: { <span class="json-key">"id"</span>: <span class="json-num">3</span>, <span class="json-key">"first_name"</span>: <span class="json-str">"Andi"</span> },
  <span class="json-key">"foto_ktp"</span>: <span class="json-str">"https://domain.com/storage/verifications/ktp/file.jpg"</span>,
  <span class="json-key">"foto_sim"</span>: <span class="json-str">"https://domain.com/storage/verifications/sim/file.jpg"</span>,
  <span class="json-key">"status"</span>: <span class="json-str">"REJECTED"</span>,
  <span class="json-key">"rejection_note"</span>: <span class="json-str">"Foto KTP buram, harap upload ulang"</span>,
  <span class="json-key">"created_at"</span>: <span class="json-str">"2026-06-08T10:00:00Z"</span>,
  <span class="json-key">"updated_at"</span>: <span class="json-str">"2026-06-08T11:30:00Z"</span>
}</pre>
        </div>
      </div>

      <div style="margin-top:16px;">
        <div class="sub-label">Omzet Resource</div>
        <div class="code-block">
          <div class="code-header">
            <span class="code-lang">JSON</span>
            <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
          </div>
          <pre><span class="json-key">{
  "total_completed_tasks"</span>: <span class="json-num">142</span>,
  <span class="json-key">"omzet"</span>: <span class="json-num">13490000</span>,
  <span class="json-key">"omzet_formatted"</span>: <span class="json-str">"Rp 13.490.000"</span>,
  <span class="json-key">"laba_bersih"</span>: <span class="json-num">2698000</span>,
  <span class="json-key">"laba_bersih_formatted"</span>: <span class="json-str">"Rp 2.698.000"</span>,
  <span class="json-key">"persentase_laba"</span>: <span class="json-str">"20%"</span>,
  <span class="json-key">"breakdown"</span>: {
    <span class="json-key">"total_base_fee"</span>: <span class="json-num">2840000</span>,
    <span class="json-key">"total_job_category_fee"</span>: <span class="json-num">1420000</span>,
    <span class="json-key">"total_distance_fee"</span>: <span class="json-num">9940000</span>,
    <span class="json-key">"total_tips_fee"</span>: <span class="json-num">710000</span>,
    <span class="json-key">"total_discount"</span>: <span class="json-num">0</span>
  },
  <span class="json-key">"filter"</span>: {
    <span class="json-key">"from"</span>: <span class="json-null">null</span>,
    <span class="json-key">"to"</span>: <span class="json-null">null</span>
  }
}</pre>
        </div>
      </div>

      <div style="margin-top:16px;">
        <div class="sub-label">Task Resource </div>
        <div class="code-block">
          <div class="code-header">
            <span class="code-lang">JSON</span>
            <button class="copy-btn" onclick="copyCodeEl(this)">copy</button>
          </div>
          <pre><span class="json-key">{
  "id"</span>: <span class="json-num">1</span>,
  <span class="json-key">"status"</span>: <span class="json-str">"PENDING"</span>,
  <span class="json-key">"pickup_address"</span>: <span class="json-str">"Landasan Ulin"</span>,
  <span class="json-key">"destination_address"</span>: <span class="json-str">"Siring 0 KM"</span>,
  <span class="json-key">"title"</span>: <span class="json-str">"Kirim Barang"</span>,
  <span class="json-key">"instruction_detail"</span>: <span class="json-str">"Tolong hati-hati barang kaca"</span>,
  <span class="json-key">"receiver_name"</span>: <span class="json-str">"Budi"</span>,
  <span class="json-key">"receiver_phone"</span>: <span class="json-str">"08123456789"</span>,
  <span class="json-key">"package_category_id"</span>: <span class="json-num">1</span>,
  <span class="json-key">"package_category_name"</span>: <span class="json-str">"Dokumen"</span>,
  <span class="json-key">"job_category_id"</span>: <span class="json-num">2</span>,
  <span class="json-key">"job_category_name"</span>: <span class="json-str">"Sedang"</span>,
  <span class="json-key">"base_fee"</span>: <span class="json-num">20000</span>,
  <span class="json-key">"job_category_fee"</span>: <span class="json-num">5000</span>,
  <span class="json-key">"distance_km"</span>: <span class="json-num">14.0</span>,
  <span class="json-key">"distance_fee"</span>: <span class="json-num">70000</span>,
  <span class="json-key">"tips_fee"</span>: <span class="json-num">0</span>,
  <span class="json-key">"discount"</span>: <span class="json-num">0</span>,
  <span class="json-key">"total_estimated_fee"</span>: <span class="json-num">95000</span>,
  <span class="json-key">"proof_of_work"</span>: <span class="json-null">null</span>,
  <span class="json-key">"created_at"</span>: <span class="json-str">"2026-06-06T10:00:00Z"</span>
}</pre>
        </div>
      </div>
    </div>

    <div class="divider"></div>

    <div class="section routes-section" id="public-routes">
      <div class="section-header">
        <div class="section-icon">🌐</div>
        <div>
          <div class="section-title">Public Routes</div>
          <div class="section-id">Tidak memerlukan autentikasi</div>
        </div>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Method</th><th>Endpoint</th><th>Description</th></tr></thead>
          <tbody>
            <tr>
              <td class="method-cell"><span class="method method-post">POST</span></td>
              <td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/login</code></td>
              <td>Login Single User/Mitra</td>
            </tr>
            <tr>
              <td class="method-cell"><span class="method method-post">POST</span></td>
              <td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/admin/login</code></td>
              <td>Login Khusus Admin</td>
            </tr>
            <tr>
              <td class="method-cell"><span class="method method-post">POST</span></td>
              <td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/user/register</code></td>
              <td>Register User</td>
            </tr>
            <tr>
              <td class="method-cell"><span class="method method-post">POST</span></td>
              <td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/mitra/register</code></td>
              <td>Register Mitra</td>
            </tr>
            <tr>
              <td class="method-cell"><span class="method method-post">POST</span></td>
              <td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/admin/register</code></td>
              <td>Register Admin</td>
            </tr>
            <tr>
              <td class="method-cell"><span class="method method-get">GET</span></td>
              <td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/package-categories</code></td>
              <td>List Kategori Paket</td>
            </tr>
            <tr>
              <td class="method-cell"><span class="method method-get">GET</span></td>
              <td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/job-categories</code></td>
              <td>List Kategori Pekerjaan</td>
            </tr>
            <tr>
              <td class="method-cell"><span class="method method-get">GET</span></td>
              <td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks/{id}/rating</code></td>
              <td>Melihat Ulasan/Rating Tugas</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="section routes-section" id="user-routes">
      <div class="section-header">
        <div class="section-icon">🔒</div>
        <div>
          <div class="section-title">User Protected Routes</div>
          <div class="section-id">middleware: auth:user</div>
        </div>
      </div>
      <div style="margin-bottom:12px;">
        <span class="pill">auth:user</span>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Method</th><th>Endpoint</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/user/logout</code></td><td>Logout User</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/user/me</code></td><td>Data user yang login</td></tr>
            <tr><td><span class="method method-put">PUT</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/user/update</code></td><td>Update profil user</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/user/update-avatar</code></td><td>Upload avatar user</td></tr>
            <tr><td><span class="method method-put">PUT</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/user/update-location</code></td><td>Update koordinat GPS user</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks/history</code></td><td>Riwayat tugas user</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks</code></td><td>Buat tugas baru</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks/{id}</code></td><td>Detail tugas</td></tr>
            <tr><td><span class="method method-put">PUT</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks/{id}</code></td><td>Update tugas (status PENDING)</td></tr>
            <tr><td><span class="method method-delete">DELETE</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks/{id}</code></td><td>Hapus tugas (status PENDING)</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks/{id}/confirm</code></td><td>Konfirmasi bukti selesai → COMPLETED</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks/{id}/reject-proof</code></td><td>Tolak bukti → kembali ke ACCEPTED</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/tasks/{id}/rate-mitra</code></td><td>Beri rating ke mitra</td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="section routes-section" id="mitra-routes">
      <div class="section-header">
        <div class="section-icon">🔒</div>
        <div>
          <div class="section-title">Mitra Protected Routes</div>
          <div class="section-id">middleware: auth:mitra</div>
        </div>
      </div>
      <div style="margin-bottom:12px;">
        <span class="pill">auth:mitra</span>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Method</th><th>Endpoint</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/mitra/logout</code></td><td>Logout Mitra</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/mitra/me</code></td><td>Data mitra yang login</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/mitra/update-avatar</code></td><td>Upload avatar mitra</td></tr>
            <tr><td><span class="method method-put">PUT</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/mitra/update-location</code></td><td>Update koordinat GPS mitra</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/mitra/verification</code></td><td>Submit/resubmit dokumen KTP &amp; SIM</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/mitra/verification/status</code></td><td>Cek status verifikasi sendiri</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/mitra/tasks/history</code></td><td>Riwayat tugas yang dikerjakan</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/mitra/tasks</code></td><td>List tugas PENDING/SEARCHING</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/mitra/tasks/{id}</code></td><td>Detail satu tugas</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/mitra/tasks/{id}/accept</code></td><td>Ambil tugas → ACCEPTED</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/mitra/tasks/{id}/submit-proof</code></td><td>Upload bukti pekerjaan → PROOF_SUBMITTED</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/mitra/tasks/{id}/rate-user</code></td><td>Beri rating ke user</td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="section routes-section" id="admin-routes">
      <div class="section-header">
        <div class="section-icon">🔒</div>
        <div>
          <div class="section-title">Admin Protected Routes</div>
          <div class="section-id">middleware: auth:admin</div>
        </div>
      </div>
      <div style="margin-bottom:12px;">
        <span class="pill pill-red">auth:admin</span>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Method</th><th>Endpoint</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/admin/logout</code></td><td>Logout Admin</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/auth/admin/me</code></td><td>Data admin yang login</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/package-categories</code></td><td>Tambah kategori paket</td></tr>
            <tr><td><span class="method method-put">PUT</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/package-categories/{id}</code></td><td>Edit kategori paket</td></tr>
            <tr><td><span class="method method-delete">DELETE</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/package-categories/{id}</code></td><td>Hapus kategori paket</td></tr>
            <tr><td><span class="method method-post">POST</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/job-categories</code></td><td>Tambah kategori pekerjaan</td></tr>
            <tr><td><span class="method method-put">PUT</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/job-categories/{id}</code></td><td>Edit kategori pekerjaan</td></tr>
            <tr><td><span class="method method-delete">DELETE</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/job-categories/{id}</code></td><td>Hapus kategori pekerjaan</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/admin/verifications</code></td><td>List semua pengajuan verifikasi mitra</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/admin/verifications/{id}</code></td><td>Detail satu pengajuan verifikasi</td></tr>
            <tr><td><span class="method method-put">PUT</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/admin/verifications/{id}/status</code></td><td>Approve / Reject verifikasi mitra</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/admin/omzet</code></td><td>Total omzet, laba bersih &amp; breakdown (filter: ?from=&amp;to=)</td></tr>
            <tr><td><span class="method method-get">GET</span></td><td><code style="font-family:var(--mono);font-size:12px;color:var(--text-dim)">/admin/omzet/monthly</code></td><td>Breakdown omzet per bulan (filter: ?year=)</td></tr>
          </tbody>
        </table>
      </div>
    </div>

  </div></div><script>
  // Copy button
  function copyCode(btn, text) {
    navigator.clipboard.writeText(text).then(() => {
      btn.textContent = 'copied!';
      btn.classList.add('copied');
      setTimeout(() => { btn.textContent = 'copy'; btn.classList.remove('copied'); }, 2000);
    });
  }

  function copyCodeEl(btn) {
    const pre = btn.closest('.code-block').querySelector('pre');
    navigator.clipboard.writeText(pre.textContent).then(() => {
      btn.textContent = 'copied!';
      btn.classList.add('copied');
      setTimeout(() => { btn.textContent = 'copy'; btn.classList.remove('copied'); }, 2000);
    });
  }

  // Active nav highlight on scroll
  const sections = document.querySelectorAll('[id]');
  const navLinks = document.querySelectorAll('.nav-item');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        navLinks.forEach(l => l.classList.remove('active'));
        const active = document.querySelector(`.nav-item[href="#${entry.target.id}"]`);
        if (active) active.classList.add('active');
      }
    });
  }, { rootMargin: '-20% 0px -70% 0px' });

  sections.forEach(s => observer.observe(s));
</script>
</body>
</html>