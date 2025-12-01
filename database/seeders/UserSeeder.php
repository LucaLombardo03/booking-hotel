<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN
        // "Cerca se esiste questa email. Se non c'è, crea l'utente con questi dati."
        User::firstOrCreate(
            ['email' => 'admin@hotel.it'], // Campo da controllare
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Luca
        User::firstOrCreate(
            ['email' => 'luca@gmail.com'], 
            [
                'name' => 'Luca Lombardo',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // 3. Francesco
        User::firstOrCreate(
            ['email' => 'francesco@gmail.com'],
            [
                'name' => 'Francesco Tonassi',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}