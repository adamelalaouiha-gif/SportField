<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Terrain;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $heureDebut = $this->faker->numberBetween(8, 20);
        $heureFin   = $heureDebut + $this->faker->randomElement([1, 2]);
        $terrain    = Terrain::inRandomOrder()->first();
        $montant    = $terrain ? ($heureFin - $heureDebut) * $terrain->prix_heure : 200;

        return [
            'date_reservation'  => $this->faker->dateTimeBetween('-2 months', '+1 month')->format('Y-m-d'),
            'heure_debut'       => sprintf('%02d:00:00', $heureDebut),
            'heure_fin'         => sprintf('%02d:00:00', $heureFin),
            'montant'           => $montant,
            'statut_reservation'=> $this->faker->randomElement(['en_attente', 'terminée', 'annulée', 'non_venue']),
            'methode_paiement'  => $this->faker->randomElement(['en_ligne', 'sur_place']),
            'statut_paiements'  => $this->faker->randomElement(['en_attente', 'paye']),
            'id_utilisateur'    => User::where('role', 'client')->inRandomOrder()->first()?->id ?? User::factory(),
            'id_terrain'        => $terrain?->id ?? Terrain::factory(),
        ];
    }
}
