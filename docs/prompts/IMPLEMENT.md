# Implementation Guide - Code Execution with Review Loops

This document provides instructions for implementing code based on technical plans created by the Lead Developer, with continuous review loops and regular commits.

---

## Overview

This guide follows a **Test-Driven Development (TDD)** approach with continuous quality checks:

1. **Read the Plan** - Understand the technical task
2. **Implement** - Write code following DDD patterns
3. **Test** - Write and run tests
4. **Review** - Self-review for quality, security, performance
5. **Commit** - Create atomic commits
6. **Repeat** - Continue until task complete

---

## Pre-Implementation Checklist

Before writing any code:

- [ ] Read the complete technical plan in `docs/tasks/`
- [ ] Review relevant domain documentation in `docs/memory_bank/`
- [ ] Check conventions in `docs/rules/CONVENTIONS.md`
- [ ] Understand the domain context (MealPlanning, Recipes, ShoppingList, UserPreferences)
- [ ] Identify all files that need to be created or modified
- [ ] Create a TodoWrite checklist with all implementation steps

---

## Implementation Workflow

### Step 1: Understand the Task

**Read the Technical Plan:**
```bash
# Technical plans are located in docs/tasks/
# Example: docs/tasks/TASK-2025-11-06-swap-meal.md
```

**Extract Key Information:**
- What domain does this belong to?
- What Actions/Services/DTOs are needed?
- What Livewire components are involved?
- What database changes are required?
- What tests need to be written?

### Step 2: Set Up Todo Tracking

Use `TodoWrite` to create a checklist based on the technical plan:

**Example:**
```
1. Database Layer
   - Create migration for new columns
   - Update model relationships

2. Domain Layer
   - Create DTO
   - Implement Action
   - Add Service method if needed

3. Application Layer
   - Create/Update Livewire component
   - Add component methods
   - Create Blade view

4. Validation
   - Create Form Request
   - Add validation rules

5. Testing
   - Write unit tests for Action
   - Write component tests
   - Write E2E tests if needed

6. Review & Polish
   - Run Laravel Pint
   - Check security
   - Check performance
   - Commit changes
```

### Step 3: Implement (TDD Approach)

**Follow Red-Green-Refactor:**

1. **Red** - Write a failing test first
2. **Green** - Write minimal code to make it pass
3. **Refactor** - Clean up the code

**Example for CreateMealPlan Action:**

```php
// 1. RED: Write failing test first
// tests/Unit/Domain/MealPlanning/Actions/CreateMealPlanTest.php

/** @test */
public function it_creates_meal_plan_with_valid_data(): void
{
    // Given
    $user = User::factory()->create();
    $dto = new MealPlanDTO(
        userId: $user->id,
        startDate: now(),
        endDate: now()->addDays(6),
    );

    // When
    $result = (new CreateMealPlan())->execute($dto);

    // Then
    $this->assertInstanceOf(MealPlan::class, $result);
    $this->assertDatabaseHas('meal_plans', [
        'user_id' => $user->id,
    ]);
}
```

```php
// 2. GREEN: Implement minimal code to pass
// app/Domain/MealPlanning/Actions/CreateMealPlan.php

class CreateMealPlan
{
    public function execute(MealPlanDTO $dto): MealPlan
    {
        return MealPlan::create([
            'user_id' => $dto->userId,
            'start_date' => $dto->startDate,
            'end_date' => $dto->endDate,
        ]);
    }
}
```

```php
// 3. REFACTOR: Add validation, error handling, etc.
class CreateMealPlan
{
    public function execute(MealPlanDTO $dto): MealPlan
    {
        // Validate date range
        if ($dto->endDate->lt($dto->startDate)) {
            throw new InvalidArgumentException('End date must be after start date');
        }

        // Create meal plan
        $mealPlan = MealPlan::create([
            'user_id' => $dto->userId,
            'start_date' => $dto->startDate,
            'end_date' => $dto->endDate,
        ]);

        // Clear user's meal plan cache
        Cache::tags(['user', $dto->userId, 'meal_plans'])->flush();

        return $mealPlan;
    }
}
```

