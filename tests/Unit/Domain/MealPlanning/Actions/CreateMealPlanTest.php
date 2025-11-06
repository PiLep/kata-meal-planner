<?php

namespace Tests\Unit\Domain\MealPlanning\Actions;

use App\Models\User;
use Domain\MealPlanning\Actions\CreateMealPlan;
use Domain\MealPlanning\Models\MealPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateMealPlanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_meal_plan_for_user(): void
    {
        // Given
        $user = User::factory()->create();
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        // When
        $action = new CreateMealPlan;
        $result = $action->execute($user->id, $startDate, $endDate);

        // Then
        $this->assertInstanceOf(MealPlan::class, $result);
        $this->assertDatabaseHas('meal_plans', [
            'user_id' => $user->id,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);
    }

    /** @test */
    public function it_returns_existing_meal_plan_if_already_exists_for_period(): void
    {
        // Given
        $user = User::factory()->create();
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        $existingPlan = MealPlan::create([
            'user_id' => $user->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        // When
        $action = new CreateMealPlan;
        $result = $action->execute($user->id, $startDate, $endDate);

        // Then
        $this->assertEquals($existingPlan->id, $result->id);
        $this->assertCount(1, MealPlan::all());
    }
}
