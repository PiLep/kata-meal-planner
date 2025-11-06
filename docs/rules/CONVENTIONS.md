# Conventions de Code

## Principes Généraux
- **KISS** : Keep It Simple, Stupid
- **YAGNI** : You Aren't Gonna Need It
- **DRY** : Don't Repeat Yourself (avec discernement)
- **Single Responsibility** : Une classe = une responsabilité

## Nommage

### Classes
- **PascalCase** pour toutes les classes
- Actions : Verbe à l'infinitif + Nom (`CreateMealPlan`, `SwapMeal`)
- DTOs : Nom + `DTO` (`MealPlanDTO`, `RecipeDTO`)
- Services : Nom + `Service` (`RecipeApiService`)
- Models : Nom singulier (`User`, `MealPlan`, `Recipe`)
- Livewire : Nom descriptif (`WeeklyPlanner`, `DailyDigest`)

### Méthodes
- **camelCase**
- Verbes d'action (`execute`, `handle`, `create`, `update`, `delete`)
- Préfixes booléens : `is`, `has`, `can` (`isVegan()`, `hasAllergies()`)

### Variables
- **camelCase**
- Noms explicites (`$mealPlan` plutôt que `$mp`)
- Collections au pluriel (`$meals`, `$recipes`)

### Bases de données
- **snake_case** pour tables et colonnes
- Tables au pluriel (`users`, `meal_plans`)
- Colonnes au singulier (`user_id`, `created_at`)

## Organisation du Code

### Structure DDD
```
Domain/
  {Domaine}/
    Models/        # Eloquent models
    Actions/       # Classes d'actions métier
    Services/      # Services domaine
    DTOs/          # Data Transfer Objects
    Enums/         # Énumérations PHP 8.1+
```

### Actions Pattern
```php
namespace App\Domain\MealPlanning\Actions;

class CreateMealPlan
{
    public function execute(MealPlanDTO $data): MealPlan
    {
        // Logique métier unique et testable
        return MealPlan::create([...]);
    }
}
```

### DTOs
```php
readonly class MealPlanDTO
{
    public function __construct(
        public int $userId,
        public Carbon $startDate,
        public int $mealsPerDay,
    ) {}
}
```

### Enums (PHP 8.1+)
```php
enum DietType: string
{
    case OMNIVORE = 'omnivore';
    case VEGETARIAN = 'vegetarian';
    case VEGAN = 'vegan';
    case PESCATARIAN = 'pescatarian';
}
```

## Livewire Components

### Structure
```php
class WeeklyPlanner extends Component
{
    // Properties publiques (état du composant)
    public MealPlan $mealPlan;

    // Lifecycle hooks
    public function mount(): void {}

    // Actions publiques (appelées depuis la vue)
    public function swapMeal(int $mealId): void
    {
        // 1. Validation
        // 2. Appel Action/Service
        // 3. Update state
        // 4. Dispatch events si nécessaire
    }

    // Computed properties
    public function getMealsProperty(): Collection
    {
        return $this->mealPlan->meals;
    }

    // Render
    public function render(): View
    {
        return view('livewire.home.weekly-planner');
    }
}
```

### Vues Livewire
- Blade avec directives Livewire
- Tailwind CSS utility-first
- Pas de JavaScript complexe (utiliser Alpine.js si nécessaire)

## Tests

### Nommage
- `test_` prefix obligatoire ou méthode `/** @test */`
- Nom descriptif : `test_user_can_create_meal_plan()`
- Pattern : Given/When/Then dans le corps

### Structure
```php
/** @test */
public function user_can_swap_meal_in_meal_plan(): void
{
    // Given (Arrange)
    $user = User::factory()->create();
    $mealPlan = MealPlan::factory()->for($user)->create();

    // When (Act)
    $result = (new SwapMeal())->execute($meal, $newRecipe);

    // Then (Assert)
    $this->assertDatabaseHas('meals', [
        'recipe_id' => $newRecipe->id
    ]);
}
```

### Couverture
- Actions : 100% (logique métier critique)
- Services : 100%
- Livewire : cas principaux
- E2E : user flows critiques

## Formatage

### Laravel Pint
Configuration PSR-12 par défaut
```bash
./vendor/bin/pint
```

### Règles
- Indentation : 4 espaces
- Longueur ligne : 120 caractères max
- Pas de `<?php` tag en fin de fichier
- Un statement par ligne

## Eloquent

### Relations
```php
// Naming explicit
public function mealPlan(): BelongsTo
{
    return $this->belongsTo(MealPlan::class);
}

public function meals(): HasMany
{
    return $this->hasMany(Meal::class);
}
```

### Scopes
```php
public function scopeVegan(Builder $query): void
{
    $query->where('diet_type', DietType::VEGAN);
}

// Usage: Recipe::vegan()->get()
```

### Factories
Une factory par model pour les tests
```php
Recipe::factory()->vegan()->create();
```

## Validation

### Form Requests
```php
class CreateMealPlanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'meals_per_day' => ['required', 'integer', 'min:2', 'max:4'],
        ];
    }
}
```

## API Externe

### HTTP Client
```php
$response = Http::timeout(10)
    ->retry(3, 100)
    ->get('api.example.com/recipes', ['query' => $params]);
```

### Cache
```php
Cache::remember("recipe:{$id}", 3600, fn() =>
    $this->fetchRecipeFromApi($id)
);
```

## Git Commits

### Format
```
type(scope): description

[optional body]
```

Types : `feat`, `fix`, `refactor`, `test`, `docs`, `chore`

Exemples :
- `feat(meal-planning): add swap meal action`
- `fix(recipes): handle API timeout gracefully`
- `test(shopping-list): add unit tests for item toggle`

## Documentation

### PHPDoc
Uniquement si la signature ne suffit pas
```php
/**
 * Generate shopping list from meal plan
 *
 * @throws RecipeNotFoundException
 */
public function execute(MealPlan $plan): ShoppingList
```

### README
Garder concis, pointer vers memory_bank pour détails