### Step 4: Continuous Review Loop

**After Each Component Implementation:**

Run this checklist before moving to the next component:

#### 4.1 Code Quality Check

```bash
# Run Laravel Pint
./vendor/bin/pint

# Check the modified files
git diff
```

**Manual Review:**
- [ ] Naming follows conventions (PascalCase, camelCase, snake_case)
- [ ] Single Responsibility Principle respected
- [ ] No code duplication (DRY)
- [ ] No unnecessary complexity (KISS, YAGNI)
- [ ] PHPDoc added where needed
- [ ] No debug code or commented-out code

#### 4.2 Security Check

- [ ] **Authentication**: Protected routes have auth middleware
- [ ] **Authorization**: Users can only access their own data
- [ ] **Validation**: All inputs validated (Form Requests)
- [ ] **CSRF**: Forms have CSRF protection
- [ ] **XSS**: Blade templates use `{{ }}` not `{!! !!}`
- [ ] **SQL Injection**: Using Eloquent (no raw queries)
- [ ] **Rate Limiting**: API endpoints have rate limits

**Example Authorization Check:**
```php
// In Livewire component
public function swapMeal(int $mealId, int $recipeId): void
{
    $meal = Meal::findOrFail($mealId);

    // IMPORTANT: Check authorization
    if ($meal->mealPlan->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    // Proceed with swap...
}
```

#### 4.3 Performance Check

- [ ] **N+1 Queries**: Use eager loading
- [ ] **Caching**: Frequently accessed data is cached
- [ ] **Indexes**: Database columns have proper indexes
- [ ] **Pagination**: Long lists are paginated

**Example N+1 Prevention:**
```php
// L BAD: N+1 query problem
$mealPlans = MealPlan::where('user_id', $userId)->get();
foreach ($mealPlans as $plan) {
    echo $plan->meals->count(); // Queries meals for each plan
}

//  GOOD: Eager loading
$mealPlans = MealPlan::where('user_id', $userId)
    ->with('meals') // Loads all meals in one query
    ->get();
```

#### 4.4 Testing Check

```bash
# Run tests
php artisan test

# Run specific test class
php artisan test --filter=CreateMealPlanTest

# Run with coverage (optional)
php artisan test --coverage
```

**Test Coverage Requirements:**
- [ ] Unit tests for all Actions (100% coverage goal)
- [ ] Unit tests for Services
- [ ] Component tests for Livewire components
- [ ] E2E tests for critical user flows

### Step 5: Commit Strategy

**Commit after each logical unit of work:**

#### Commit Guidelines

1. **Atomic Commits**: Each commit should be a complete, working change
2. **Meaningful Messages**: Clear description of what and why
3. **Convention**: Follow the project commit message format

