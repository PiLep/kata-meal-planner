<?php

namespace Domain\Recipes\Models;

use Domain\MealPlanning\Models\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'description',
        'image_url',
        'prep_time',
        'cook_time',
        'servings',
        'ingredients_json',
        'instructions_json',
        'nutrition_json',
        'cached_at',
    ];

    protected $casts = [
        'prep_time' => 'integer',
        'cook_time' => 'integer',
        'servings' => 'integer',
        'ingredients_json' => 'array',
        'instructions_json' => 'array',
        'nutrition_json' => 'array',
        'cached_at' => 'datetime',
    ];

    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }
}
