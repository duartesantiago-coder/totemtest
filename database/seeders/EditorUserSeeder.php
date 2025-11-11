<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EditorUserSeeder extends Seeder
{
    public function run()
    {
        // Cambia estos valores a tu preferencia
        $email = 'editor@example.com';
        $user = User::where('email', $email)->first();
        if (! $user) {
            User::create([
                'name' => 'Editor Usuario',
                'email' => $email,
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_editor' => true,
            ]);
            $this->command->info("Usuario editor creado: $email / password");
        } else {
            $user->is_editor = true;
            $user->save();
            $this->command->info("Usuario editor actualizado: $email");
        }
    }
}
