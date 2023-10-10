<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Str::random(8);

        \App\Models\User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@exata.it',
            'password' => bcrypt($password),
            'role' => 'superadmin',
        ]);

        print('----------------------------------------------------------------');
        print('Admin password: ' . $password);
        print('');
    }
}
