<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aula;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Aula::create(['nombre' => 'Vacío']); // 
        Aula::create(['nombre' => 'Aula Maker']); //X
        Aula::create(['nombre' => 'Matemática']); //X
        Aula::create(['nombre' => 'Lengua Extranjera']); //X
        Aula::create(['nombre' => 'Exactas']); //X
        Aula::create(['nombre' => 'Lengua y Literatura']); //X
        Aula::create(['nombre' => 'Sociales']); //X
        Aula::create(['nombre' => 'Laboratorio']); //X
        Aula::create(['nombre' => 'Informática']); //X
        Aula::create(['nombre' => 'Gim']); //X
        Aula::create(['nombre' => 'Invernadero']); //X
        Aula::create(['nombre' => 'Aula Roja']); //X
        


    }
}
