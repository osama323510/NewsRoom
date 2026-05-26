<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'user_id'    => User::where('role', 'writer')->inRandomOrder()->first()->id,
            'title'      => $this->faker->unique()->sentence(6),
            'content'    => $this->faker->paragraphs(4, true), 
            'status'     => $this->faker->randomElement(['published', 'draft', 'archived']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
