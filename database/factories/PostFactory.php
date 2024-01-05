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
        return [
            'slug' => $this->faker->slug,

            'title' => $this->faker->title,
            'content' => $this->faker->text,
            'is_published' => $this->faker->boolean,

            'likes' => $this->faker->numberBetween(0, 1000),

            'user_id' => null,
        ];
    }
}
