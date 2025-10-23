<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Efemeride;

class EfemerideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Efemeride::create([
            'contenido' => 'Día de la Independencia',
            'imagen' => 'independencia.jpg',
            'fecha' => '2024-07-09',
        ]);
    }
}
