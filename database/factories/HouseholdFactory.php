<?php

namespace Database\Factories;

use App\Models\Purok;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseholdFactory extends Factory
{
    public function definition(): array
    {
        return [
            'household_code' => 'HH' . str_pad(fake()->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'purok_id'       => Purok::inRandomOrder()->first()->id,
            'head_of_family' => fake()->name(),
            'family_size'    => fake()->numberBetween(1, 10),
            'voter_count'    => fake()->numberBetween(1, 8),
        ];
    }
}