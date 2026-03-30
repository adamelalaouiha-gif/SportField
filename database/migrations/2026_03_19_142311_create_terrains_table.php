<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();

            $table->string('nom'); // Ex: "Terrain 1", "Court Central"
            $table->string('description');

            // On limite strictement le type de sport aux valeurs que tu as définies
            $table->enum('type_sport', ['foot', 'basketball', 'tennis', 'padel', 'volleyball']);



            // Le tarif standard du terrain
            $table->decimal('prix_heure', 8, 2);
            $table->string('photo')->nullable();

            // Clé étrangère : relie ce terrain au club auquel il appartient
            $table->foreignId('id_club')
                ->references('id')
                ->on('clubs')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terrains');
    }
};
