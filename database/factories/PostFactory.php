<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_published = fake()->randomElement([true, false]);
        $published_at = $is_published ? now() : null;

        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'excerpt' => fake()->text(150),
            'body' => fake()->text(1000),
            'image_path' => fake()->imageUrl(640, 480, 'animals', true),
            'is_published' => $is_published,
            'category_id' => fake()->numberBetween(1, 5),
            'user_id' => fake()->numberBetween(1, 20),
            'published_at' => $published_at,

        ];
    }
}
