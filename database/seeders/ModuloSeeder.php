<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modulo::create([
            'hora_inicio' => '07:00:00',
            'hora_final' => '07:40:00',
        ]);
        Modulo::create([
            'hora_inicio' => '07:40:00',
            'hora_final' => '08:15:00',
        ]);
        Modulo::create([
            'hora_inicio' => '08:25:00',
            'hora_final' => '09:05:00',
        ]);
                Modulo::create([
            'hora_inicio' => '09:05:00',
            'hora_final' => '09:40:00',
        ]);
                Modulo::create([
            'hora_inicio' => '09:50:00',
            'hora_final' => '10:30:00',
        ]);
                Modulo::create([
            'hora_inicio' => '10:30:00',
            'hora_final' => '11:05:00',
        ]);
                Modulo::create([
            'hora_inicio' => '11:15:00',
            'hora_final' => '11:55:00',
        ]);
                Modulo::create([
            'hora_inicio' => '11:55:00',
            'hora_final' => '12:30:00',
        ]);
    }
}
