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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Les informations de date et d'heure
            $table->date('date_reservation');
            $table->time('heure_debut');
            $table->time('heure_fin');

            // Le prix figé au moment de la réservation (8 chiffres maximum, dont 2 après la virgule)
            $table->decimal('montant', 8, 2);

            // L'état global de la réservation
            $table->enum('statut_reservation', ['en_attente', 'terminée', 'non_venue', 'annulée'])->default('en_attente');

            // Le choix du client pour régler sa partie
            $table->enum('methode_paiement', ['en_ligne', 'sur_place']);

            // Le suivi de l'argent avec ton nommage précis
            $table->enum('statut_paiements', ['en_attente', 'paye', 'rembourse'])->default('en_attente');

            // Clés étrangères

            // Le client qui réserve
            $table->foreignId('id_utilisateur')
                ->references('id')
                ->on('utilisateurs')
                ->cascadeOnDelete();

            // Le terrain réservé
            $table->foreignId('id_terrain')
                ->references('id')
                ->on('terrains')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
