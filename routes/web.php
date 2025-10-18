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
      // Regular user login route
      Route::get('/login', function () {
          return view('auth.login');
      })->name('login');
      
      // Regular user login handler
      Route::post('/login', function (Request $request) {
          $validated = $request->validate([
              'email' => ['required','email'],
              'password' => ['required','string'],
          ]);

          $remember = (bool)$request->boolean('remember');
          if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $remember)) {
              $request->session()->regenerate();
              return redirect()->intended('/dashboard');
          }

          return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
      })->name('login.perform');
      
      // Admin Login UI
      Route::get('/admin/login', function () {
          return view('auth.admin-login');
      })->name('admin.login');


      // Admin Login handler (email only; requires is_admin=true)
      Route::post('/admin/login', function (Request $request) {
          $validated = $request->validate([
              'email' => ['required','email'],
              'password' => ['required','string'],
          ]);

          $remember = (bool)$request->boolean('remember');
          if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $remember)) {
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

          return back()->withErrors(['email' => 'Invalid admin credentials. Please use your email address.'])->onlyInput('email');
      })->name('admin.login.perform');
  });

  Route::post('/logout', function (Request $request) {
      Auth::guard()->logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect()->route('admin.login');
  })->name('logout');

  // Root: redirect to dashboard if admin, otherwise to login
  Route::get('/', function () {
      if (Auth::check() && Auth::user()->is_admin) {
          return redirect()->route('admin.dashboard');
      }
      return redirect()->route('admin.login');
  });

  // Admin Register UI: always show the form
  Route::get('/admin/register', function () {
      return view('auth.admin-register');
  })->name('admin.register');

  // Admin Register POST (guest only): create admin, unique email enforced by validation
  Route::middleware('guest')->group(function () {
      Route::post('/admin/register', function (Request $request) {
          $validated = $request->validate([
              'name' => ['required','string','max:255'],
              'email' => ['required','string','email','max:255','unique:users,email'],
              'password' => ['required','confirmed','min:8'],
          ]);

          $user = User::create([
              'name' => $validated['name'],
              'email' => $validated['email'],
              'password' => Hash::make($validated['password']),
              'is_admin' => true,
          ]);

          return redirect()->route('admin.login')
              ->with('status', 'Sign up complete');
      })->name('admin.register.perform');
  });

  // Dedicated page to display the Names List (requires admin)
  Route::middleware(['auth'])->group(function () {
      Route::get('/Lists', function () {
          if (!Auth::user()->is_admin) {
              return redirect()->route('admin.login');
          }
          return view('lists');
      });
  });
  
  // Admin Dashboard (requires auth + is_admin)
  Route::middleware(['auth'])->group(function () {
      Route::get('/admin', function (Request $request) {
          if (!Auth::user()->is_admin) {
              Auth::logout();
              return redirect()->route('admin.login')->withErrors(['email' => 'You are not authorized to access the admin area.']);
          }
          return view('admin.dashboard');
      })->name('admin.dashboard');
  });

  Route::get('/{any?}', function () {
      return view('welcome');
  })->middleware('auth')->where('any', '^(?!api).*$');