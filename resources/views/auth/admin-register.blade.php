<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register as Admin • Starlink University</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --left-bg:#c7f3ff; --right-a:#1f4bd2; --right-b:#2f64ff; --text:#0b1020; --ring:rgba(47,100,255,.28) }
    *{box-sizing:border-box} html,body{height:100%}
    body{margin:0;font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#0b1020;color:#eaf6ff}
    .page{display:grid;grid-template-columns:1fr 1fr;min-height:100vh;border:8px solid #0b1020}
    .left{background:var(--left-bg);position:relative;display:flex;align-items:center;justify-content:center;padding:24px}
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
    .panel{width:100%;max-width:680px}
    .head{display:flex;align-items:center;gap:14px;margin-bottom:10px}
    .head img{width:64px;height:64px}
    .title{font-size:32px;font-weight:800}
    .subtitle{margin-top:4px;color:#dcefff}
    .card{margin-top:14px;background:transparent;border:0;border-radius:0;padding:0;backdrop-filter:none;box-shadow:none}
    .field{margin-top:14px}
    .input{width:100%;border:1.5px solid rgba(255,255,255,.45);border-radius:999px;padding:18px 22px;background:rgba(255,255,255,.98);color:var(--text);font-size:18px;outline:none}
    .input:focus{box-shadow:none;border-color:#2f64ff}
    .btn{margin-top:16px;padding:16px 26px;border-radius:12px;border:0;background:#ef4444;color:#fff;font-weight:800;font-size:18px;cursor:pointer}
    .btn:hover{background:#dc2626}
    a{color:#d8f0ff;text-decoration:none}
    a:hover{text-decoration:underline}
    @media(max-width:900px){.page{grid-template-columns:1fr}.left{display:none}.right{min-height:100vh}}
  </style>
</head>
<body class="shell">
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
          <img src="{{ asset('images/8907269.png') }}" alt="" />
          <div>
            <div class="title">Starlink University</div>
            <div class="subtitle">Register as Admin</div>
            <div class="subtitle" style="font-weight:600;opacity:.9;">Sign Up to your account</div>
          </div>
        </div>
        <div class="card">
          @if ($errors->any())
            <div style="margin-bottom:10px;color:#ffe2e2;background:#7f1d1d33;border:1px solid #fecaca;padding:10px;border-radius:8px;">
              <strong>There were problems:</strong>
              <ul style="margin:6px 0 0 18px;">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('status'))
            <div style="margin-bottom:10px;color:#0f5132;background:#d1e7dd;border:1px solid #badbcc;padding:10px;border-radius:8px;">
              {{ session('status') }}
            </div>
          @endif

          <form method="POST" action="{{ route('admin.register.perform') }}">
            @csrf
            <div class="field">
              <input class="input" type="text" name="name" value="{{ old('name') }}" placeholder="Username" required />
            </div>
            <div class="field">
              <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Email or Phone Number" required />
            </div>
            <div class="field">
              <input class="input" type="password" name="password" placeholder="Password (min 8)" required />
            </div>
            <div class="field">
              <input class="input" type="password" name="password_confirmation" placeholder="Confirm Password" required />
            </div>
            <button class="btn" type="submit">Sign Up</button>
            <div style="margin-top:10px;font-size:14px;color:#dcefff;">
              Already have an account? <a href="{{ route('admin.login') }}">Sign in</a>.
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
