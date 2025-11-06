<?php

namespace Domain\MealPlanning\Actions;

use Carbon\Carbon;
use Domain\MealPlanning\Models\MealPlan;

class CreateMealPlan
{
    public function execute(int $userId, Carbon $startDate, Carbon $endDate): MealPlan
    {
        // Check if meal plan already exists for this period
        $existingPlan = MealPlan::where('user_id', $userId)
            ->where('start_date', $startDate->toDateString())
            ->where('end_date', $endDate->toDateString())
            ->first();

        if ($existingPlan) {
            return $existingPlan;
        }

        // Create new meal plan
        return MealPlan::create([
            'user_id' => $userId,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }
}
