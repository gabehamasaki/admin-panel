<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
