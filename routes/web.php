<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImportacionController;
use App\Http\Controllers\MaquinariaDisponibleController;
use App\Http\Controllers\MaquinaController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

/*
|--------------------------------------------------------------------------
| Rutas de Prueba (sin autenticación)
|--------------------------------------------------------------------------
*/
Route::get('/test-form', function() {
    return view('importaciones.test_form');
})->name('test.form');

Route::post('/test-post', function(Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Funciona!',
        'data' => $request->all(),
        'token' => csrf_token()
    ]);
})->name('test.post');

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas de Recuperación de Contraseña
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Rutas de Registro
|--------------------------------------------------------------------------
*/
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // ==================== DASHBOARDS ====================
    
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard-ventas', [UserController::class, 'dashboardVentas'])->name('dashboard.ventas');
    Route::get('/dashboard-cartera', [UserController::class, 'dashboardCartera'])->name('dashboard.cartera');
    Route::get('/dashboard-importaciones', [ImportacionController::class, 'dashboard'])->name('dashboard.importaciones');
    Route::get('/dashboard-despachos', [UserController::class, 'dashboardDespachos'])->name('dashboard.despachos');
    Route::get('/dashboard-facturacion', [UserController::class, 'dashboardFacturacion'])->name('dashboard.facturacion');
    
    // ==================== CRUD DE MÁQUINAS ====================
    Route::resource('maquinas', MaquinaController::class);
    
    // ==================== CRUD DE IMPORTACIONES Y MAQUINARIA ====================
    Route::prefix('importaciones')->name('importaciones.')->group(function () {
        
        // ==================== MAQUINARIA DISPONIBLE (PRIMERO) ====================
        Route::get('/maquinaria-disponible', [MaquinariaDisponibleController::class, 'index'])->name('maquinaria-disponible');
        Route::get('/maquinaria-disponible/estadisticas/resumen', [MaquinariaDisponibleController::class, 'estadisticas'])->name('maquinaria-disponible.estadisticas');
        Route::get('/maquinaria-disponible/marcas', [MaquinariaDisponibleController::class, 'getMarcas'])->name('maquinaria-disponible.marcas');
        Route::post('/maquinaria-disponible/{id}/cambiar-estado', [MaquinariaDisponibleController::class, 'cambiarEstado'])->name('maquinaria-disponible.cambiar-estado');
        Route::post('/maquinaria-disponible/{id}/reservar', [MaquinariaDisponibleController::class, 'reservar'])->name('maquinaria-disponible.reservar');
        Route::post('/maquinaria-disponible/{id}/vender', [MaquinariaDisponibleController::class, 'vender'])->name('maquinaria-disponible.vender');
        
        // ==================== CRUD DE IMPORTACIONES ====================
        Route::get('/', [ImportacionController::class, 'index'])->name('index');
        Route::get('/create', [ImportacionController::class, 'create'])->name('create');
        Route::post('/', [ImportacionController::class, 'store'])->name('store');
        
        // ==================== RUTAS DINÁMICAS (AL FINAL) ====================
        // ✅ Usan Route Model Binding con 'numero_orden'
        Route::get('/{orden}', [ImportacionController::class, 'show'])->name('show');
        Route::get('/{orden}/edit', [ImportacionController::class, 'edit'])->name('edit');
        Route::put('/{orden}', [ImportacionController::class, 'update'])->name('update');
        Route::delete('/{orden}', [ImportacionController::class, 'destroy'])->name('destroy');
    });
    
    // ==================== GESTIÓN DE USUARIOS ====================
    Route::resource('usuarios', UserController::class);
    
    // ==================== RUTAS ADICIONALES ====================
    Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [UserController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    
    // ==================== RUTA DE PRUEBA PARA MAQUINARIA DISPONIBLE ====================
    Route::get('/maquinaria-disponible-test', [MaquinariaDisponibleController::class, 'index'])->name('maquinaria-disponible.test');
});