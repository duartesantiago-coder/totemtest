<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;
use App\Models\Curso;
use App\Models\Modulo;

class HorarioSeeder extends Seeder
{
    public function run()
    {
        $cursos = Curso::all(); // todos los cursos
        $modulos = Modulo::orderBy('id')->pluck('id')->toArray();

        // si no tenés una tabla Modulo con ids, usamos 1..8 por defecto
        if (empty($modulos)) {
            $modulos = range(1, 8);
        }

        $dias = [1,2,3,4,5]; // Lunes a Viernes

        foreach ($cursos as $curso) {
            foreach ($dias as $dia) {
                foreach ($modulos as $moduloId) {

                    // Evitamos duplicados: si ya existe ese registro no lo creamos
                    $exists = Horario::where('curso_id', $curso->id)
                        ->where('dia', $dia)
                        ->where('modulo_id', $moduloId)
                        ->exists();

                    if (!$exists) {
                        Horario::create([
                            'curso_id'  => $curso->id,
                            'dia'       => $dia,
                            'modulo_id' => $moduloId,
                            'aula_id'   => null, // o poner un id aleatorio: Aula::inRandomOrder()->first()->id
                        ]);
                    }
                }
            }
        }
    }
}
