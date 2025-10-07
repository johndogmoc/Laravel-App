<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login • Starlink University</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --left-bg:#c7f3ff; --right-a:#6a00ff; --right-b:#0aa3ff;
      --primary:#10b981; --ring:rgba(16,185,129,.35); --text:#0b1020;
    }
    *{box-sizing:border-box} html,body{height:100%}
    body{margin:0;font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#0b1020;color:#eaf6ff}
    .page{display:grid;grid-template-columns:1fr 1fr;min-height:100vh;border:8px solid #0b1020}
    .left{background:var(--left-bg);position:relative;display:flex;align-items:center;justify-content:center;}
    .dots{position:absolute;inset:0;background-image:radial-gradient(#0b1020 2px,transparent 2px);background-size:48px 48px;opacity:.35}
    .logo{position:relative;text-align:center}
    .logo img{width:260px;height:auto;display:block;margin:0 auto}
    .brand{margin-top:10px;font-weight:800;font-size:28px;color:#0b1020}
    .right{background:linear-gradient(135deg,var(--right-a),var(--right-b));display:flex;align-items:center;justify-content:center;padding:40px 24px}
    .panel{width:100%;max-width:1040px}
    .head{display:flex;align-items:center;gap:14px;margin-bottom:10px}
    .head svg{width:80px;height:80px}
    .title{font-size:32px;font-weight:800}
    .subtitle{margin-top:4px;color:#dcefff}
    .card{margin-top:14px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.28);border-radius:24px;padding:44px;backdrop-filter:blur(12px);box-shadow:0 22px 54px rgba(0,0,0,.38)}
    .field{margin-top:16px}
    .input{width:100%;border:1.5px solid rgba(255,255,255,.45);border-radius:999px;padding:22px 26px;background:rgba(255,255,255,.98);color:var(--text);font-size:20px;outline:none}
    .input:focus{box-shadow:0 0 0 8px var(--ring);border-color:var(--primary)}
    .row{display:flex;align-items:center;justify-content:space-between;margin-top:10px}
    .checkbox{display:flex;align-items:center;gap:8px}
    .btn{margin-top:14px;padding:18px 30px;border-radius:12px;border:0;background:#ef4444;color:#fff;font-weight:800;font-size:20px;cursor:pointer}
    .btn:hover{background:#dc2626}
    a{color:#d8f0ff;text-decoration:none}
    a:hover{text-decoration:underline}
    @media(max-width:900px){.page{grid-template-columns:1fr}.left{display:none}.right{min-height:100vh}}
  </style>
</head>
<body>
  <div class="page">
    <div class="left">
      <div class="dots"></div>
      <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Starlink University" />
        <div class="brand">Starlink University</div>
      </div>
    </div>
    <div class="right">
      <div class="panel">
        <div class="head">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 8l10-4 10 4-10 4L2 8z" fill="#9be2f2" stroke="#00152e" stroke-width="1.2"/>
            <path d="M6 10.5v3c0 1.657 3.582 3 6 3s6-1.343 6-3v-3" stroke="#00152e" stroke-width="1.2" fill="#c7f3ff"/>
            <path d="M22 9v6" stroke="#00152e" stroke-width="1.2"/>
            <circle cx="22" cy="16" r="1.2" fill="#00152e"/>
          </svg>
          <div>
            <div class="title">Starlink University</div>
            <div class="subtitle">Welcome Back, Admin!</div>
          </div>
        </div>
        <div class="card">
          <form method="POST" action="{{ route('admin.login.perform') }}">
            @csrf
            <div class="field">
              <input class="input" type="text" name="email" value="{{ old('email') }}" placeholder="Email or Phone Number" required autofocus />
            </div>
            <div class="field">
              <input class="input" type="password" name="password" placeholder="Password" required />
            </div>
            <div class="row">
              <label class="checkbox"><input type="checkbox" name="remember"> Save Password</label>
              <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
            
            @if ($errors->any())
              <div style="margin-top:10px;color:#ffe2e2;background:#7f1d1d33;border:1px solid #fecaca;padding:10px;border-radius:8px;">
                <strong>Login failed:</strong>
                <ul style="margin:6px 0 0 18px;">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <button class="btn" type="submit">Sign In</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
