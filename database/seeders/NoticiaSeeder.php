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
            'fecha' => '2024-09-01 10:00:00',
            'imagen' => 'biblioteca.jpg',
        ]);
    }
}
