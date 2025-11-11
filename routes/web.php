<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HorarioController;

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
// Ruta para ver horarios por día
Route::get('/horarios/dia/{dia}', [HorarioController::class, 'mostrarPorDia'])
    ->name('horarios.mostrarPorDia');

// Rutas protegidas para administradores
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::post('/cursos/{curso}/toggle-turno', [CursoController::class, 'toggleTurno'])
        ->name('cursos.toggleTurno');
    Route::resource('horarios', HorarioController::class)
        ->except(['show', 'index']);
});


