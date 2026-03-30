<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nom'               => $this->faker->lastName(),
            'prenom'            => $this->faker->firstName(),
            'email'             => $this->faker->unique()->safeEmail(),
            'password'          => Hash::make('password123'),
            'role'              => 'client',
            'email_verified_at' => now(),
        ];
    }

    public function admin(): static
    {
        return $this->state(['role' => 'admin']);
    }

    public function nonVerifie(): static
    {
        return $this->state(['email_verified_at' => null]);
    }
}
