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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
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
// si aparece este error: Class 'App\Http\Controllers\HorarioController' not found
// agregar al inicio del archivo web.php:
// use App\Http\Controllers\HorarioController;
// si aparece este error: "Class "Controller" not found" en HorarioController.php
// agregar al inicio del archivo HorarioController.php:
// use App\Http\Controllers\Controller;
  //      return redirect()->route('horarios.index', ['curso' => $curso->id])->with('success','Horarios actualizados.');
   // }
//}   