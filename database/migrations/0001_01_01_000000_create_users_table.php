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
        // 1. La table principale des utilisateurs
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();

            // Tes champs personnalisés
            $table->string('nom');
            $table->string('prenom');


            // Le système de rôles pour différencier tes utilisateurs
            $table->enum('role', ['client', 'admin', 'super_admin'])->default('client');

            // Les champs obligatoires pour le système de Laravel
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Ne surtout pas traduire en 'mot_de_passe'
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. La table pour la réinitialisation des mots de passe (Standard Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions est gérée dans 2026_03_20_143236_create_sessions_table.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
        Schema::dropIfExists('password_reset_tokens');
        // Schema::dropIfExists('sessions'); // géré ailleurs
    }
};
