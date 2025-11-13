<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Noticia;
use App\Models\User;

class NoticiaFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_only_published()
    {
        Noticia::factory()->create([ 'titulo' => 'Pub1', 'publicada' => true ]);
        Noticia::factory()->create([ 'titulo' => 'NoPub', 'publicada' => false ]);

        $resp = $this->get(route('noticias.index'));

        $resp->assertStatus(200);
        $resp->assertSee('Pub1');
        $resp->assertDontSee('NoPub');
    }

    public function test_search_filters_results()
    {
        Noticia::factory()->create([ 'titulo' => 'Noticia especial', 'publicada' => true ]);
        Noticia::factory()->create([ 'titulo' => 'Otra noticia', 'publicada' => true ]);

        $resp = $this->get(route('noticias.index', ['q' => 'especial']));

        $resp->assertStatus(200);
        $resp->assertSee('Noticia especial');
        $resp->assertDontSee('Otra noticia');
    }

    public function test_store_requires_editor_and_creates_noticia()
    {
        $user = User::factory()->create([ 'is_editor' => true ]);

        $this->actingAs($user);

        $data = [
            'titulo' => 'Nueva desde test',
            'contenido' => 'Contenido de prueba',
            'publicada' => true,
        ];

        $resp = $this->post(route('noticias.store'), $data);

        $resp->assertRedirect(route('noticias.index'));

        $this->assertDatabaseHas('noticias', [ 'titulo' => 'Nueva desde test' ]);
    }
}
