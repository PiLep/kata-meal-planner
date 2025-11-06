<?php

namespace Domain\MealPlanning\DTOs;

use Carbon\Carbon;
use Illuminate\Support\Collection;

readonly class WeeklyMealPlanDTO
{
    public function __construct(
        public int $userId,
        public Carbon $startDate,
        public Carbon $endDate,
        public Collection $meals,
    ) {}
}
