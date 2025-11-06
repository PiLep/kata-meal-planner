# Development Planning Guide

This document explains how to create a step-by-step implementation plan following the **Implementation → Test → Review** workflow.

---

## Workflow Overview

Each feature or task should follow this three-phase cycle:

1. **Implementation** - Write the code
2. **Test** - Verify it works correctly
3. **Review** - Check quality, security, and performance

---

## Creating a Step-by-Step Plan

### Phase 1: Implementation

Break down the feature into concrete, actionable tasks:

**Example for "Create Meal Plan" feature:**

1. **Database Layer**
   - [ ] Create migration for `meal_plans` table
   - [ ] Create migration for `meals` table
   - [ ] Define Eloquent relationships in models

2. **Domain Layer**
   - [ ] Create `MealPlanDTO` with readonly properties
   - [ ] Create `CreateMealPlan` action class
   - [ ] Create `MealPlannerService` if needed
   - [ ] Define `MealType` enum (breakfast, lunch, dinner)

3. **Application Layer**
   - [ ] Create `WeeklyPlanner` Livewire component
   - [ ] Add `createMealPlan()` method to component
   - [ ] Create Blade view with Tailwind CSS

4. **Validation**
   - [ ] Create `CreateMealPlanRequest` form request
   - [ ] Add validation rules (dates, meal counts, etc.)

### Phase 2: Test

Write tests at multiple levels:

**Example for "Create Meal Plan" feature:**

1. **Unit Tests**
   - [ ] Test `CreateMealPlan` action with valid data
   - [ ] Test `CreateMealPlan` action with invalid data
   - [ ] Test `MealPlanDTO` creation
   - [ ] Test model relationships (MealPlan → Meals)

2. **Component Tests**
   - [ ] Test Livewire `WeeklyPlanner` renders correctly
   - [ ] Test `createMealPlan()` method updates state
   - [ ] Test validation errors display
   - [ ] Test success message dispatch

3. **E2E Tests**
   - [ ] Test user can create meal plan from UI
   - [ ] Test meal plan appears in weekly view
   - [ ] Test error handling for invalid inputs

### Phase 3: Review

Perform quality checks:

**Example for "Create Meal Plan" feature:**

1. **Code Quality**
   - [ ] Run Laravel Pint (code formatting)
   - [ ] Check naming follows conventions (PascalCase, camelCase, snake_case)
   - [ ] Verify single responsibility principle
   - [ ] Remove unused imports and dead code

2. **Security**
   - [ ] Verify auth middleware on routes
   - [ ] Check input validation completeness
   - [ ] Ensure CSRF protection on forms
   - [ ] Test authorization (user can only access their meal plans)

3. **Performance**
   - [ ] Check for N+1 queries (use eager loading)
   - [ ] Add database indexes if needed
   - [ ] Verify caching strategy for frequent queries
   - [ ] Test with realistic data volumes

4. **Documentation**
   - [ ] Add PHPDoc if method signature unclear
   - [ ] Update ROADMAP.md if milestone reached
   - [ ] Document any architectural decisions

---

## Template for Feature Planning

Use this template when planning a new feature:

```markdown
# Feature: [Feature Name]

**Reference**: [Link to issue or spec]
**Priority**: [High/Medium/Low]
**Estimated Time**: [X hours/days]

## Phase 1: Implementation

### Step 1: [Component Name]
- [ ] Task 1
- [ ] Task 2
- [ ] Task 3

### Step 2: [Component Name]
- [ ] Task 1
- [ ] Task 2

## Phase 2: Test

### Unit Tests
- [ ] Test scenario 1
- [ ] Test scenario 2

### Component Tests
- [ ] Test interaction 1
- [ ] Test interaction 2

### E2E Tests
- [ ] Test user flow 1

## Phase 3: Review

### Code Quality
- [ ] Run Pint
- [ ] Check conventions
- [ ] Verify KISS/YAGNI/DRY

### Security
- [ ] Check validation
- [ ] Verify auth/authorization
- [ ] Review CSRF protection

### Performance
- [ ] Check for N+1 queries
- [ ] Add necessary indexes
- [ ] Verify caching

### Documentation
- [ ] Update docs if needed
- [ ] Add comments where necessary
```

---

## Example: Complete Plan for "Swap Meal" Feature

