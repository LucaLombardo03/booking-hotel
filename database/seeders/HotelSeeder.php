<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // Hotel esistenti (default 1 stanza se non specificato)
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
            'total_rooms' => 2,
            'description' => 'Lusso e comfort a due passi dal Duomo. Colazione inclusa e vista panoramica.'
        ]);

        Hotel::create([
            'name' => 'Sea View Resort',
            'city' => 'Napoli',
            'street' => 'Lungomare Caracciolo',
            'house_number' => '10',
            'zip_code' => '80100',
            'price' => 90.00,
            'total_rooms' => 3,
            'tourist_tax' => 2.50,
            'description' => 'Goditi il sole e il mare in questo splendido resort con piscina.'
        ]);

        // --- NUOVI HOTEL CON PIÙ STANZE ---

        Hotel::create([
            'name' => 'Grand Hotel Roma',
            'city' => 'Roma',
            'street' => 'Via Veneto',
            'house_number' => '100',
            'zip_code' => '00187',
            'price' => 250.00,
            'tourist_tax' => 5.00,
            'total_rooms' => 50, // Hotel grande
            'description' => 'Eleganza e storia nel cuore della capitale. Servizio a 5 stelle.'
        ]);

        Hotel::create([
            'name' => 'Firenze Riverside',
            'city' => 'Firenze',
            'street' => 'Lungarno',
            'house_number' => '12',
            'zip_code' => '50123',
            'price' => 140.00,
            'tourist_tax' => 4.00,
            'total_rooms' => 20, // Hotel medio
            'description' => 'Vista mozzafiato sull\'Arno e Ponte Vecchio. Romantico e raffinato.'
        ]);
    }
}
