<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register • Starlink University</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --left-bg: #c7f3ff;
            --right-grad-a: #6a00ff;
            --right-grad-b: #0aa3ff;
            --card-bg: rgba(255,255,255,.15);
            --text: #0f172a;
            --muted: #6b7280;
            --primary: #10b981;
            --primary-hover: #0ea371;
            --ring: rgba(16,185,129,.35);
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body { margin:0; font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; background: #0b1020; color:#eaf6ff; }
        .page { display:grid; grid-template-columns: 1fr 1fr; min-height: 100vh; border: 8px solid #0b1020; }
        .left { background: var(--left-bg); position:relative; display:flex; align-items:center; justify-content:center; overflow:hidden; }
        .pattern { position:absolute; inset:0; background-image: radial-gradient(#0b1020 2px, transparent 2px); background-size:48px 48px; opacity:.35; }
        .logo-big { position:relative; text-align:center; }
        .logo-big img { width: 260px; height:auto; display:block; margin:0 auto; }
        .brand { margin-top:10px; font-weight:800; font-size:28px; color:#0b1020; }
        .right { background: linear-gradient(135deg, var(--right-grad-a), var(--right-grad-b)); display:flex; align-items:center; justify-content:center; padding:40px 24px; }
        .panel { width:100%; max-width: 1040px; color:#eaf6ff; }
        .top-row { display:flex; align-items:center; justify-content: space-between; margin-bottom:14px; }
        .back { color:#d8f0ff; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:600; }
        .header { display:flex; align-items:center; gap:14px; }
        .header svg { width:80px; height:80px; }
        .title { font-size:32px; font-weight:800; }
        .card { background: var(--card-bg); border:1px solid rgba(255,255,255,.28); border-radius:24px; padding:44px; backdrop-filter: blur(12px); box-shadow: 0 22px 54px rgba(0,0,0,.38); }
        .grid { display:grid; grid-template-columns: 1fr 1fr; gap:24px; }
        .full { grid-column: 1 / -1; }
        .field { position:relative; }
        .input, select { width:100%; border:1.5px solid rgba(255,255,255,.45); border-radius:999px; padding:22px 26px; font-size:20px; outline:none; background: rgba(255,255,255,.98); color:#0b1020; }
        .input:focus, select:focus { box-shadow:0 0 0 8px var(--ring); border-color: var(--primary); }
        .row { display:flex; align-items:center; gap:22px; }
        .row.full { margin-top:10px; }
        .btn { margin-top:22px; padding:18px 30px; border-radius:14px; border:0; background:#1fcf77; color:white; font-weight:800; font-size:20px; cursor:pointer; }
        .btn:hover { background:#18b467; }
        .panel, .card, .input, select, .btn { transition: all .15s ease; }
        @media (max-width: 900px) { .page{ grid-template-columns: 1fr; } .left{ display:none; } .right{ min-height:100vh; } .grid{ grid-template-columns:1fr; } }
    </style>
</head>
<body>
<div class="page">
    <div class="left">
        <div class="pattern"></div>
        <div class="logo-big">
            <img src="{{ asset('images/logo.png') }}" alt="Starlink University" />
            <div class="brand">Starlink University</div>
        </div>
    </div>
    <div class="right">
        <div class="panel">
            <div class="top-row">
                <a class="back" href="{{ route('login') }}">&lt; Back</a>
                <div class="header">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 8l10-4 10 4-10 4L2 8z" fill="#9be2f2" stroke="#00152e" stroke-width="1.2"/>
                        <path d="M6 10.5v3c0 1.657 3.582 3 6 3s6-1.343 6-3v-3" stroke="#00152e" stroke-width="1.2" fill="#c7f3ff"/>
                        <path d="M22 9v6" stroke="#00152e" stroke-width="1.2"/>
                        <circle cx="22" cy="16" r="1.2" fill="#00152e"/>
                    </svg>
                </div>
            </div>
            <div class="card">
                <form method="POST" action="{{ route('register.perform') }}">
                    @csrf
                    <div class="grid">
                        <div class="field"><input class="input" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Firstname" required></div>
                        <div class="field"><input class="input" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Lastname" required></div>
                        <div class="field"><input class="input" type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middlename"></div>
                        <div class="field">
                            <select name="sex" class="input">
                                <option value="">Sex</option>
                                <option value="Male" @selected(old('sex')==='Male')>Male</option>
                                <option value="Female" @selected(old('sex')==='Female')>Female</option>
                            </select>
                        </div>
                        <div class="field full"><input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required></div>
                        <div class="field full"><input class="input" type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number"></div>
                        <div class="field"><input class="input" type="password" name="password" placeholder="Password" required></div>
                        <div class="field"><input class="input" type="password" name="password_confirmation" placeholder="Confirm Password" required></div>
                        <div class="row full">
                            <select name="dob_month" class="input" style="max-width:160px;">
                                @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $i=>$m)
                                    <option value="{{ $i+1 }}" @selected(old('dob_month')===$i+1)>{{ $m }}</option>
                                @endforeach
                            </select>
                            <select name="dob_day" class="input" style="max-width:120px;">
                                @for($d=1;$d<=31;$d++)
                                    <option value="{{ $d }}" @selected(old('dob_day')==$d)>{{ $d }}</option>
                                @endfor
                            </select>
                            <select name="dob_year" class="input" style="max-width:140px;">
                                @for($y=date('Y');$y>=date('Y')-80;$y--)
                                    <option value="{{ $y }}" @selected(old('dob_year')==$y)>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="row full" style="color:#eaf6ff;">
                            <label style="display:flex;align-items:center;gap:6px;">
                                <input type="radio" name="gender" value="Male" @checked(old('gender')==='Male')> Male
                            </label>
                            <label style="display:flex;align-items:center;gap:6px;">
                                <input type="radio" name="gender" value="Female" @checked(old('gender')==='Female')> Female
                            </label>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div style="margin-top:12px;color:#ffe2e2;background:#7f1d1d33;border:1px solid #fecaca;padding:10px;border-radius:8px;">
                            <strong>There were errors:</strong>
                            <ul style="margin:6px 0 0 18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button class="btn" type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
