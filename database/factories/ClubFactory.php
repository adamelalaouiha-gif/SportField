<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    protected $model = Club::class;

    private array $nomsClubs = [
        'Complex Sportif Al Amal', 'Arena Sports Kenitra', 'Club Elite Rabat',
        'Centre Sportif Atlas', 'Stadium Pro Casablanca', 'Sport City Fes',
        'Complex Mohammed V', 'Arena Marjane Sports', 'Club Champion Salé',
        'Sport Arena Temara',
    ];

    private array $sportsDisponibles = ['foot', 'basketball', 'tennis', 'padel', 'volleyball'];

    private array $villes = ['Kénitra', 'Rabat', 'Casablanca', 'Fès', 'Salé', 'Témara', 'Marrakech'];

    public function definition(): array
    {
        $sports = $this->faker->randomElements($this->sportsDisponibles, $this->faker->numberBetween(1, 4));
        $ville  = $this->faker->randomElement($this->villes);

        $horaires = [];
        $jours    = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        foreach ($jours as $jour) {
            if ($jour !== 'Dimanche') {
                $horaires[$jour] = '08:00 - 22:00';
            } else {
                $horaires[$jour] = '09:00 - 18:00';
            }
        }

        return [
            'nom'         => $this->faker->randomElement($this->nomsClubs) . ' ' . $this->faker->numberBetween(1, 9),
            'adresse'     => $this->faker->streetAddress() . ', ' . $ville,
            'telephone'   => '0' . $this->faker->randomElement(['6', '7']) . $this->faker->numerify('########'),
            'description' => $this->faker->paragraph(3),
            'photo'       => null,
            'sports'      => $sports,
            'horaires'    => $horaires,
            'id_admin'    => User::factory()->admin(),
        ];
    }
}
