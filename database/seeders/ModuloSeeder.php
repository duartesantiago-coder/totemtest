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
            ['hora_inicio' => '07:00', 'hora_final' => '07:40'],
            ['hora_inicio' => '07:40', 'hora_final' => '08:15'],
            ['hora_inicio' => '08:25', 'hora_final' => '09:05'],
            ['hora_inicio' => '09:05', 'hora_final' => '09:40'],
            ['hora_inicio' => '09:50', 'hora_final' => '10:30'],
            ['hora_inicio' => '10:30', 'hora_final' => '11:05'],
            ['hora_inicio' => '11:15', 'hora_final' => '11:55'],
            ['hora_inicio' => '11:55', 'hora_final' => '12:30']
        ];

        // Módulos turno tarde
        $modulosTarde = [
            ['hora_inicio' => '12:30', 'hora_final' => '13:10'],
            ['hora_inicio' => '13:10', 'hora_final' => '13:45'],
            ['hora_inicio' => '13:55', 'hora_final' => '14:30'],
            ['hora_inicio' => '14:30', 'hora_final' => '15:10'],
            ['hora_inicio' => '15:20', 'hora_final' => '16:00'],
            ['hora_inicio' => '16:00', 'hora_final' => '16:35'],
            ['hora_inicio' => '16:45', 'hora_final' => '17:25'],
            ['hora_inicio' => '17:25', 'hora_final' => '18:00']
            
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
