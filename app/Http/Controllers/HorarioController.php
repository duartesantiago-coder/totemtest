<?php
namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Aula;
use App\Models\Modulo;
use App\Models\Curso;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    private $dias = [
        1 => 'Lunes',
        2 => 'Martes', 
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes'
    ];

    // Mostrar la grilla en modo lectura
    public function index(Curso $curso)
    {
        // Determinar turno del curso
        $turno = $curso->turno;

        // Filtrar módulos por turno
        $modulos = Modulo::where('turno', $turno)
                        ->orderBy('hora_inicio')
                        ->get();

        $aulas = Aula::orderBy('nombre')->get();

        // Obtener horarios del curso
        $horarios = Horario::with(['aula', 'modulo'])
                          ->where('curso_id', $curso->id)
                          ->get();

        // Crear grid para la vista
        $grid = [];
        foreach ($horarios as $h) {
            $grid[$h->modulo_id][$h->dia] = $h;
        }

        return view('horarios.index', compact('curso', 'modulos', 'aulas', 'grid'));
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
    public function mostrarPorDia($dia, $turno = 'mañana')
    {
        // Validar día
        if (!isset($this->dias[$dia])) {
            abort(404, 'Día no válido');
        }

        // Nombre del día para la vista
        $nombreDia = $this->dias[$dia];

        // Filtrar módulos por turno
        $modulos = Modulo::where('turno', $turno)
                        ->orderBy('hora_inicio')
                        ->get();

        // Filtrar cursos por turno
        $cursos = Curso::where('turno', $turno)
                      ->orderBy('anio')
                      ->orderBy('division')
                      ->get();

        // Obtener horarios para este día
        $horarios = Horario::with(['aula', 'modulo'])
                          ->where('dia', $dia)
                          ->whereHas('curso', function($query) use ($turno) {
                              $query->where('turno', $turno);
                          })
                          ->get();

        // Crear grid para la vista
        $grid = [];
        foreach ($cursos as $curso) {
            foreach ($modulos as $modulo) {
                $horario = $horarios->first(function($h) use ($curso, $modulo) {
                    return $h->curso_id == $curso->id && $h->modulo_id == $modulo->id;
                });
                $grid[$curso->id][$modulo->id] = $horario ? ($horario->aula->nombre ?? 'Vacío') : 'Vacío';
            }
        }

        return view('horarios.dia', compact(
            'modulos',
            'cursos',
            'grid',
            'dia',
            'turno',
            'nombreDia'
        ));
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