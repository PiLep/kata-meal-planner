<?php

namespace Database\Seeders;

use App\Models\User;
use Domain\MealPlanning\Enums\MealType;
use Domain\MealPlanning\Models\Meal;
use Domain\MealPlanning\Models\MealPlan;
use Domain\Recipes\Models\Recipe;
use Illuminate\Database\Seeder;

class MealPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample recipes
        $breakfastRecipes = [
            Recipe::create([
                'external_id' => 'sample-1',
                'name' => 'Avocado Toast with Eggs',
                'description' => 'Healthy breakfast with avocado and poached eggs',
                'image_url' => 'https://picsum.photos/400/300?random=1',
                'prep_time' => 5,
                'cook_time' => 10,
                'servings' => 2,
                'ingredients_json' => ['2 slices bread', '1 avocado', '2 eggs'],
                'instructions_json' => ['Toast bread', 'Mash avocado', 'Poach eggs', 'Assemble'],
                'nutrition_json' => ['calories' => 350, 'protein' => 15, 'carbs' => 30],
                'cached_at' => now(),
            ]),
        ];

        $lunchRecipes = [
            Recipe::create([
                'external_id' => 'sample-2',
                'name' => 'Chicken Caesar Salad',
                'description' => 'Classic Caesar salad with grilled chicken',
                'image_url' => 'https://picsum.photos/400/300?random=2',
                'prep_time' => 10,
                'cook_time' => 15,
                'servings' => 2,
                'ingredients_json' => ['Romaine lettuce', 'Chicken breast', 'Caesar dressing', 'Croutons'],
                'instructions_json' => ['Grill chicken', 'Chop lettuce', 'Mix with dressing', 'Add toppings'],
                'nutrition_json' => ['calories' => 400, 'protein' => 30, 'carbs' => 25],
                'cached_at' => now(),
            ]),
        ];

        $dinnerRecipes = [
            Recipe::create([
                'external_id' => 'sample-3',
                'name' => 'Spaghetti Carbonara',
                'description' => 'Classic Italian pasta with bacon and eggs',
                'image_url' => 'https://picsum.photos/400/300?random=3',
                'prep_time' => 10,
                'cook_time' => 20,
                'servings' => 4,
                'ingredients_json' => ['Spaghetti', 'Bacon', 'Eggs', 'Parmesan'],
                'instructions_json' => ['Boil pasta', 'Cook bacon', 'Mix eggs and cheese', 'Combine all'],
                'nutrition_json' => ['calories' => 550, 'protein' => 25, 'carbs' => 60],
                'cached_at' => now(),
            ]),
        ];

        // Create meal plan for default user (ID 1)
        $user = User::first();
        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $mealPlan = MealPlan::create([
            'user_id' => $user->id,
            'start_date' => now()->startOfWeek(),
            'end_date' => now()->endOfWeek(),
        ]);

        // Create meals for today
        Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'recipe_id' => $breakfastRecipes[0]->id,
            'meal_type' => MealType::BREAKFAST->value,
            'date' => now()->toDateString(),
            'position' => 0,
        ]);

        Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'recipe_id' => $lunchRecipes[0]->id,
            'meal_type' => MealType::LUNCH->value,
            'date' => now()->toDateString(),
            'position' => 1,
        ]);

        Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'recipe_id' => $dinnerRecipes[0]->id,
            'meal_type' => MealType::DINNER->value,
            'date' => now()->toDateString(),
            'position' => 2,
        ]);
    }
}
