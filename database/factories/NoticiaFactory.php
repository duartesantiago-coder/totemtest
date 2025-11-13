<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Noticia>
 */
class NoticiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(4),
            'contenido' => $this->faker->paragraphs(3, true),
            'publicada' => $this->faker->boolean(80),
            'autor_id' => User::factory(),
            'imagen' => null,
        ];
    }
}
