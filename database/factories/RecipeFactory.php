<?php

namespace Database\Factories;

use Domain\Recipes\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Recipes\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => fake()->unique()->uuid(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'image_url' => fake()->imageUrl(640, 480, 'food'),
            'prep_time' => fake()->numberBetween(5, 30),
            'cook_time' => fake()->numberBetween(10, 60),
            'servings' => fake()->numberBetween(2, 6),
            'ingredients_json' => [
                ['name' => 'Ingredient 1', 'amount' => '1 cup'],
                ['name' => 'Ingredient 2', 'amount' => '2 tbsp'],
            ],
            'instructions_json' => [
                ['step' => 1, 'instruction' => 'First step'],
                ['step' => 2, 'instruction' => 'Second step'],
            ],
            'nutrition_json' => [
                'calories' => fake()->numberBetween(100, 500),
                'protein' => fake()->numberBetween(10, 30),
                'carbs' => fake()->numberBetween(20, 50),
            ],
            'cached_at' => now(),
        ];
    }
}
