<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Terrain;
use Illuminate\Database\Eloquent\Factories\Factory;

class TerrainFactory extends Factory
{
    protected $model = Terrain::class;

    public function definition(): array
    {
        $sport = $this->faker->randomElement(['foot', 'basketball', 'tennis', 'padel', 'volleyball']);

        $noms = [
            'foot'       => ['Terrain Principal', 'Terrain B', 'Mini Foot 1', 'Mini Foot 2'],
            'basketball' => ['Court Central', 'Court B', 'Terrain Basket'],
            'tennis'     => ['Court 1', 'Court 2', 'Court Centrale'],
            'padel'      => ['Piste Padel 1', 'Piste Padel 2', 'Court Padel'],
            'volleyball' => ['Terrain Volley 1', 'Terrain Volley 2'],
        ];

        $prix = [
            'foot'       => $this->faker->numberBetween(150, 350),
            'basketball' => $this->faker->numberBetween(80, 200),
            'tennis'     => $this->faker->numberBetween(100, 250),
            'padel'      => $this->faker->numberBetween(120, 300),
            'volleyball' => $this->faker->numberBetween(80, 180),
        ];

        return [
            'nom'        => $this->faker->randomElement($noms[$sport]),
            'description'=> $this->faker->sentence(),
            'type_sport' => $sport,
            'prix_heure' => $prix[$sport],
            'photo'      => null,
            'id_club'    => Club::factory(),
        ];
    }
}
