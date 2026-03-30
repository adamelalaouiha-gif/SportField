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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('adresse');
            $table->string('telephone')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->json('sports');
            $table->json('horaires');

            // Clé étrangère : comme on n'utilise pas les conventions,
            // il est plus sûr d'être explicite pour éviter les bugs.
            $table->foreignId('id_admin')
                ->references('id')
                ->on('utilisateurs')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
