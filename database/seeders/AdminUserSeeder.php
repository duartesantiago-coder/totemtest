<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin@example.com';
        $password = env('ADMIN_SEED_PASSWORD', 'password123');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($password),
                'is_admin' => 1,
                'is_editor' => 1,
            ]
        );

        if ($this->command) {
            $this->command->info("Admin user created/updated: {$user->email}");
            $this->command->info("Password: {$password} (change it after login)");
        }
    }
}
