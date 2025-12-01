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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // --- NUOVI CAMPI INDIRIZZO ---
            $table->string('city');          // Città (Già c'era, ma fondamentale per i filtri)
            $table->string('street');        // Via
            $table->string('house_number');  // Numero Civico
            $table->string('zip_code');      // CAP
            // -----------------------------
            $table->decimal('tourist_tax', 8, 2)->nullable(); //Tassa di soggiorno
            $table->decimal('price', 8, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
