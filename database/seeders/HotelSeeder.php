<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::create([
            'name' => 'Hotel Garibaldi',
            'city' => 'Brescia',
            'street' => 'Via Garibaldi',
            'house_number' => '75',
            'zip_code' => '25125',
            'price' => 75.00,
            'description' => 'Un hotel accogliente nel centro storico, perfetto per famiglie e viaggiatori d\'affari.'
        ]);

        Hotel::create([
            'name' => 'Hotel Vittorio Emanuele',
            'city' => 'Milano',
            'street' => 'Via Vittorio Emanuele',
            'house_number' => '25',
            'zip_code' => '20057',
            'price' => 120.50,
            'description' => 'Lusso e comfort a due passi dal Duomo. Colazione inclusa e vista panoramica.'
        ]);

        Hotel::create([
            'name' => 'Sea View Resort',
            'city' => 'Napoli',
            'street' => 'Lungomare Caracciolo',
            'house_number' => '10',
            'zip_code' => '80100',
            'price' => 90.00,
            'description' => 'Goditi il sole e il mare in questo splendido resort con piscina.'
        ]);
    }
}
