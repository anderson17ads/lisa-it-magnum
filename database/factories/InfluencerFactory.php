<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Influencer>
 */
class InfluencerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::limit(fake()->name(), 45, ''),
            'instagram_user' => Str::limit(fake()->name(), 45, ''),
            'instagram_followers_count' => fake()->numberBetween(1, 100),
        ];
    }
}
