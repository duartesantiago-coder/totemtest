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
         Curso::create([
            'anio' => '1',
            'division' => 'A'
        ]);
        Curso::create([
            'anio' => '1',
            'division' => 'B'
        ]);
           Curso::create([
            'anio' => '1',
            'division' => 'C'
        ]);
        Curso::create([
            'anio' => '1',
            'division' => 'D'
        ]);
        Curso::create([
            'anio' => '2',
            'division' => 'A'
        ]);    
         Curso::create([
            'anio' => '2',
            'division' => 'B'
        ]);
        Curso::create([
            'anio' => '2',
            'division' => 'C'
        ]);
        Curso::create([
            'anio' => '2',
            'division' => 'D'
        ]);
         Curso::create([
            'anio' => '3',
            'division' => 'A'
        ]);
         Curso::create([
            'anio' => '3',
            'division' => 'B'
        ]);
         Curso::create([
            'anio' => '3',
            'division' => 'C'
        ]);
         Curso::create([
            'anio' => '3',
            'division' => 'D'
        ]);
            Curso::create([
                'anio' => '4',
                'division' => 'A'
            ]);
            Curso::create([
                'anio' => '4',
                'division' => 'B'
            ]);
            Curso::create([
                'anio' => '4',
                'division' => 'C'
            ]);
            Curso::create([
                'anio' => '4',
                'division' => 'D'
            ]);
            Curso::create([
                'anio' => '5',
                'division' => 'A'
            ]);
            Curso::create([
                'anio' => '5',
                'division' => 'B'
            ]);
            Curso::create([
                'anio' => '5',
                'division' => 'C'
            ]);
            Curso::create([
                'anio' => '5',
                'division' => 'D'
            ]);
    }
}


