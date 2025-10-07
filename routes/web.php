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
  | routes are loaded by the RouteServiceProvider and all of them will be
  | assigned to the "web" middleware group. Make something great!
  |
  */

  // Auth: Guest routes (admin only)
  Route::middleware('guest')->group(function () {
      // Admin Login UI
      Route::get('/admin/login', function () {
          return view('auth.admin-login');
      })->name('admin.login');


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
      return redirect()->route('admin.login');
  })->name('logout');

  // Redirect guests at root to Admin login
  Route::get('/', function () {
      return redirect()->route('admin.login');
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
