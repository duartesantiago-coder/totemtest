<?php

namespace Database\Seeders;

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
        // Módulos turno mañana
        $modulosManana = [
            ['hora_inicio' => '07:30', 'hora_final' => '08:10'],
            ['hora_inicio' => '08:10', 'hora_final' => '08:50'],
            ['hora_inicio' => '09:00', 'hora_final' => '09:40'],
            ['hora_inicio' => '09:40', 'hora_final' => '10:20'],
            ['hora_inicio' => '10:30', 'hora_final' => '11:10'],
            ['hora_inicio' => '11:10', 'hora_final' => '11:50']
        ];

        // Módulos turno tarde
        $modulosTarde = [
            ['hora_inicio' => '13:30', 'hora_final' => '14:10'],
            ['hora_inicio' => '14:10', 'hora_final' => '14:50'],
            ['hora_inicio' => '15:00', 'hora_final' => '15:40'],
            ['hora_inicio' => '15:40', 'hora_final' => '16:20'],
            ['hora_inicio' => '16:30', 'hora_final' => '17:10'],
            ['hora_inicio' => '17:10', 'hora_final' => '17:50']
        ];

        foreach ($modulosManana as $modulo) {
            Modulo::create([
                'hora_inicio' => $modulo['hora_inicio'],
                'hora_final' => $modulo['hora_final'],
                'turno' => 'mañana'
            ]);
        }

        foreach ($modulosTarde as $modulo) {
            Modulo::create([
                'hora_inicio' => $modulo['hora_inicio'],
                'hora_final' => $modulo['hora_final'],
                'turno' => 'tarde'
            ]);
        }
    }
}
