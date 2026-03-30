<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();

            // 1. Infos du futur responsable (au lieu de la clé étrangère)
            $table->string('prenom_responsable');
            $table->string('nom_responsable');
            $table->string('email_responsable');
            $table->string('mot_de_passe_responsable'); // On le stockera haché (sécurisé)

            // 2. Informations de base du club
            $table->string('nom_club');
            $table->text('description');
            $table->string('telephone_club');
            $table->string('adresse');

            // 3. Données complexes (JSON)
            $table->json('sports');
            $table->json('horaires');



            // 5. Fichiers / Photos
            $table->string('photos')->nullable();

            // 6. Suivi par l'administrateur
            $table->enum('statut_demande', ['en_attente', 'approuvee', 'rejetee'])->default('en_attente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
