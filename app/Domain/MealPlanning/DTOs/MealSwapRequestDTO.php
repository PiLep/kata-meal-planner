<?php

namespace Domain\MealPlanning\DTOs;

readonly class MealSwapRequestDTO
{
    public function __construct(
        public int $mealId,
        public int $newRecipeId,
        public int $userId,
    ) {}
}