### Feature: Swap Meal in Meal Plan

**Reference**: [issue-1.md](issues/issue-1.md) - Home Page Quick Actions
**Priority**: High
**Estimated Time**: 4 hours

#### Phase 1: Implementation

**Step 1: Database Layer**
- [x] Verify `meals` table has `recipe_id` foreign key
- [ ] Add index on `meal_plan_id` for faster lookups

**Step 2: Domain Layer**
- [ ] Create `SwapMeal` action in `app/Domain/MealPlanning/Actions/`
- [ ] Accept parameters: `Meal $meal`, `Recipe $newRecipe`
- [ ] Update meal's recipe_id
- [ ] Clear related caches
- [ ] Return updated Meal

**Step 3: Application Layer**
- [ ] Add `swapMeal(int $mealId, int $recipeId)` to `WeeklyPlanner` component
- [ ] Call `SwapMeal` action
- [ ] Dispatch `meal-swapped` event
- [ ] Show success message
- [ ] Refresh meal list

**Step 4: UI**
- [ ] Add "Swap" button to each meal card
- [ ] Create recipe selection modal
- [ ] Show loading state during swap
- [ ] Show success/error toast

#### Phase 2: Test

**Unit Tests** (`tests/Unit/Domain/MealPlanning/Actions/`)
- [ ] Test SwapMeal updates meal recipe
- [ ] Test SwapMeal clears cache
- [ ] Test SwapMeal with invalid meal throws exception
- [ ] Test SwapMeal with invalid recipe throws exception

**Component Tests** (`tests/Feature/Livewire/`)
- [ ] Test WeeklyPlanner swapMeal method
- [ ] Test meal-swapped event dispatched
- [ ] Test meal list refreshes after swap
- [ ] Test error handling displays correctly

**E2E Tests** (`tests/Browser/`)
- [ ] Test user clicks swap button
- [ ] Test user selects new recipe from modal
- [ ] Test meal card updates with new recipe
- [ ] Test success message appears

#### Phase 3: Review

**Code Quality**
- [ ] Run `./vendor/bin/pint`
- [ ] Verify `SwapMeal` follows single responsibility
- [ ] Check method naming (camelCase for methods)
- [ ] Remove any debug code or comments

**Security**
- [ ] Verify user owns the meal plan before swapping
- [ ] Validate meal_id and recipe_id in Livewire method
- [ ] Check authorization in action or middleware
- [ ] Test with unauthorized user

**Performance**
- [ ] Eager load recipe when fetching meals
- [ ] Cache recipe list for modal
- [ ] Verify no N+1 queries in meal list
- [ ] Test with 50+ meals in plan

**Documentation**
- [ ] Add PHPDoc to SwapMeal action if needed
- [ ] Update ROADMAP.md to mark feature complete
- [ ] Document cache invalidation strategy if complex

---

## Tips for Effective Planning

1. **Start Small**: Break features into smallest possible tasks (15-30 min each)
2. **Be Specific**: Avoid vague tasks like "implement feature" - specify exact files and methods
3. **Follow Order**: Complete implementation before tests, tests before review
4. **Use Checklists**: Track progress with checkboxes (keeps motivation high)
5. **Estimate Realistically**: Add buffer time for debugging and unexpected issues
6. **Review Frequently**: Don't wait until the end to check code quality
7. **Document Decisions**: Note "why" for non-obvious architectural choices

---

## Common Pitfalls to Avoid

❌ **Don't**: Write all code first, then all tests at the end
✅ **Do**: Complete implementation → test → review cycle for each component

❌ **Don't**: Skip security checks until production
✅ **Do**: Verify auth/validation at every step

❌ **Don't**: Defer performance concerns to "later optimization"
✅ **Do**: Check for N+1 queries and add indexes during development

❌ **Don't**: Write overly detailed tests that become maintenance burden
✅ **Do**: Focus tests on business logic and critical user flows

---

## Integration with Project Tools

- **TodoWrite**: Use in Claude Code to track checklist progress in real-time
- **Laravel Pint**: Run after each implementation phase
- **PHPUnit**: Run tests continuously during development
- **Git**: Commit after each phase (implementation, test, review)
- **GitHub Actions**: CI runs tests automatically on push

---

**Remember**: The goal is to ship working, tested, quality code incrementally - not to achieve perfection in one massive feature branch.
