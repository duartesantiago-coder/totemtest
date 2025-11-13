<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HorarioFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_mostrar_por_dia_is_accessible()
    {
        $resp = $this->get(route('horarios.mostrarPorDia', ['dia' => 1]));

        $resp->assertStatus(200);
        $resp->assertSee('Horarios');
    }
}
