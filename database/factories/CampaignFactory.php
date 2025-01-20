<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Influencer>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'budget' => fake()->numberBetween(100, 1000),
            'description' => fake()->text(50),
            'start_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'end_date' => fake()->dateTimeBetween('now', '+2 month')->format('Y-m-d'),
        ];
    }
}
