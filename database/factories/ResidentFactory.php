<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purok;
use App\Models\Household;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'     => fake()->firstName(),
            'last_name'      => fake()->lastName(),
            'age'            => fake()->numberBetween(1, 90),
            'sex'            => fake()->randomElement(['Male', 'Female']),
            'birthdate'      => fake()->date('Y-m-d', '2005-01-01'),
            'civil_status'   => fake()->randomElement(['Single', 'Married', 'Widowed', 'Separated']),
            'address'        => fake()->address(),
            'contact_number' => fake()->phoneNumber(),
            'status'         => fake()->randomElement(['Active', 'Deceased', 'Transferred']),
            'purok_id'       => Purok::inRandomOrder()->first()->id,
            'household_id'   => Household::inRandomOrder()->first()->id,
        ];
    }
}
