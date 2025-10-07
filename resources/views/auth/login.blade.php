<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login • Starlink University</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --left-bg: #c7f3ff;
            --right-grad-a: #6a00ff;
            --right-grad-b: #0aa3ff;
            --card-bg: #ffffff;
            --text: #0f172a;
            --muted: #6b7280;
            --primary: #10b981;
            --primary-hover: #0ea371;
            --ring: rgba(16,185,129,.35);
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: var(--text);
            background: #0b1020;
        }
        .page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
            border: 8px solid #0b1020;
        }
        .left {
            background: var(--left-bg);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .pattern { position: absolute; inset: 0; background-image: radial-gradient(#0b1020 2px, transparent 2px); background-size: 48px 48px; opacity: .35; }
        .logo-big {
            position: relative;
            text-align: center;
        }
        .logo-big svg { width: 220px; height: 220px; filter: drop-shadow(0 8px 16px rgba(0,0,0,.2)); }
        .brand {
            font-weight: 800; font-size: 28px; margin-top: 10px; color: #0b1020;
        }
        .right {
            background: linear-gradient(135deg, var(--right-grad-a), var(--right-grad-b));
            display: flex; align-items: center; justify-content: center;
            padding: 40px 24px;
        }
        .panel { width: 100%; max-width: 1040px; color: #eaf6ff; text-align: center; }
        .panel .logo-row { display:flex; align-items:center; justify-content: center; gap:14px; margin-bottom: 18px; }
        .panel .logo-row svg { width: 80px; height: 80px; }
        .title { font-size: 32px; font-weight: 800; line-height: 1.2; }
        .card { background: rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.28); border-radius:24px; padding:44px; backdrop-filter: blur(12px); box-shadow: 0 22px 54px rgba(0,0,0,.38); }
        .field { margin-top: 16px; position: relative; }
        label.sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0; }
        .input { width: 100%; border: 1.5px solid rgba(255,255,255,.45); border-radius: 999px; padding: 22px 26px; font-size: 20px; outline: none; background: rgba(255,255,255,.98); color: #0b1020; }
        .input:focus { box-shadow: 0 0 0 8px var(--ring); border-color: var(--primary); }
        .password-wrap { position: relative; }
        .toggle-eye { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; border-radius: 12px; border: 0; background: rgba(0,0,0,.08); color: #0b1020; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .toggle-eye:hover { background: rgba(0,0,0,.14); }
        .row { display:flex; align-items:center; justify-content: space-between; gap: 8px; margin-top: 12px; flex-wrap: wrap; }
        .checkbox { display:flex; align-items:center; gap: 8px; color:#eaf6ff; font-size: 14px; }
        .checkbox input { appearance: none; width:16px; height:16px; border:2px solid #6a5acd; border-radius:4px; background:#fff; display:inline-block; position:relative; }
        .checkbox input:checked { background:#6a5acd; }
        .checkbox input:checked:after { content:""; position:absolute; left:3px; top:0px; width:6px; height:10px; border:2px solid #fff; border-top:0; border-left:0; transform: rotate(45deg); }
        .links { display:flex; gap: 18px; font-size: 14px; color:#def; }
        .links a { color:#d8f0ff; text-decoration: none; opacity:.95; }
        .links a:hover { text-decoration: underline; }
        .submit { margin-top: 18px; }
        .btn { width: 100%; padding: 18px 30px; border-radius: 12px; border: 0; background: #1fcf77; color: white; font-weight: 800; font-size: 20px; cursor: pointer; }
        .btn:hover { background: #18b467; }
        .helper-row { display:flex; justify-content: space-between; margin-top: 10px; font-size: 14px; color:#d8e9ff; }
        .helper-row a { color: #d8f0ff; text-decoration: none; }
        @media (max-width: 900px) {
            .page { grid-template-columns: 1fr; }
            .left { display:none; }
            .right { min-height: 100vh; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="left">
            <div class="pattern"></div>
            <div class="logo-big">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 8l10-4 10 4-10 4L2 8z" fill="#5ec7db" stroke="#0b1020" stroke-width="1.2"/>
                    <path d="M6 10.5v3c0 1.657 3.582 3 6 3s6-1.343 6-3v-3" stroke="#0b1020" stroke-width="1.2" fill="#9be2f2"/>
                    <path d="M22 9v6" stroke="#0b1020" stroke-width="1.2"/>
                    <circle cx="22" cy="16" r="1.2" fill="#0b1020"/>
                </svg>
                <div class="brand">Starlink University</div>
            </div>
        </div>
        <div class="right">
            <div class="panel">
                <div class="logo-row">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 8l10-4 10 4-10 4L2 8z" fill="#9be2f2" stroke="#00152e" stroke-width="1.2"/>
                        <path d="M6 10.5v3c0 1.657 3.582 3 6 3s6-1.343 6-3v-3" stroke="#00152e" stroke-width="1.2" fill="#c7f3ff"/>
                        <path d="M22 9v6" stroke="#00152e" stroke-width="1.2"/>
                        <circle cx="22" cy="16" r="1.2" fill="#00152e"/>
                    </svg>
                    <div class="title">Starlink University</div>
                </div>
                <div class="card">
                <form method="POST" action="{{ route('login.perform') }}">
                    @csrf
                    <div class="field">
                        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email" />
                    </div>
                    <div class="field password-wrap">
                        <input class="input" id="password" type="password" name="password" required placeholder="Password" />
                        <button type="button" class="toggle-eye" aria-label="Toggle password" onclick="(function(){ const i=document.getElementById('password'); i.type=i.type==='password'?'text':'password'; })()">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z" stroke="#0b1020" stroke-width="1.6" fill="none"/>
                                <circle cx="12" cy="12" r="3.5" fill="#0b1020"/>
                            </svg>
                        </button>
                    </div>
                    <div class="row">
                        <a href="#">Save Password</a>
                        <a href="{{ route('password.request') }}">Forget Password?</a>
                    </div>
                    <div class="helper-row">
                        <a href="{{ route('admin.login') }}">Sign In As Admin</a>
                        <a href="{{ route('register') }}">New student? Sign Up here</a>
                    </div>
                    <div class="submit">
                        <button class="btn" type="submit">Sign In</button>
                    </div>
                    @if ($errors->any())
                        <div style="margin-top:12px;color:#ffe2e2;background:#7f1d1d33;border:1px solid #fecaca;padding:10px;border-radius:8px;text-align:left;">
                            <strong>Login failed:</strong>
                            <ul style="margin:6px 0 0 18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
