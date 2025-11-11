<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Noticia;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Noticia::create([
            'titulo' => 'Nueva Biblioteca Escolar',
            'contenido' => 'Se ha inaugurado una nueva biblioteca en la escuela con una amplia colección de libros para todas las edades.',
            // 'fecha' e 'imagen' no existen en la tabla 'noticias' según la migración.
            // Guardamos solo los campos definidos en el modelo/migración.
            'publicada' => true,
        ]);
    }
}
