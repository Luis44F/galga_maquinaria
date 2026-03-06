<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de Recuperación de Contraseña
Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

Route::post('/password/email', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    
    $status = Password::sendResetLink(
        $request->only('email')
    );
    
    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/password/reset/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

Route::post('/password/reset', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
    
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
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

// Rutas de Registro
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

// Rutas Protegidas (Requieren Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal (admin/gerencia)
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Dashboard de Ventas (para vendedores)
    Route::get('/dashboard-ventas', [UserController::class, 'dashboardVentas'])->name('dashboard.ventas');
    
    // Dashboard de Cartera (gestión de pagos)
    Route::get('/dashboard-cartera', [UserController::class, 'dashboardCartera'])->name('dashboard.cartera');
    
    // Dashboard de Importaciones (compras a fábrica)
    Route::get('/dashboard-importaciones', [UserController::class, 'dashboardImportaciones'])->name('dashboard.importaciones');
    
    // Dashboard de Despachos (gestión de envíos)
    Route::get('/dashboard-despachos', [UserController::class, 'dashboardDespachos'])->name('dashboard.despachos');
    
    // Dashboard de Facturación (emisión de facturas)
    Route::get('/dashboard-facturacion', [UserController::class, 'dashboardFacturacion'])->name('dashboard.facturacion');

    // Gestión Integral de Usuarios
    Route::resource('usuarios', UserController::class);
    
});