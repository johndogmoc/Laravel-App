<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password • Starlink University</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --left-bg: #c7f3ff;
            --right-grad-a: #6a00ff;
            --right-grad-b: #0aa3ff;
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --ring: rgba(59,130,246,.35);
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body { margin: 0; font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; background: #0b1020; color: #eaf6ff; }
        .page { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; border: 8px solid #0b1020; }
        .left { background: var(--left-bg); position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .pattern {
            position: absolute; inset: 0;
            background-image:
              url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='140' height='140' viewBox='0 0 140 140'><g fill='none' stroke='%230b1020' stroke-width='1.6'><circle cx='30' cy='30' r='12'/><path d='M30 18v-6m0 30v-6m12-12h6m-30 0h-6'/><circle cx='110' cy='30' r='12'/><path d='M110 18v-6m0 30v-6m12-12h6m-30 0h-6'/><circle cx='30' cy='110' r='12'/><path d='M30 98v-6m0 30v-6m12-12h6m-30 0h-6'/><circle cx='110' cy='110' r='12'/><path d='M110 98v-6m0 30v-6m12-12h6m-30 0h-6'/></g></svg>"),
              radial-gradient(#0b1020 2px, transparent 2px);
            background-size: 240px 240px, 48px 48px;
            background-position: center, center;
            background-repeat: repeat;
            opacity: .32;
        }
        .card-left {
            position: relative;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 24px;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 12px 36px rgba(0,0,0,.18);
            max-width: 320px;
        }
        .card-left svg { width: 80px; height: 80px; margin: 0 auto 20px; }
        .dots { display: flex; flex-direction: column; gap: 14px; margin-top: 20px; }
        .dot-row {
            background: rgba(255,255,255,.85);
            border-radius: 8px;
            padding: 14px 20px;
            color: #0b1020;
            font-weight: 700;
            letter-spacing: 4px;
        }
        .right { background: linear-gradient(135deg, var(--right-grad-a), var(--right-grad-b)); display: flex; align-items: center; justify-content: center; padding: 40px 24px; }
        .panel { width: 100%; max-width: 480px; color: #eaf6ff; text-align: center; }
        .title { font-size: 36px; font-weight: 800; line-height: 1.2; margin-bottom: 24px; }
        .field { margin-top: 18px; }
        .input {
            width: 100%;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 10px;
            padding: 16px 18px;
            font-size: 16px;
            outline: none;
            background: rgba(255,255,255,.96);
            color: #0b1020;
        }
        .input:focus { box-shadow: 0 0 0 5px var(--ring); border-color: var(--primary); }
        .btn {
            width: 100%;
            margin-top: 18px;
            padding: 14px 20px;
            border-radius: 10px;
            border: 0;
            background: var(--primary);
            color: white;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover { background: var(--primary-hover); }
        .back-link { margin-top: 16px; font-size: 14px; }
        .back-link a { color: #d8f0ff; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
        @media (max-width: 900px) { .page { grid-template-columns: 1fr; } .left { display: none; } .right { min-height: 100vh; } }
    </style>
</head>
<body>
    <div class="page">
        <div class="left">
            <div class="pattern"></div>
            <div class="card-left">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 8l10-4 10 4-10 4L2 8z" fill="#5ec7db" stroke="#0b1020" stroke-width="1.2"/>
                    <path d="M6 10.5v3c0 1.657 3.582 3 6 3s6-1.343 6-3v-3" stroke="#0b1020" stroke-width="1.2" fill="#9be2f2"/>
                    <path d="M22 9v6" stroke="#0b1020" stroke-width="1.2"/>
                    <circle cx="22" cy="16" r="1.2" fill="#0b1020"/>
                </svg>
                <div class="dots">
                    <div class="dot-row">••••••</div>
                    <div class="dot-row">••••••••••</div>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="panel">
                <div class="title">Forgot<br>Your Password?</div>
                @if (session('status'))
                    <div style="margin-bottom:18px;color:#d1fae5;background:#06543933;border:1px solid #86efac;padding:12px;border-radius:10px;">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="field">
                        <input class="input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address" />
                    </div>
                    @if ($errors->any())
                        <div style="margin-top:12px;color:#ffe2e2;background:#7f1d1d33;border:1px solid #fecaca;padding:10px;border-radius:8px;text-align:left;">
                            <strong>Error:</strong>
                            <ul style="margin:6px 0 0 18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button class="btn" type="submit">Reset Password</button>
                </form>
                <div class="back-link">
                    <a href="{{ route('login') }}">Back to Log In</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
