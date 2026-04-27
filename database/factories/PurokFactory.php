<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purok>
 */
class PurokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $number = 1;
        return [
            'name'        => 'Purok ' . str_pad($number++, 2, '0', STR_PAD_LEFT),
            'leader_name' => fake()->name(),
        ];
    }
}
