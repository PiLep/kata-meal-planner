You are implementing a feature following Test-Driven Development (TDD) with continuous review loops and atomic commits.

## Your Task

1. **Read the implementation guide**: Check [docs/prompts/IMPLEMENT.md](docs/prompts/IMPLEMENT.md) for the complete workflow
2. **Identify the task**: Ask user which technical plan to implement (from `docs/tasks/`)
3. **Execute TDD cycle**: Test → Implement → Review → Commit → Repeat

## Implementation Workflow

### Step 1: Read the Technical Plan

Ask the user which task to implement:
- Look in `docs/tasks/` for technical plans created by Lead Developer
- Example: `docs/tasks/TASK-2025-11-06-swap-meal.md`

### Step 2: Create Todo Checklist

Use **TodoWrite** to create a detailed checklist based on the plan:

```
1. Database Layer
   - Create/update migrations
   - Update model relationships

2. Domain Layer (TDD)
   - Write test for DTO
   - Create DTO
   - Write test for Action
   - Implement Action
   - Write test for Service (if needed)
   - Implement Service

3. Application Layer (TDD)
   - Write component test
   - Create/update Livewire component
   - Update Blade view

4. Validation
   - Create Form Request
   - Add validation rules

5. Review & Commit
   - Run Laravel Pint
   - Security check
   - Performance check
   - Commit changes
```

### Step 3: TDD Cycle (Red-Green-Refactor)

For each component, follow this cycle:

**RED**: Write failing test first
```php
/** @test */
public function it_performs_expected_operation(): void
{
    // Given
    $user = User::factory()->create();

    // When
    $result = (new Action())->execute($dto);

    // Then
    $this->assertInstanceOf(Model::class, $result);
}
```

**GREEN**: Write minimal code to pass
```php
class Action
{
    public function execute(DTO $dto): Model
    {
        return Model::create([...]);
    }
}
```

**REFACTOR**: Improve code quality
- Add validation
- Add error handling
- Add caching
- Clean up code

### Step 4: Continuous Review Loop

After implementing each component, run this checklist:

#### Code Quality
- [ ] Run `./vendor/bin/pint`
- [ ] Check naming conventions (PascalCase, camelCase, snake_case)
- [ ] Verify Single Responsibility Principle
- [ ] Remove code duplication (DRY)
- [ ] Apply KISS and YAGNI principles
- [ ] Remove debug code

#### Security Check
- [ ] Authentication: Routes have auth middleware
- [ ] Authorization: User can only access their own data
- [ ] Validation: All inputs validated with Form Requests
- [ ] CSRF: Forms have CSRF protection
- [ ] XSS: Using `{{ }}` not `{!! !!}` in Blade
- [ ] SQL Injection: Using Eloquent, no raw queries
- [ ] Rate Limiting: API endpoints protected

#### Performance Check
- [ ] No N+1 queries (use eager loading)
- [ ] Appropriate caching strategy
- [ ] Database indexes added
- [ ] Pagination for long lists

#### Testing Check
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TestClassName
```

- [ ] Unit tests for Actions/Services
- [ ] Component tests for Livewire
- [ ] E2E tests for critical flows (Dusk)
- [ ] All tests passing
- [ ] Edge cases covered

### Step 5: Atomic Commits

Commit after each logical unit of work:

**Commit Format:**
```
<type>: <short description>

<optional longer description>

🤖 Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `refactor`: Code refactoring
- `test`: Adding tests
- `perf`: Performance improvements
- `style`: Formatting changes

**Example Commits:**

```bash
# Commit 1: Domain Action
git add app/Domain/MealPlanning/Actions/CreateMealPlan.php
git add app/Domain/MealPlanning/DTOs/MealPlanDTO.php
git commit -m "feat: implement CreateMealPlan action

Add MealPlanDTO for type-safe data transfer.
Implement CreateMealPlan action with validation and caching.

🤖 Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"

# Commit 2: Tests
git add tests/Unit/Domain/MealPlanning/Actions/CreateMealPlanTest.php
git commit -m "test: add unit tests for CreateMealPlan

Test valid data, invalid date range, and cache invalidation.

🤖 Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"

# Commit 3: Livewire Component
git add app/Livewire/Home/WeeklyPlanner.php
git add resources/views/livewire/home/weekly-planner.blade.php
git commit -m "feat: add meal plan creation to WeeklyPlanner

Integrate CreateMealPlan action with Livewire component.
Add responsive UI with Tailwind CSS.

🤖 Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"
```

