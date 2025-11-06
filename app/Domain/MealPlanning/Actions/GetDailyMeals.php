<?php

namespace Domain\MealPlanning\Actions;

use Domain\MealPlanning\Models\Meal;
use Illuminate\Support\Collection;

class GetDailyMeals
{
    public function execute(int $userId, string $date): Collection
    {
        return Meal::whereHas('mealPlan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with(['recipe', 'mealPlan'])
            ->whereDate('date', $date)
            ->orderBy('position')
            ->get();
    }
}
