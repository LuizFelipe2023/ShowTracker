<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShowFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),

            'description' => fake()->paragraph(),

            'release_date' => fake()->date(),

            'rating' => fake()->randomFloat(1, 1, 10),

            'status' => fake()->randomElement([
                'to watch',
                'watching',
                'finished'
            ]),

            'cover_image' => fake()->imageUrl(640, 480, 'tv'),
        ];
    }
}