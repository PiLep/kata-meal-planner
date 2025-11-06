<?php

namespace Domain\MealPlanning\DTOs;

use Illuminate\Support\Collection;

readonly class DailyMealsDTO
{
    public function __construct(
        public int $userId,
        public string $date,
        public Collection $meals,
    ) {}
}