**Commit Message Format:**
```
<type>: <short description>

<longer description if needed>

> Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `refactor`: Code refactoring
- `test`: Adding tests
- `docs`: Documentation changes
- `perf`: Performance improvements
- `style`: Code style changes (formatting)

**Example Commits for "Create Meal Plan" Feature:**

```bash
# Commit 1: Database layer
git add database/migrations/*meal_plans*.php
git add app/Domain/MealPlanning/Models/MealPlan.php
git commit -m "feat: add MealPlan model and migration

Create meal_plans table with user_id, start_date, end_date columns.
Add MealPlan Eloquent model with relationships to User and Meals.

> Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"

# Commit 2: Domain layer
git add app/Domain/MealPlanning/DTOs/MealPlanDTO.php
git add app/Domain/MealPlanning/Actions/CreateMealPlan.php
git commit -m "feat: implement CreateMealPlan action

Add MealPlanDTO for type-safe data transfer.
Implement CreateMealPlan action with validation and caching.

> Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"

# Commit 3: Tests
git add tests/Unit/Domain/MealPlanning/Actions/CreateMealPlanTest.php
git commit -m "test: add unit tests for CreateMealPlan action

Test cases:
- Create meal plan with valid data
- Reject invalid date range
- Cache invalidation after creation

> Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"

# Commit 4: Livewire component
git add app/Livewire/Home/WeeklyPlanner.php
git add resources/views/livewire/home/weekly-planner.blade.php
git commit -m "feat: add WeeklyPlanner Livewire component

Implement weekly meal plan view with create functionality.
Add Tailwind CSS styling for responsive design.

> Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"
```

**When to Commit:**
-  After implementing and testing a domain Action
-  After implementing and testing a Livewire component
-  After writing a batch of related tests
-  After completing a review phase
- L Don't commit broken/untested code
- L Don't commit debug code or temp files

### Step 6: Iteration Loop

**Repeat Steps 3-5 for each component:**

```
1. Write failing test (RED)
   “
2. Implement minimal code (GREEN)
   “
3. Refactor & improve (REFACTOR)
   “
4. Run review checklist (Quality, Security, Performance)
   “
5. Commit changes
   “
6. Mark todo as completed
   “
7. Move to next component
```

**Example Iteration for "Swap Meal" Feature:**

**Iteration 1: SwapMeal Action**
- Write test for SwapMeal action
- Implement action
- Run review checklist
- Commit: "feat: implement SwapMeal action"
- Mark todo complete

**Iteration 2: Livewire Integration**
- Write component test
- Add swapMeal() method to WeeklyPlanner
- Run review checklist
- Commit: "feat: add meal swap to WeeklyPlanner component"
- Mark todo complete

**Iteration 3: UI**
- Update Blade template
- Add swap button and modal
- Test in browser
- Commit: "feat: add swap meal UI to weekly planner"
- Mark todo complete

**Iteration 4: E2E Test**
- Write Dusk test for swap flow
- Run E2E test
- Commit: "test: add E2E test for meal swap"
- Mark todo complete

---

## Code Review Self-Checklist

Before considering a task complete, verify:

### Architecture & Design
- [ ] Code follows DDD structure (correct domain placement)
- [ ] Actions have single responsibility
- [ ] Services coordinate multiple actions if needed
- [ ] DTOs used for data transfer
- [ ] Enums used for fixed value sets

### Code Quality
- [ ] Naming conventions followed
- [ ] No code duplication
- [ ] No unnecessary complexity
- [ ] PHPDoc added where helpful
- [ ] Laravel Pint formatting applied

### Security
- [ ] Authentication checks present
- [ ] Authorization enforced (user owns data)
- [ ] Input validation complete
- [ ] CSRF protection enabled
- [ ] XSS prevention (proper Blade escaping)
- [ ] No SQL injection vulnerabilities

### Performance
- [ ] No N+1 queries (eager loading used)
- [ ] Appropriate caching implemented
- [ ] Database indexes added
- [ ] Pagination for large datasets

### Testing
- [ ] Unit tests for all Actions/Services
- [ ] Component tests for Livewire
- [ ] E2E tests for critical flows
- [ ] All tests passing
- [ ] Edge cases covered

### Documentation
- [ ] Complex logic documented
- [ ] Architectural decisions noted
- [ ] ROADMAP.md updated if milestone reached

---

## Common Patterns & Solutions

### Pattern 1: Domain Action Structure

```php
namespace App\Domain\{DomainName}\Actions;

class ActionName
{
    public function execute(DTO $dto): Model
    {
        // 1. Validate business rules
        $this->validate($dto);

        // 2. Perform main operation
        $result = $this->performOperation($dto);

        // 3. Side effects (cache, events, etc.)
        $this->handleSideEffects($result);

        // 4. Return result
        return $result;
    }

    private function validate(DTO $dto): void
    {
        // Business validation logic
    }

    private function performOperation(DTO $dto): Model
    {
        // Main business logic
    }

    private function handleSideEffects(Model $result): void
    {
        // Cache invalidation, event dispatch, etc.
    }
}
```

### Pattern 2: Livewire Component Structure

```php
namespace App\Livewire\{Feature};

use Livewire\Component;

class ComponentName extends Component
{
    // Public properties (component state)
    public $propertyName;

    // Validation rules
    protected $rules = [
        'propertyName' => 'required|string',
    ];

    // Initialization
    public function mount(): void
    {
        // Initialize component state
    }

    // User actions
    public function actionName(): void
    {
        // 1. Validate
        $this->validate();

        // 2. Call domain action
        $result = (new DomainAction())->execute($dto);

        // 3. Update state
        $this->propertyName = $result;

        // 4. Dispatch events
        $this->dispatch('action-completed');

        // 5. User feedback
        session()->flash('success', 'Operation completed');
    }

    // Computed properties
    public function getDataProperty(): Collection
    {
        return $this->getData();
    }

    // Render
    public function render(): View
    {
        return view('livewire.feature.component-name');
    }
}
```

### Pattern 3: Test Structure

```php
namespace Tests\Unit\Domain\{DomainName}\Actions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActionNameTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_performs_expected_operation_with_valid_data(): void
    {
        // Given (Arrange)
        $user = User::factory()->create();
        $dto = new DTO(...);

        // When (Act)
        $result = (new ActionName())->execute($dto);

        // Then (Assert)
        $this->assertInstanceOf(Model::class, $result);
        $this->assertDatabaseHas('table_name', [...]);
    }

    /** @test */
    public function it_throws_exception_with_invalid_data(): void
    {
        // Given
        $dto = new DTO(...); // Invalid data

        // Then
        $this->expectException(ExceptionClass::class);

        // When
        (new ActionName())->execute($dto);
    }
}
```

---

## Troubleshooting

### Issue: Tests Failing After Implementation

**Diagnosis:**
```bash
# Run tests with detailed output
php artisan test --filter=FailingTest --verbose

