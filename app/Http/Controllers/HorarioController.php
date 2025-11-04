<?php
namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Aula;
use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Models\Curso;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // Mostrar la grilla en modo lectura
    public function index(Curso $curso)
    {
        // cargamos módulos (ordenados), aulas y horarios del curso
        $modulos = Modulo::orderBy('id')->get();
        $aulas = Aula::orderBy('nombre')->get();

        // traemos todos los horarios del curso con relaciones
        $horarios = Horario::with(['aula', 'modulo'])
            ->where('curso_id', $curso->id)
            ->get();

        // reorganizamos en un array [modulo_id][dia] => horario
        $grid = [];
        foreach ($horarios as $h) {
            $grid[$h->modulo_id][$h->dia] = $h; // dia es el ENUM (1..5)
        }

        return view('horarios.index', compact('curso','modulos','aulas','grid'));
    }

    // Mostrar la grilla en modo edición (selects)
    public function edit(Curso $curso)
    {
        $modulos = Modulo::orderBy('id')->get();
        $aulas = Aula::orderBy('nombre')->get();
        $horarios = Horario::with('aula')->where('curso_id', $curso->id)->get();

        $grid = [];
        foreach ($horarios as $h) {
            $grid[$h->modulo_id][$h->dia] = $h;
        }

        return view('horarios.edit', compact('curso','modulos','aulas','grid'));
    }

    // Guardar (actualiza varios horarios)
    public function update(Request $request, Curso $curso)
    {
        // esperamos un array aula[horario_id] => aula_id
        $data = $request->input('aula', []); // ejemplo: ['12' => 5, '13' => 3]

        foreach ($data as $horario_id => $aula_id) {
            $h = Horario::find($horario_id);
            if ($h && $h->curso_id == $curso->id) {
                $h->aula_id = $aula_id;
                $h->save();
            }
        }

        return redirect()->route('horarios.index', $curso)->with('success','Horarios actualizados.');
    }
}
