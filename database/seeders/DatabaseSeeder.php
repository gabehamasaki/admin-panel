<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::findOrCreate('superadmin');

        $password = Str::random(8);

        \App\Models\User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@exata.it',
            'password' => bcrypt($password),
        ])->assignRole('superadmin');
        print('Admin password: ' . $password);
        print('\n');
    }
}
