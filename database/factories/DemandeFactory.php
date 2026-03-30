<?php

namespace Database\Factories;

use App\Models\Demande;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class DemandeFactory extends Factory
{
    protected $model = Demande::class;

    public function definition(): array
    {
        $sports = $this->faker->randomElements(['foot', 'basketball', 'tennis', 'padel', 'volleyball'],
            $this->faker->numberBetween(1, 3));

        $horaires = [];
        foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour) {
            $horaires[$jour] = '08:00 - 22:00';
        }
        $horaires['Dimanche'] = '10:00 - 18:00';

        return [
            'prenom_responsable'       => $this->faker->firstName(),
            'nom_responsable'          => $this->faker->lastName(),
            'email_responsable'        => $this->faker->unique()->safeEmail(),
            'mot_de_passe_responsable' => Hash::make('password123'),
            'nom_club'                 => 'Club ' . $this->faker->company(),
            'description'              => $this->faker->paragraph(2),
            'telephone_club'           => '06' . $this->faker->numerify('########'),
            'adresse'                  => $this->faker->streetAddress() . ', Maroc',
            'sports'                   => $sports,
            'horaires'                 => $horaires,
            'photos'                   => null,
            'statut_demande'           => 'en_attente',
        ];
    }

    public function approuvee(): static
    {
        return $this->state(['statut_demande' => 'approuvee']);
    }

    public function rejetee(): static
    {
        return $this->state(['statut_demande' => 'rejetee']);
    }
}
