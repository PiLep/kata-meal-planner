# Architecture

## Global Approach
**Laravel Monorepo with Domain-Driven Design (DDD)**

Full-stack Laravel + Livewire application organized by business domains rather than technical layers.

## DDD Structure

```
app/
├── Domain/                    # Business core
│   ├── MealPlanning/         # Domain: Meal planning
│   │   ├── Models/           # Eloquent models
│   │   ├── Actions/          # Business actions (CreateMealPlan, SwapMeal)
│   │   ├── Services/         # Domain services
│   │   ├── DTOs/             # Data Transfer Objects
│   │   └── Enums/            # Enumerations (MealType, DietType)
│   │
│   ├── Recipes/              # Domain: Recipes
│   │   ├── Models/
│   │   ├── Actions/          # SearchRecipes, FilterRecipes
│   │   ├── Services/         # RecipeApiService
│   │   └── DTOs/
│   │
│   ├── ShoppingList/         # Domain: Shopping list
│   │   ├── Models/
│   │   ├── Actions/          # GenerateShoppingList, ToggleItem
│   │   └── Services/
│   │
│   └── UserPreferences/      # Domain: User preferences
│       ├── Models/
│       ├── Actions/          # UpdatePreferences
│       └── Enums/            # DietaryPreference, Allergen
│
├── Application/              # Application layer
│   └── Livewire/             # Full-page Livewire components
│       ├── Home/
│       │   ├── DailyDigest.php        # Mobile
│       │   └── WeeklyPlanner.php      # Desktop
│       ├── Settings/
│       │   └── PreferencesForm.php
│       ├── ShoppingList/
│       │   └── ShoppingListManager.php
│       └── Recipes/
│           └── RecipeDiscovery.php
│
└── Infrastructure/           # Infrastructure layer
    ├── Repositories/         # Repository implementations
    ├── ExternalAPIs/         # External API clients
    └── Cache/                # Caching strategies
```

## Applied DDD Principles

### 1. Bounded Contexts
Each domain (`MealPlanning`, `Recipes`, `ShoppingList`, `UserPreferences`) is a bounded context with its own ubiquitous language.

### 2. Actions (Single Responsibility)
One class = one business action
```php
// Example
CreateMealPlan::execute(MealPlanDTO $data): MealPlan
SwapMeal::execute(Meal $meal, Recipe $newRecipe): void
GenerateShoppingList::execute(MealPlan $plan): ShoppingList
```

### 3. DTOs (Data Transfer Objects)
Data transfer between layers without business logic
```php
class MealPlanDTO {
    public function __construct(
        public readonly int $userId,
        public readonly Carbon $startDate,
        public readonly int $mealsPerDay,
        public readonly array $dietaryPreferences
    ) {}
}
```

### 4. Services
Complex business logic coordinating multiple actions
```php
// RecipeApiService: external API interaction
// MealPlannerService: meal plan creation coordination
```

## Livewire Components

### Strategy: Full-Page Components
- Each page = 1 main Livewire component
- Sub-components possible for reusability (cards, modals)
- Local state management in component
- Communication via Livewire events

### Typical structure
```php
class WeeklyPlanner extends Component
{
    public MealPlan $mealPlan;
    public Collection $meals;

    public function mount(): void
    {
        $this->loadMealPlan();
    }

    public function swapMeal(int $mealId): void
    {
        // Call Action
        SwapMeal::execute(...);
        $this->dispatch('meal-swapped');
    }

    public function render(): View
    {
        return view('livewire.home.weekly-planner');
    }
}
```

## Database

### MySQL Relational Model
Main tables:
- `users` (OAuth users)
- `user_preferences` (dietary, allergies, exclusions)
- `meal_plans` (weekly plans)
- `meals` (individual meals in plan)
- `recipes` (cached from API)
- `shopping_lists`
- `shopping_list_items`

### Migrations
Versioned and executed via Laravel migrations

## Testing

### Unit Tests (PHPUnit)
- Actions (CreateMealPlan, SwapMeal, etc.)
- Services (RecipeApiService, etc.)
- Models (relations, scopes, etc.)

### Component Tests (Livewire)
```php
Livewire::test(WeeklyPlanner::class)
    ->call('swapMeal', 1)
    ->assertDispatched('meal-swapped');
```

### E2E Tests (Dusk)
- Complete user flows
- Multi-page interactions
- Responsive tests (mobile/desktop)

## Security
- Auth middleware on all routes except login/register
- CSRF protection (Laravel default)
- Rate limiting on API calls
- Input validation (Form Requests)
- SQL injection protection (Eloquent)

## Performance
- Redis cache for:
  - API recipes
  - User preferences
  - Current meal plans
- Eager loading of relations (N+1 queries)
- Pagination for long lists
- Lazy loading of images

## Responsive Design
- Tailwind CSS with standard breakpoints
- Mobile-first adaptive components
- Device detection for conditional logic if needed
