<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\OrdentrabajoController;
use App\Http\Controllers\ReporteGananciasController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\NotaServicioController;
use App\Http\Controllers\PortadaController;
use App\Http\Controllers\HerramientasController;

// ============================================================================
// RUTAS PÚBLICAS
// ============================================================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================================================
// 🎯 PASO 5: RUTA FIRMADA PARA EL TÉCNICO (MAGIC LINK)
// El técnico accede desde el enlace del correo SIN LOGIN
// El enlace caduca al final del día (signed middleware)
// ============================================================================
Route::get('/tecnico/{id}/ganancias', [TecnicoController::class, 'verGanancias'])
    ->name('tecnico.ganancias')
    ->middleware('signed');

// ============================================================================
// RUTAS PROTEGIDAS
// ============================================================================
// ============================================================================
// PORTADA PÚBLICA (sin login)
// ============================================================================
Route::get('/', function () {
    $servicios = \App\Models\ServicioPortada::where('estado', 'visible')->orderBy('orden')->get();
    $taller = \App\Models\ConfiguracionTaller::first() ?? new \App\Models\ConfiguracionTaller();
    return view('publica.landing', compact('servicios', 'taller'));
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas Operativas (propietario y operario)
    Route::middleware('role:propietario,operario')->group(function () {

        // ===== RUTAS ESPECÍFICAS (deben ir ANTES de los resource) =====
        Route::get('/motos/buscar', [MotoController::class, 'buscar'])->name('motos.buscar');
        Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');

        Route::post('/ordenes/{id}/cambiar-estado', [OrdentrabajoController::class, 'cambiarEstado'])->name('ordenes.cambiarEstado');
        Route::post('/ordenes/{id}/registrar-pago', [OrdentrabajoController::class, 'registrarPago'])->name('ordenes.registrarPago');
        Route::post('/prestamos/{id}/devolver', [OrdentrabajoController::class, 'devolverHerramienta'])->name('prestamos.devolver');
        Route::get('/ordenes/{id}/pdf', [NotaServicioController::class, 'generarPDF'])->name('ordenes.pdf');

        // ===== RECURSOS =====
        Route::resource('clientes', ClienteController::class);
        Route::resource('motos', MotoController::class);
        Route::resource('ordenes', OrdentrabajoController::class);

        // ===== API INTERNA (motos por cliente) =====
        Route::get('/api/clientes/{id_cliente}/motos',
            [OrdentrabajoController::class, 'getMotosPorCliente'])
            ->name('api.clientes.motos');
    });

    // ============================================================================
    // RUTAS DEL ADMINISTRADOR (solo propietario)
    // ============================================================================
    Route::middleware('role:propietario')->group(function () {

        // Liquidación 50/50
        Route::get('/admin/ganancias',
            [ReporteGananciasController::class, 'index'])
            ->name('admin.ganancias');

        // Reportes de trabajos realizados
        Route::get('/admin/reportes',
            [ReporteGananciasController::class, 'reportes'])
            ->name('admin.reportes');

        // Reporte de notas impresas
        Route::get('/admin/notas-impresas',
            [ReporteGananciasController::class, 'notasImpresas'])
            ->name('admin.notasImpresas');

        // Gestión de Personal Técnico
        Route::get('/admin/personal', [EmpleadoController::class, 'indexTecnicos'])->name('admin.personal');
        Route::get('/admin/personal/create', [EmpleadoController::class, 'createTecnico'])->name('admin.personal.create');
        Route::post('/admin/personal', [EmpleadoController::class, 'storeTecnico'])->name('admin.personal.store');
        Route::get('/admin/personal/{id}/edit', [EmpleadoController::class, 'editTecnico'])->name('admin.personal.edit');
        Route::put('/admin/personal/{id}', [EmpleadoController::class, 'updateTecnico'])->name('admin.personal.update');
        Route::delete('/admin/personal/{id}', [EmpleadoController::class, 'destroyTecnico'])->name('admin.personal.destroy');
        Route::post('/admin/personal/{id}/restore', [EmpleadoController::class, 'restoreTecnico'])->name('admin.personal.restore');

        // Gestión de Herramientas
        Route::get('/admin/herramientas', [HerramientasController::class, 'index'])->name('admin.herramientas.index');
        Route::get('/admin/herramientas/create', [HerramientasController::class, 'create'])->name('admin.herramientas.create');
        Route::post('/admin/herramientas/store-herramienta', [HerramientasController::class, 'storeHerramienta'])->name('admin.herramientas.store-herramienta');
        Route::get('/admin/herramientas/{id}/edit', [HerramientasController::class, 'edit'])->name('admin.herramientas.edit');
        Route::put('/admin/herramientas/{id}', [HerramientasController::class, 'update'])->name('admin.herramientas.update');
        Route::delete('/admin/herramientas/{id}', [HerramientasController::class, 'destroy'])->name('admin.herramientas.destroy');
        Route::post('/admin/herramientas/{id}/devolver', [HerramientasController::class, 'devolver'])->name('admin.herramientas.devolver');

        // Gestión de Portada del Taller
        Route::get('/admin/portada', [PortadaController::class, 'index'])->name('admin.portada.index');
        Route::get('/admin/portada/create', [PortadaController::class, 'create'])->name('admin.portada.create');
        Route::post('/admin/portada', [PortadaController::class, 'store'])->name('admin.portada.store');
        Route::get('/admin/portada/{id}/edit', [PortadaController::class, 'edit'])->name('admin.portada.edit');
        Route::put('/admin/portada/{id}', [PortadaController::class, 'update'])->name('admin.portada.update');
        Route::delete('/admin/portada/{id}', [PortadaController::class, 'destroy'])->name('admin.portada.destroy');
        Route::get('/admin/portada/config-taller', [PortadaController::class, 'configTaller'])->name('admin.portada.config-taller');
        Route::post('/admin/portada/config-taller', [PortadaController::class, 'storeConfigTaller'])->name('admin.portada.store-config-taller');

        // CRUD de Servicios (configuración de precios)
        Route::resource('/admin/servicios', ServicioController::class)->names([
            'index'   => 'admin.servicios.index',
            'create'  => 'admin.servicios.create',
            'store'   => 'admin.servicios.store',
            'show'    => 'admin.servicios.show',
            'edit'    => 'admin.servicios.edit',
            'update'  => 'admin.servicios.update',
            'destroy' => 'admin.servicios.destroy',
        ]);
    });

    // Panel del Técnico (solo rol técnico)
    Route::middleware('role:tecnico')->group(function () {
        Route::get('/tecnico/dashboard',
            [TecnicoController::class, 'dashboard'])
            ->name('tecnico.dashboard');
    });

    // Finalizar jornada laboral de un técnico (solo propietario/admin)
    Route::middleware('role:propietario')->group(function () {
        Route::post('/tecnico/{id}/finalizar-jornada',
            [TecnicoController::class, 'finalizarJornada'])
            ->name('tecnico.finalizarJornada');
    });

});