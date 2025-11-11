<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\NoticiaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/cursos', [App\Http\Controllers\CursoController::class, 'index'])
        ->name('cursos.index');
    //  Otras rutas protegidas por autenticación
});

//Route::get('/horarios', [App\Http\Controllers\HorarioController::class, 'index'])    ->name('horarios.index');

    // web.php
Route::prefix('cursos/{curso}')->group(function () { // lo que hace es agrupar las rutas bajo /cursos/{curso}
    Route::get('horarios', [HorarioController::class, 'index'])->name('horarios.index'); // significa que la URL completa es /cursos/{curso}/horarios
    Route::get('horarios/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('horarios', [HorarioController::class, 'update'])->name('horarios.update');
});

// Toggle "modo traspao" — POST estático con recarga
Route::post('/modo-traspao/toggle', function (Request $request) {
    $nuevo = ! $request->session()->get('modo_traspao', false);
    $request->session()->put('modo_traspao', $nuevo);
    $request->session()->flash('success', 'Modo traspao '.($nuevo ? 'activado' : 'desactivado'));
    return redirect()->back();
})->name('modo.toggle');

// Ruta pública para ver horarios por día
Route::get('/horarios/dia/{dia}', [HorarioController::class, 'mostrarPorDia'])
    ->name('horarios.mostrarPorDia')
    ->where('dia', '[1-5]');

// Rutas protegidas para administradores
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::post('/cursos/{curso}/toggle-turno', [CursoController::class, 'toggleTurno'])
        ->name('cursos.toggleTurno');
    
    Route::get('/cursos/{curso}/horarios/edit', [HorarioController::class, 'edit'])
        ->name('horarios.edit');
    
    Route::post('/cursos/{curso}/horarios/update', [HorarioController::class, 'updateCurso'])
        ->name('horarios.update');
        
    // Rutas para noticias
    Route::get('/noticias/crear', [NoticiaController::class, 'create'])->name('noticias.create');
    Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store');
    Route::get('/noticias/{noticia}/editar', [NoticiaController::class, 'edit'])->name('noticias.edit');
    Route::post('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');
    Route::post('/noticias/{noticia}/eliminar', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
});


