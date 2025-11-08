<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class   CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Curso::create(['anio' => 1, 'division' => 'A', 'turno' => 'mañana']);
        Curso::create(['anio' => 1, 'division' => 'B', 'turno' => 'mañana']);
        Curso::create(['anio' => 1, 'division' => 'C', 'turno' => 'tarde']);
        Curso::create(['anio' => 1, 'division' => 'D', 'turno' => 'tarde']);
        // y así hasta 5ºD
        Curso::create(['anio' => 2, 'division' => 'A', 'turno' => 'mañana']);
        Curso::create(['anio' => 2, 'division' => 'B', 'turno' => 'mañana']);
        Curso::create(['anio' => 2, 'division' => 'C', 'turno' => 'tarde']);
        Curso::create(['anio' => 2, 'division' => 'D', 'turno' => 'tarde']);
        Curso::create(['anio' => 3, 'division' => 'A', 'turno' => 'mañana']);
        Curso::create(['anio' => 3, 'division' => 'B', 'turno' => 'mañana']);
        Curso::create(['anio' => 3, 'division' => 'C', 'turno' => 'tarde']);
        Curso::create(['anio' => 3, 'division' => 'D', 'turno' => 'tarde']);
        Curso::create(['anio' => 4, 'division' => 'A', 'turno' => 'mañana']);
        Curso::create(['anio' => 4, 'division' => 'B', 'turno' => 'mañana']);
        Curso::create(['anio' => 4, 'division' => 'C', 'turno' => 'tarde']);
        Curso::create(['anio' => 4, 'division' => 'D', 'turno' => 'tarde']);
        Curso::create(['anio' => 5, 'division' => 'A', 'turno' => 'mañana']);
        Curso::create(['anio' => 5, 'division' => 'B', 'turno' => 'mañana']);
        Curso::create(['anio' => 5, 'division' => 'C', 'turno' => 'tarde']);
        Curso::create(['anio' => 5, 'division' => 'D', 'turno' => 'tarde']);

    }
}


