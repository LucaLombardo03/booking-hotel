<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// AGGIUNGI QUESTE DUE RIGHE QUI SOTTO:
use Database\Seeders\UserSeeder;
use Database\Seeders\HotelSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            HotelSeeder::class,
        ]);
    }
}
