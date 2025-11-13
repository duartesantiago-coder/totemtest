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

// Email verification routes
Route::get('/verify-email', [App\Http\Controllers\Auth\EmailVerificationController::class, 'form'])->name('verify-email.form');
Route::post('/verify-email', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verify'])->name('verify-email.check');
Route::post('/verify-email/resend', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resend'])->name('verify-email.resend');

// Proteger la gran mayoría de rutas con autenticación
Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Cursos
    Route::get('/cursos', [App\Http\Controllers\CursoController::class, 'index'])->name('cursos.index');

    // Rutas de cursos/horarios
    Route::prefix('cursos/{curso}')->group(function () {
        Route::get('horarios', [HorarioController::class, 'index'])->name('horarios.index');
        Route::get('horarios/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
        Route::put('horarios', [HorarioController::class, 'update'])->name('horarios.update');
    });

    // Toggle "modo traspao"
    Route::post('/modo-traspao/toggle', function (Request $request) {
        $nuevo = ! $request->session()->get('modo_traspao', false);
        $request->session()->put('modo_traspao', $nuevo);
        $request->session()->flash('success', 'Modo traspao '.($nuevo ? 'activado' : 'desactivado'));
        return redirect()->back();
    })->name('modo.toggle');

    // Horarios por día
    Route::get('/horarios/dia/{dia}', [HorarioController::class, 'mostrarPorDia'])
        ->name('horarios.mostrarPorDia')
        ->where('dia', '[1-5]');

    // Noticias (listado y detalle) - ahora requieren login
    Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
    Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show')->where('noticia', '[0-9]+');

    // Rutas para crear/editar/eliminar noticias: permitidas a admins o editores
    Route::middleware(['editor_or_admin'])->group(function () {
        Route::get('/noticias/crear', [NoticiaController::class, 'create'])->name('noticias.create');
        Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store');
        Route::get('/noticias/{noticia}/editar', [NoticiaController::class, 'edit'])->name('noticias.edit');
        Route::post('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');
        Route::post('/noticias/{noticia}/eliminar', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
    });

    // Rutas protegidas para administradores
    Route::middleware(['is_admin'])->group(function () {
        Route::post('/cursos/{curso}/toggle-turno', [CursoController::class, 'toggleTurno'])->name('cursos.toggleTurno');

        Route::get('/cursos/{curso}/horarios/edit', [HorarioController::class, 'edit'])->name('horarios.edit');

        Route::post('/cursos/{curso}/horarios/update', [HorarioController::class, 'updateCurso'])->name('horarios.update');

        // Panel de administración de usuarios (marcar como editor/admin)
        Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/{user}/toggle-editor', [\App\Http\Controllers\Admin\UserController::class, 'toggleEditor'])->name('admin.users.toggleEditor');
        Route::post('/admin/users/{user}/toggle-admin', [\App\Http\Controllers\Admin\UserController::class, 'toggleAdmin'])->name('admin.users.toggleAdmin');
    });
});