# Check for database state issues
php artisan migrate:fresh
php artisan test
```

**Common Causes:**
- Missing database migration
- Incorrect relationships
- Cache not cleared
- Authorization failing

### Issue: N+1 Query Detected

**Diagnosis:**
```bash
# Install Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev

# Check query count in browser
```

**Solution:**
```php
// Use eager loading
Model::with(['relation1', 'relation2'])->get();

// Or lazy eager loading
$models = Model::all();
$models->load('relation');
```

### Issue: Code Style Violations

**Solution:**
```bash
# Run Laravel Pint
./vendor/bin/pint

# Check specific files
./vendor/bin/pint app/Domain/MealPlanning/
```

---

## Final Checklist Before Task Completion

- [ ] All todos marked as completed
- [ ] All tests passing (`php artisan test`)
- [ ] Code formatted (`./vendor/bin/pint`)
- [ ] Security checklist verified
- [ ] Performance checklist verified
- [ ] All changes committed
- [ ] Git status clean (`git status`)
- [ ] Documentation updated if needed
- [ ] Ready for code review (if applicable)

---

## Integration with Project Tools

### TodoWrite Tool
Track progress in real-time:
```
 Implement SwapMeal action
 Write unit tests
 Add Livewire integration
```

### Laravel Sail
Development environment:
```bash
# Run tests
./vendor/bin/sail artisan test

# Run Pint
./vendor/bin/sail exec laravel.test ./vendor/bin/pint
```

### Git
Version control:
```bash
# Stage changes
git add <files>

# Commit with message
git commit -m "feat: implement feature

> Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"

# View status
git status
```

---

## Remember

1. **Test-Driven Development**: Write tests first, then implementation
2. **Continuous Review**: Check quality after each component
3. **Atomic Commits**: Commit logical units of work
4. **Security First**: Always validate and authorize
5. **Performance Aware**: Eager load, cache, index
6. **Keep It Simple**: Follow KISS, YAGNI, DRY principles
7. **Document Decisions**: Explain the "why" not just the "what"

**Goal**: Ship working, tested, secure, performant code incrementally.