### Step 6: Iteration Loop

Repeat for each component:
```
1. Write failing test (RED)
   ↓
2. Implement minimal code (GREEN)
   ↓
3. Refactor & improve (REFACTOR)
   ↓
4. Run review checklist
   ↓
5. Run tests (php artisan test)
   ↓
6. Commit changes
   ↓
7. Mark todo as completed
   ↓
8. Move to next component
```

## Domain-Driven Design Patterns

### Action Structure
```php
namespace App\Domain\{DomainName}\Actions;

class ActionName
{
    public function execute(DTO $dto): Model
    {
        // 1. Validate business rules
        $this->validate($dto);

        // 2. Perform operation
        $result = $this->performOperation($dto);

        // 3. Handle side effects (cache, events)
        $this->handleSideEffects($result);

        // 4. Return result
        return $result;
    }
}
```

### Livewire Component Structure
```php
namespace App\Livewire\{Feature};

use Livewire\Component;

class ComponentName extends Component
{
    public $property;

    protected $rules = [
        'property' => 'required|string',
    ];

    public function mount(): void
    {
        // Initialize state
    }

    public function actionName(): void
    {
        // 1. Validate
        $this->validate();

        // 2. Call domain action
        $result = (new DomainAction())->execute($dto);

        // 3. Update state
        $this->property = $result;

        // 4. Dispatch events
        $this->dispatch('action-completed');

        // 5. User feedback
        session()->flash('success', 'Success message');
    }

    public function render(): View
    {
        return view('livewire.feature.component-name');
    }
}
```

## Important Guidelines

### Follow DDD Architecture
- **Actions**: Single-responsibility business logic
- **Services**: Coordinate multiple actions
- **DTOs**: Type-safe data transfer
- **Enums**: Fixed value sets
- **Models**: Eloquent models with relationships

### Domains
- `MealPlanning`: Meal plans, meal organization
- `Recipes`: Recipe search, caching, API integration
- `ShoppingList`: List generation, item management
- `UserPreferences`: Preferences, allergies, exclusions

### Security Priority
Always check:
- User authentication (auth middleware)
- User authorization (owns the data)
- Input validation (Form Requests)
- CSRF protection
- XSS prevention
- SQL injection prevention

### Performance Priority
Always check:
- Eager loading (avoid N+1)
- Caching strategy
- Database indexes
- Pagination

## Final Checklist Before Completion

- [ ] All todos marked as completed
- [ ] All tests passing (`php artisan test`)
- [ ] Code formatted (`./vendor/bin/pint`)
- [ ] Security checklist verified
- [ ] Performance checklist verified
- [ ] All changes committed
- [ ] Git status clean (`git status`)
- [ ] Documentation updated if needed

## Troubleshooting

### Tests Failing
```bash
# Detailed output
php artisan test --filter=FailingTest --verbose

# Reset database
php artisan migrate:fresh
php artisan test
```

### N+1 Query Issues
```php
// Use eager loading
Model::with(['relation1', 'relation2'])->get();
```

### Code Style Issues
```bash
# Run Pint
./vendor/bin/pint

# Check specific directory
./vendor/bin/pint app/Domain/MealPlanning/
```

## Key Principles

1. **Test-Driven Development**: Write tests first
2. **Continuous Review**: Check quality after each component
3. **Atomic Commits**: Logical units of work
4. **Security First**: Always validate and authorize
5. **Performance Aware**: Eager load, cache, index
6. **Keep It Simple**: KISS, YAGNI, DRY
7. **Document Decisions**: Explain "why" not just "what"

---

**Now ask the user**: Which technical task from `docs/tasks/` would you like to implement?
