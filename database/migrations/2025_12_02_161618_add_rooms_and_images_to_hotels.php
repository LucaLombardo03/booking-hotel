<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Aggiungiamo il numero di stanze alla tabella hotels
        Schema::table('hotels', function (Blueprint $table) {
            $table->integer('total_rooms')->default(1)->after('price'); // Default 1 stanza
        });

        // 2. Creiamo la tabella per le immagini (Relazione 1 a Molti)
        Schema::create('hotel_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('image_path'); // Percorso file (es. uploads/foto.jpg)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            //
        });
    }
};
