# Claude AI Context - Meal Planner Project

This file provides Claude AI with essential context about the Meal Planner project to ensure consistent and aligned development assistance.

## Project Overview

**Meal Planner** is a Laravel + Livewire full-stack application helping families solve the universal problem: *"What's for dinner tonight?"*

- **Target audience**: Families seeking simplicity
- **Core value**: Simplicity first - intuitive, no training required
- **Architecture**: Domain-Driven Design (DDD) with Laravel monorepo
- **Development**: Docker with Laravel Sail
- **Deployment**: Laravel Forge with GitHub Actions CI/CD

## Documentation Structure

### Memory Bank (Macro-level)
High-level project knowledge for AI guidance:

- **[docs/memory_bank/PROJECT_BRIEF.md](docs/memory_bank/PROJECT_BRIEF.md)** - Vision, target audience, MVP scope, goals
- **[docs/memory_bank/STACK.md](docs/memory_bank/STACK.md)** - Technical stack (Laravel, Livewire, MySQL, Docker, etc.)
- **[docs/memory_bank/ARCHITECTURE.md](docs/memory_bank/ARCHITECTURE.md)** - DDD structure, principles, testing strategy
- **[docs/memory_bank/ROADMAP.md](docs/memory_bank/ROADMAP.md)** - MVP development plan and milestones

### Rules (Micro-level)
Detailed coding standards and conventions:

- **[docs/rules/CONVENTIONS.md](docs/rules/CONVENTIONS.md)** - Naming, code organization, patterns, testing, git commits

### Issues
Feature specifications with mockups:

- **[docs/issues/issue-1.md](docs/issues/issue-1.md)** - Home Page (Daily Digest + Weekly Planner)
- **[docs/issues/issue-2.md](docs/issues/issue-2.md)** - Settings (Preferences, allergies, exclusions)
- **[docs/issues/issue-3.md](docs/issues/issue-3.md)** - Shopping List (Categories, checkboxes, export)
- **[docs/issues/issue-4.md](docs/issues/issue-4.md)** - Recipe Discovery (Search, filters, cards)

## Key Architectural Decisions

### DDD Organization
```
app/Domain/{DomainName}/
  ├── Models/      # Eloquent models
  ├── Actions/     # Single-responsibility business actions
  ├── Services/    # Domain services coordinating actions
  ├── DTOs/        # Data Transfer Objects
  └── Enums/       # PHP 8.1+ enumerations
```

**Domains**: `MealPlanning`, `Recipes`, `ShoppingList`, `UserPreferences`

### Livewire Strategy
- **Full-page components** (one per page)
- Sub-components for reusability
- Communication via Livewire events
- No complex JavaScript (Alpine.js if needed)

### Testing Approach
- **Unit tests**: Actions, Services, Models (PHPUnit)
- **Component tests**: Livewire interactions
- **E2E tests**: Critical user flows (Laravel Dusk)

## Development Priorities

### MVP Feature Priority
1. **Home Page** (Priority #1) - Daily view (mobile) + Weekly planner (desktop)
2. Settings - Dietary preferences and allergies
3. Shopping List - Auto-generated from meal plans
4. Recipe Discovery - Search and filter recipes

### Technical Phases
1. Foundation - Laravel setup, DB schema, OAuth
2. Core Features - Domains implementation
3. UI Implementation - Livewire components
4. Testing - Unit, Component, E2E
5. Deployment - CI/CD, Forge

## Code Conventions Quick Reference

**Naming**:
- Classes: `PascalCase` (Actions: `CreateMealPlan`, DTOs: `MealPlanDTO`)
- Methods: `camelCase` (Actions: `execute()`, Booleans: `isVegan()`)
- Variables: `camelCase` (explicit names, collections plural)
- Database: `snake_case` (tables plural, columns singular)

**Principles**: KISS, YAGNI, DRY, Single Responsibility

**Formatting**: Laravel Pint (PSR-12), 4 spaces, 120 chars max

## AI Instructions

### When Working on Features
1. **Read documentation first**: Check relevant files in `docs/memory_bank/`, `docs/rules/`, and `docs/issues/`
2. **Follow DDD patterns**: Use Actions for business logic, DTOs for data transfer, Services for coordination
3. **Test everything**: Write unit tests for Actions/Services, component tests for Livewire, E2E for flows
4. **Keep it simple**: Prioritize clarity and simplicity over clever abstractions
5. **Respect conventions**: Follow naming patterns and code organization from `docs/rules/CONVENTIONS.md`

### Domain-Specific Guidelines

**MealPlanning Domain**:
- Actions: `CreateMealPlan`, `SwapMeal`, `UpdateMealPlan`
- Focus on weekly planning logic and meal organization

**Recipes Domain**:
- Service: `RecipeApiService` for external API integration
- Actions: `SearchRecipes`, `FilterRecipes`, `CacheRecipe`
- Cache all API responses (1 hour minimum)

**ShoppingList Domain**:
- Actions: `GenerateShoppingList`, `ToggleItem`, `AddManualItem`
- Auto-sync with meal plans

**UserPreferences Domain**:
- Actions: `UpdatePreferences`, `ManageAllergies`, `ExcludeIngredients`
- Enums: `DietType`, `Allergen`

### Livewire Components

**Structure**:
```php
class ComponentName extends Component
{
    // Public properties (component state)
    public Model $model;

    // Mount (initialization)
    public function mount(): void {}

    // Actions (called from view)
    public function actionName(): void
    {
        // 1. Validate
        // 2. Call Action/Service
        // 3. Update state
        // 4. Dispatch events
    }

    // Computed properties
    public function getDataProperty(): Collection {}

    // Render
    public function render(): View {}
}
```

**Priority Components**:
1. `Home/DailyDigest.php` (mobile)
2. `Home/WeeklyPlanner.php` (desktop)
3. `Settings/PreferencesForm.php`
4. `ShoppingList/ShoppingListManager.php`
5. `Recipes/RecipeDiscovery.php`

### Testing Guidelines

**Unit Tests** (Actions/Services):
```php
/** @test */
public function user_can_create_meal_plan(): void
{
    // Given
    $user = User::factory()->create();
    $dto = new MealPlanDTO(...);

    // When
    $result = (new CreateMealPlan())->execute($dto);

    // Then
    $this->assertInstanceOf(MealPlan::class, $result);
    $this->assertDatabaseHas('meal_plans', [...]);
}
```

**E2E Tests** (Dusk):
- User creates meal plan
- User swaps meal in plan
- User generates shopping list
- User discovers and adds recipe

### Security Checklist
- [ ] Input validation (Form Requests)
- [ ] Auth middleware on protected routes
- [ ] CSRF protection on forms
- [ ] Rate limiting on API endpoints
- [ ] XSS prevention in Livewire
- [ ] SQL injection prevention (Eloquent)

### Performance Checklist
- [ ] Eager load relations (avoid N+1)
- [ ] Cache API responses (Redis, 1 hour)
- [ ] Cache user preferences (1 hour)
- [ ] Cache meal plans (30 minutes)
- [ ] Paginate long lists
- [ ] Add database indexes

## External Resources

- Laravel Documentation: https://laravel.com/docs
- Livewire Documentation: https://livewire.laravel.com/docs
- Tailwind CSS: https://tailwindcss.com/docs
- Laravel Dusk: https://laravel.com/docs/dusk

---

**Note**: Always prioritize simplicity over complexity. The family users should never feel overwhelmed by the interface or workflows.
