<?php

namespace Tests\Unit\Domain\MealPlanning\Actions;

use App\Models\User;
use Domain\MealPlanning\Actions\GetDailyMeals;
use Domain\MealPlanning\Enums\MealType;
use Domain\MealPlanning\Models\Meal;
use Domain\MealPlanning\Models\MealPlan;
use Domain\Recipes\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetDailyMealsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_meals_for_specific_date(): void
    {
        // Given - User with meal plan containing meals for today
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['name' => 'Test Recipe']);

        $mealPlan = MealPlan::create([
            'user_id' => $user->id,
            'start_date' => now()->startOfWeek(),
            'end_date' => now()->endOfWeek(),
        ]);

        Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'recipe_id' => $recipe->id,
            'meal_type' => MealType::BREAKFAST->value,
            'date' => now()->toDateString(),
            'position' => 0,
        ]);

        Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'recipe_id' => $recipe->id,
            'meal_type' => MealType::LUNCH->value,
            'date' => now()->toDateString(),
            'position' => 1,
        ]);

        // When - Execute action
        $action = new GetDailyMeals;
        $result = $action->execute($user->id, now()->toDateString());

        // Then - Assert meals are retrieved with proper eager loading
        $this->assertCount(2, $result);
        $this->assertEquals(MealType::BREAKFAST->value, $result->first()->meal_type);
        $this->assertEquals('Test Recipe', $result->first()->recipe->name);
    }

    /** @test */
    public function it_returns_empty_collection_when_no_meals_found(): void
    {
        // Given - User with no meals for today
        $user = User::factory()->create();

        // When
        $action = new GetDailyMeals;
        $result = $action->execute($user->id, now()->toDateString());

        // Then
        $this->assertCount(0, $result);
    }

    /** @test */
    public function it_returns_meals_ordered_by_position(): void
    {
        // Given
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        $mealPlan = MealPlan::create([
            'user_id' => $user->id,
            'start_date' => now()->startOfWeek(),
            'end_date' => now()->endOfWeek(),
        ]);

        // Create meals in reverse order
        Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'recipe_id' => $recipe->id,
            'meal_type' => MealType::DINNER->value,
            'date' => now()->toDateString(),
            'position' => 2,
        ]);

        Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'recipe_id' => $recipe->id,
            'meal_type' => MealType::BREAKFAST->value,
            'date' => now()->toDateString(),
            'position' => 0,
        ]);

        Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'recipe_id' => $recipe->id,
            'meal_type' => MealType::LUNCH->value,
            'date' => now()->toDateString(),
            'position' => 1,
        ]);

        // When
        $action = new GetDailyMeals;
        $result = $action->execute($user->id, now()->toDateString());

        // Then - Should be ordered by position
        $this->assertEquals(MealType::BREAKFAST->value, $result[0]->meal_type);
        $this->assertEquals(MealType::LUNCH->value, $result[1]->meal_type);
        $this->assertEquals(MealType::DINNER->value, $result[2]->meal_type);
    }
}
