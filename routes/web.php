<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImportacionController;
use App\Http\Controllers\MaquinariaDisponibleController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\ProveedorController;
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
    
    // ==================== GESTIÓN DE PROVEEDORES ====================
    Route::resource('proveedores', ProveedorController::class);
    Route::post('/proveedores/{proveedore}/toggle-activo', [ProveedorController::class, 'toggleActivo'])->name('proveedores.toggle-activo');

    // ==================== CRUD DE MÁQUINAS ====================
    Route::resource('maquinas', MaquinaController::class);
    
    // ==================== RUTAS PARA MAQUINARIA DISPONIBLE (FUERA DEL GRUPO IMPORTACIONES) ====================
    Route::prefix('maquinaria-disponible')->name('maquinaria-disponible.')->group(function () {
        Route::get('/', [MaquinariaDisponibleController::class, 'index'])->name('index');
        Route::get('/estadisticas', [MaquinariaDisponibleController::class, 'estadisticas'])->name('estadisticas');
        Route::get('/marcas', [MaquinariaDisponibleController::class, 'getMarcas'])->name('marcas');
        Route::post('/{id}/cambiar-estado', [MaquinariaDisponibleController::class, 'cambiarEstado'])->name('cambiar-estado');
        Route::post('/{id}/reservar', [MaquinariaDisponibleController::class, 'reservar'])->name('reservar');
        Route::post('/{id}/vender', [MaquinariaDisponibleController::class, 'vender'])->name('vender');
    });
    
    // ==================== CRUD DE IMPORTACIONES ====================
    Route::prefix('importaciones')->name('importaciones.')->group(function () {
        
        // ==================== CRUD DE IMPORTACIONES ====================
        Route::get('/', [ImportacionController::class, 'index'])->name('index');
        Route::get('/create', [ImportacionController::class, 'create'])->name('create');
        Route::post('/', [ImportacionController::class, 'store'])->name('store');
        
        // RUTA PARA CREACIÓN MANUAL DE MÁQUINAS
        Route::post('/{orden}/crear-maquinas', [ImportacionController::class, 'crearMaquinas'])->name('crear-maquinas');

        // ==================== RUTAS DINÁMICAS (AL FINAL) ====================
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
    Route::get('/maquinaria-disponible-test', [MaquinariaDisponibleController::class, 'test'])->name('maquinaria-disponible.test');
});