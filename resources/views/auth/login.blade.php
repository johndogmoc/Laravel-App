<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login • Starlink University</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --left-bg:#c7f3ff; --right-a:#0aa3ff; --right-b:#6a00ff;
      --primary:#10b981; --ring:rgba(16,185,129,.35); --text:#0b1020;
    }
    *{box-sizing:border-box} html,body{height:100%}
    body{margin:0;font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#0b1020;color:#eaf6ff}
    .page{display:grid;grid-template-columns:1fr 1fr;min-height:100vh;border:8px solid #0b1020}
    .left{background:var(--left-bg);position:relative;display:flex;align-items:center;justify-content:center;}
    .dots{display:none}
    .logo{position:relative;text-align:center}
    .logo img{width:260px;height:auto;display:block;margin:0 auto}
    .brand{margin-top:10px;font-weight:800;font-size:28px;color:#0b1020}
    .doodles{display:none}
    .doodles img{position:absolute;width:42px;height:42px;object-fit:contain;opacity:.95}
    .d1{top:18px;left:18px}
    .d2{top:18px;right:24px}
    .d3{bottom:22px;left:22px}
    .d4{bottom:22px;right:28px}
    .d5{top:120px;left:48px}
    .d6{top:180px;right:54px}
    .d7{bottom:120px;left:64px}
    .d8{bottom:160px;right:68px}
    .right{background:linear-gradient(135deg,var(--right-a),var(--right-b));display:flex;align-items:center;justify-content:center;padding:40px 24px}
    .panel{width:100%;max-width:1040px}
    .head{display:flex;align-items:center;gap:14px;margin-bottom:10px}
    .head svg{width:80px;height:80px}
    .title{font-size:32px;font-weight:800}
    .subtitle{margin-top:4px;color:#dcefff}
    .card{margin-top:14px;background:transparent;border:0;border-radius:0;padding:0;backdrop-filter:none;box-shadow:none}
    .field{margin-top:16px}
    .input{width:100%;border:1.5px solid rgba(255,255,255,.45);border-radius:999px;padding:22px 26px;background:rgba(255,255,255,.98);color:var(--text);font-size:20px;outline:none}
    .input:focus{box-shadow:none;border-color:var(--primary)}
    .row{display:flex;align-items:center;justify-content:space-between;margin-top:10px}
    .label{font-weight:700;margin-top:12px;display:block;color:#0b1020}
    .muted{color:#dcefff}
    .actions-row{display:flex;align-items:center;justify-content:space-between;margin-top:8px}
    .btn-row{display:flex;justify-content:flex-end;margin-top:10px}
    .btn.btn-small{padding:10px 14px;font-size:16px;border-radius:10px}
    .checkbox{display:flex;align-items:center;gap:8px}
    .btn{margin-top:14px;padding:18px 30px;border-radius:12px;border:0;background:#10b981;color:#fff;font-weight:800;font-size:20px;cursor:pointer}
    .btn:hover{background:#059669}
    a{color:#d8f0ff;text-decoration:none}
    a:hover{text-decoration:underline}
    @media(max-width:900px){.page{grid-template-columns:1fr}.left{display:none}.right{min-height:100vh}}
  </style>
</head>
<body class="shell">
  <header class="topbar">
    <div class="brand">Starlink University</div>
  </header>
  
  <div class="page">
    <div class="left">
      <div class="dots"></div>
      <div class="logo">
        <img src="{{ asset('images/8907269.png') }}" alt="Starlink University" />
        <div class="brand">Starlink University</div>
      </div>
      <div class="doodles">
        <img src="{{ asset('images/3135768.png') }}" class="d1" alt="" />
        <img src="{{ asset('images/4216253.png') }}" class="d2" alt="" />
        <img src="{{ asset('images/4341039.png') }}" class="d3" alt="" />
        <img src="{{ asset('images/4341054.png') }}" class="d4" alt="" />
        <img src="{{ asset('images/4341057.png') }}" class="d5" alt="" />
        <img src="{{ asset('images/4341091.png') }}" class="d6" alt="" />
        <img src="{{ asset('images/4341167.png') }}" class="d7" alt="" />
        <img src="{{ asset('images/4527410.png') }}" class="d8" alt="" />
      </div>
    </div>
    <div class="right">
      <div class="panel">
        <div class="head">
          <img src="{{ asset('images/8907269.png') }}" alt="Starlink" style="width:64px;height:64px;object-fit:contain;" />
          <div>
            <div class="title">Starlink University</div>
            <div class="subtitle" style="color:#000;font-weight:800;font-size:28px;">Welcome Back!</div>
            <div class="subtitle" style="color:#0b1020;opacity:.9;font-weight:600;">Login to your account</div>
          </div>
        </div>
        <div class="card">
          <form method="POST" action="{{ route('login.perform') }}">
            @csrf
            <label class="label">Email Address</label>
            <div class="field" style="margin-top:8px;">
              <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required autofocus />
            </div>
            <label class="label" style="margin-top:12px;">Password</label>
            <div class="field" style="margin-top:8px;">
              <input class="input" type="password" name="password" placeholder="Password" required />
            </div>
            
            @if ($errors->any())
            <div style="margin-top:16px;color:#ef4444;font-weight:600;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
            
            <div class="actions-row">
              <div class="checkbox">
                <input type="checkbox" name="remember" id="remember" />
                <label for="remember">Remember me</label>
              </div>
              <a href="#" class="muted">Forgot password?</a>
            </div>
            
            <button type="submit" class="btn">Login</button>
            
            <div style="margin-top:16px;text-align:center;">
              <span class="muted">Don't have an account?</span>
              <a href="{{ url('/register') }}">Register</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>