<?php

namespace Domain\MealPlanning\Models;

use Domain\Recipes\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_plan_id',
        'recipe_id',
        'meal_type',
        'date',
        'position',
    ];

    protected $casts = [
        'date' => 'date',
        'position' => 'integer',
    ];

    public function mealPlan(): BelongsTo
    {
        return $this->belongsTo(MealPlan::class);
    }

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('meal_type', $type);
    }
}
