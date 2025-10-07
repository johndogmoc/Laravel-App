<?php
  
  use Illuminate\Support\Facades\Route;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\Password;
  use Illuminate\Auth\Events\PasswordReset;
  use Illuminate\Support\Str;
  use App\Models\User;
  use App\Models\Profile;
  
  /*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  | routes are loaded by the RouteServiceProvider and all of them will be
  | assigned to the "web" middleware group. Make something great!
  |
  */

  // Auth: Login + Register (guest only)
  Route::middleware('guest')->group(function () {
      // Login UI
      Route::get('/login', function () {
          return view('auth.login');
      })->name('login');

      // Login handler
      Route::post('/login', function (Request $request) {
          $credentials = $request->validate([
              'email' => ['required', 'email'],
              'password' => ['required'],
          ]);

          $remember = (bool) $request->boolean('remember');
          if (Auth::attempt($credentials, $remember)) {
              $request->session()->regenerate();
              return redirect()->intended('/');
          }

          return back()->withErrors([
              'email' => 'The provided credentials do not match our records.',
          ])->onlyInput('email');
      })->name('login.perform');

      // Register UI
      Route::get('/register', function () {
          return view('auth.register');
      })->name('register');

      // Register handler
      Route::post('/register', function (Request $request) {
          $data = $request->validate([
              'first_name' => ['required','string','max:255'],
              'last_name' => ['required','string','max:255'],
              'middle_name' => ['nullable','string','max:255'],
              'sex' => ['nullable','string','max:20'],
              'email' => ['required','email','max:255','unique:users,email'],
              'phone' => ['nullable','string','max:50'],
              'password' => ['required','confirmed','min:6'],
              'dob_month' => ['nullable','integer','between:1,12'],
              'dob_day' => ['nullable','integer','between:1,31'],
              'dob_year' => ['nullable','integer', 'between:1900,' . date('Y')],
              'gender' => ['nullable','string','max:10'],
          ]);

          $user = User::create([
              'name' => trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')),
              'email' => $data['email'],
              'password' => Hash::make($data['password']),
          ]);

          // Optionally create a Profile if model/table exists
          try {
              if (class_exists(Profile::class)) {
                  Profile::create([
                      'first_name' => $data['first_name'] ?? null,
                      'last_name' => $data['last_name'] ?? null,
                      'email' => $data['email'] ?? null,
                  ]);
              }
          } catch (\Throwable $e) {
              // Ignore profile creation errors to not block signup
          }

          Auth::login($user);
          $request->session()->regenerate();
          return redirect()->intended('/');
      })->name('register.perform');

      // Admin Login UI
      Route::get('/admin/login', function () {
          return view('auth.admin-login');
      })->name('admin.login');

      // Forgot Password UI
      Route::get('/forgot-password', function () {
          return view('auth.forgot-password');
      })->name('password.request');

      // Forgot Password handler (send reset link)
      Route::post('/forgot-password', function (Request $request) {
          $request->validate(['email' => 'required|email']);

          $status = Password::sendResetLink(
              $request->only('email')
          );

          return $status === Password::RESET_LINK_SENT
                      ? back()->with(['status' => __($status)])
                      : back()->withErrors(['email' => __($status)]);
      })->name('password.email');

      // Reset Password UI
      Route::get('/reset-password/{token}', function (string $token) {
          return view('auth.reset-password', ['token' => $token, 'email' => request('email')]);
      })->name('password.reset');

      // Reset Password handler
      Route::post('/reset-password', function (Request $request) {
          $request->validate([
              'token' => 'required',
              'email' => 'required|email',
              'password' => 'required|min:6|confirmed',
          ]);

          $status = Password::reset(
              $request->only('email', 'password', 'password_confirmation', 'token'),
              function (User $user, string $password) {
                  $user->forceFill([
                      'password' => Hash::make($password)
                  ])->setRememberToken(Str::random(60));

                  $user->save();

                  event(new PasswordReset($user));
              }
          );

          return $status === Password::PASSWORD_RESET
                      ? redirect()->route('login')->with('status', __($status))
                      : back()->withErrors(['email' => [__($status)]]);
      })->name('password.update');

      // Admin Login handler (same users table; requires is_admin=true)
      Route::post('/admin/login', function (Request $request) {
          $credentials = $request->validate([
              'email' => ['required','string'], // can be shown as Username or Email
              'password' => ['required','string'],
          ]);

          // In case you later support username/phone, map here. For now treat as email.
          if (filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
              $attempt = ['email' => $credentials['email'], 'password' => $credentials['password']];
          } else {
              $attempt = ['email' => $credentials['email'], 'password' => $credentials['password']];
          }

          if (Auth::attempt($attempt, (bool)$request->boolean('remember'))) {
              $request->session()->regenerate();
              if (Auth::user() && Auth::user()->is_admin) {
                  return redirect()->intended('/admin');
              }
              // Not an admin: force logout and show error
              Auth::logout();
              $request->session()->invalidate();
              $request->session()->regenerateToken();
              return back()->withErrors(['email' => 'You are not authorized to access the admin area.']);
          }

          return back()->withErrors(['email' => 'Invalid admin credentials.'])->onlyInput('email');
      })->name('admin.login.perform');
  });

  Route::post('/logout', function (Request $request) {
      Auth::guard()->logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect('/login');
  })->name('logout');

  // Redirect guests at root to register first
  Route::get('/', function () {
      return redirect()->route('register');
  })->middleware('guest');

  // Dedicated page to display the Names List
  Route::get('/Lists', function () {
      return view('lists');
  })->middleware('auth');
  
  // Simple Admin Dashboard placeholder (auth + is_admin)
  Route::get('/admin', function (Request $request) {
      if (!Auth::check() || !Auth::user()->is_admin) {
          return redirect()->route('admin.login')->withErrors(['email' => 'Please sign in as admin.']);
      }
      return view('admin.dashboard');
  })->name('admin.dashboard');

  Route::get('/{any?}', function () {
      return view('welcome');
  })->middleware('auth')->where('any', '^(?!api).*$');
