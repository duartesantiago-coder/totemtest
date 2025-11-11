<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(CursoSeeder::class);
        $this->call(AulaSeeder::class);
        $this->call(ModuloSeeder::class);
        $this->call(EfemerideSeeder::class);
        $this->call(NoticiaSeeder::class);   
    $this->call(EditorUserSeeder::class);
        //$this->call(UserSeeder::class);
        $this->call(HorarioSeeder::class);           
    }
}
