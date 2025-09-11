<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\PautaController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\TecnicoOrdenController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\QuoteController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (páginas informativas)
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductoController::class, 'home'])->name('home');
Route::get('/servicios', fn() => view('pagina.servicios'))->name('servicios');
Route::get('/represent', fn() => view('pagina.represent'))->name('represent');
Route::get('/nosotros', fn() => view('pagina.nosotros'))->name('nosotros');
Route::get('/geom', fn() => view('pagina.geom'))->name('geom');
Route::get('/estructura', fn() => view('pagina.estructura'))->name('estructura');
Route::get('/equipo', fn() => view('pagina.equipo'))->name('equipo');
Route::get('/contacto', fn() => view('pagina.contacto'))->name('contacto');
Route::get('/cilindros', fn() => view('pagina.cilindros'))->name('cilindros');
Route::get('/software', fn() => view('pagina.software'))->name('software');

// Ruta para enviar formulario de contacto
Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');

// Rutas para newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Rutas para cotizaciones
Route::post('/quote/generate', [QuoteController::class, 'generatePDF'])->name('quote.generate');
Route::post('/quote/download', [QuoteController::class, 'downloadPDF'])->name('quote.download');
Route::post('/quote/send', [QuoteController::class, 'sendEmail'])->name('quote.send');

// Productos públicos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas por Autenticación
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard general
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/pdf', [DashboardController::class, 'exportarPDF'])->name('admin.dashboard.pdf');

    // Notificaciones
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones');
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('maquinarias', MaquinariaController::class)->except(['show']);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // ...
    Route::get('maquinarias', [MaquinariaController::class, 'index'])->name('maquinarias.index'); // la vista
    Route::get('maquinarias/datatable', [MaquinariaController::class, 'datatable'])->name('maquinarias.datatable'); // JSON
    Route::post('maquinarias', [MaquinariaController::class, 'store'])->name('maquinarias.store');
    Route::put('maquinarias/{maquinaria}', [MaquinariaController::class, 'update'])->name('maquinarias.update');
    Route::delete('maquinarias/{maquinaria}', [MaquinariaController::class, 'destroy'])->name('maquinarias.destroy');

    // Pautas datatable JSON
    Route::get('pautas/datatable', [PautaController::class, 'datatable'])->name('pautas.datatable'); // JSON

    // Órdenes de trabajo datatable JSON
    Route::get('ordenes/datatable', [OrdenTrabajoController::class, 'datatable'])->name('ordenes.datatable'); // JSON

    // Gestión de Áreas de Pauta
    Route::post('pautas/{pauta}/areas', [PautaController::class, 'storeArea'])->name('pautas.areas.store'); // crear área
    Route::put('pauta-areas/{area}', [PautaController::class, 'updateArea'])->name('pauta-areas.update'); // actualizar área
    Route::delete('pauta-areas/{area}', [PautaController::class, 'destroyArea'])->name('pauta-areas.destroy'); // eliminar área

    // Gestión de Ítems de Área
    Route::post('pauta-areas/{area}/items', [PautaController::class, 'storeItem'])->name('pauta-areas.items.store'); // crear ítem
    Route::put('pauta-items/{item}', [PautaController::class, 'updateItem'])->name('pauta-items.update'); // actualizar ítem
    Route::delete('pauta-items/{item}', [PautaController::class, 'destroyItem'])->name('pauta-items.destroy'); // eliminar ítem
});


    /*
    |--------------------------------------------------------------------------
    | Panel Administrador
    |--------------------------------------------------------------------------
    */
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {
    Route::resource('productos', ProductoController::class)->except(['show']);

        Route::resource('maquinarias', MaquinariaController::class);
        Route::resource('pautas', PautaController::class);
        // Órdenes de trabajo
        Route::resource('ordenes', OrdenTrabajoController::class);
        Route::get('ordenes/datatable', [OrdenTrabajoController::class, 'datatable'])->name('ordenes.datatable');
        Route::get('ordenes/{ordenTrabajo}/checklist', [OrdenTrabajoController::class, 'checklist'])->name('ordenes.checklist');
    Route::put('orden-items/{ordenTrabajoItem}', [OrdenTrabajoController::class, 'updateItem'])->name('ordenes.items.update');
        Route::post('ordenes/{ordenTrabajo}/finalizar', [OrdenTrabajoController::class, 'finalizar'])->name('ordenes.finalizar');
        
    });

    /*
    |--------------------------------------------------------------------------
    | Panel Técnico
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:tecnico'])->prefix('tecnico')->name('tecnico.')->group(function () {
        Route::resource('ordenes', TecnicoOrdenController::class);
    });
});

require __DIR__.'/auth.php';
