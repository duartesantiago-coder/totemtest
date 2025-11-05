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

        return view('horarios.edit', compact('curso','modulos','aulas','grid', ));
    }
    public function dia($dia)
    {
        $modulos = Modulo::orderBy('id')->get();
        $cursos = Curso::orderBy('nombre')->get();
        $aulas = Aula::orderBy('nombre')->get();

        $vacíoId = Aula::where('nombre', 'Vacío')->value('id');

        // Traemos todos los horarios del día con relaciones
        $horarios = Horario::with(['aula', 'modulo', 'curso'])
            ->where('dia', $dia)
            ->get();

        // Creamos un array organizado por curso y módulo
        $grid = [];
        foreach ($cursos as $curso) {
            foreach ($modulos as $modulo) {
                $horario = $horarios
                    ->where('curso_id', $curso->id)
                    ->where('modulo_id', $modulo->id)
                    ->first();

                $grid[$curso->id][$modulo->id] = $horario && $horario->aula_id != $vacíoId
                    ? $horario->aula->nombre
                    : 'Vacío';
            }
        }

        // Filtrar cursos completamente vacíos (usar array vacío si no hay entradas para evitar "Clave de matriz no definida")
        $cursosVisibles = $cursos->filter(function ($curso) use ($grid) {
            return collect($grid[$curso->id] ?? [])->contains(function ($aula) {
                return $aula !== 'Vacío';
            });
        });

        return view('horarios.dia', compact('modulos', 'cursosVisibles', 'grid', 'dia'));
    }

    // Mostrar la tabla principal por día (ejemplo: /horarios/dia/1)
    public function mostrarPorDia($dia)
    {
        // Obtener módulos, días y cursos
        $modulos = \App\Models\Modulo::orderBy('id')->get();
        $dias = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes'];
        $nombreDia = $dias[$dia] ?? 'Desconocido';

        // Traer todos los horarios de ese día con relaciones
        $horarios = Horario::with(['curso', 'aula', 'modulo'])
            ->where('dia', $dia)
            ->get();

        // Construir grid [curso_id][modulo_id] => aulaNombre | 'Vacío'
        $cursos = Curso::orderBy('anio')->orderBy('division')->get();
        $vacioId = Aula::where('nombre', 'Vacío')->value('id');
        $grid = [];

        foreach ($cursos as $curso) {
            foreach ($modulos as $modulo) {
                $horario = $horarios
                    ->where('curso_id', $curso->id)
                    ->where('modulo_id', $modulo->id)
                    ->first();

                $grid[$curso->id][$modulo->id] = $horario && $horario->aula_id != $vacioId
                    ? ($horario->aula->nombre ?? 'Vacío')
                    : 'Vacío';
            }
        }

        // Filtrar cursos que tengan al menos una aula distinta de 'Vacío'
        $cursosVisibles = $cursos->filter(function ($curso) use ($grid) {
            return collect($grid[$curso->id] ?? [])->contains(function ($aula) {
                return $aula !== 'Vacío';
            });
        });

        return view('horarios.dia', compact('modulos', 'cursosVisibles', 'grid', 'dia', 'nombreDia', 'cursos'));
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
// si aparece Clave de matriz no definida 1 en horarios/dia.blade.php
// es porque no se están pasando los datos correctos a la vista desde el controlador HorarioController.php
// tenés que asegurarte de que en el método mostrarPorDia se estén pasando las variables correctas a la vista
// tenés que agregar compact('cursos','dia','nombreDia','horarios','modulos', 'cursosVisibles', 'grid');
// al final del return view(...) en el método mostrarPorDia y si lo estas haciendo bien, revisar que los nombres de las variables en la vista coincidan con los que se están pasando desde el controlador
// grid deberia estar 