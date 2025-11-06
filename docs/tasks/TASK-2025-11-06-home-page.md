# TASK - Home Page (Daily Digest + Weekly Planner)

## Context
This task implements the Home Page feature from issue #1, which is the highest priority MVP feature. The Home Page serves as the main interface for the meal planning application, providing two distinct views:
- **Mobile View**: Daily Digest showing today's meals with quick actions
- **Desktop View**: Weekly meal planner with calendar navigation and meal management

**Business Value**: Solves the core problem of "What's for dinner tonight?" by providing immediate visibility into planned meals and enabling quick actions to swap or start cooking.

## Domain Layer (Business Logic)

### MealPlanning Domain
- [ ] **Actions**:
  - [ ] `GetDailyMeals` - Retrieve meals for a specific date
  - [ ] `GetWeeklyMealPlan` - Retrieve meal plan for a week
  - [ ] `SwapMeal` - Replace a meal with alternative recipe
  - [ ] `CreateMealPlan` - Generate new meal plan for specified period
- [ ] **Services**:
  - [ ] `MealPlannerService` - Coordinates meal planning actions and recipe selection
- [ ] **DTOs**:
  - [ ] `DailyMealsDTO` - Data for daily digest view
  - [ ] `WeeklyMealPlanDTO` - Data for weekly planner view
  - [ ] `MealSwapRequestDTO` - Request data for swapping meals
- [ ] **Enums**:
  - [ ] `MealType` - Breakfast, Lunch, Dinner (expandable to include Snack)

### Recipes Domain
- [ ] **Actions**:
  - [ ] `GetRecipeAlternatives` - Find alternative recipes for meal swap
  - [ ] `GetRecipeDetails` - Retrieve detailed recipe for "Cook Now"
- [ ] **Services**:
  - [ ] `RecipeRecommendationService` - Suggests recipes based on preferences

## Infrastructure Layer (Data & External Services)

### Database
- [ ] **Migration**: `create_meal_plans_table`
  - Columns: `id`, `user_id`, `start_date`, `end_date`, `created_at`, `updated_at`
  - Indexes: `user_id`, `start_date`, composite index on `(user_id, start_date)`
  - Foreign key: `user_id` references `users(id)`

- [ ] **Migration**: `create_meals_table`
  - Columns: `id`, `meal_plan_id`, `recipe_id`, `meal_type`, `date`, `position`, `created_at`, `updated_at`
  - Indexes: `meal_plan_id`, `recipe_id`, `date`, composite index on `(meal_plan_id, date, meal_type)`
  - Foreign keys: `meal_plan_id` references `meal_plans(id)`, `recipe_id` references `recipes(id)`

- [ ] **Migration**: `create_recipes_table`
  - Columns: `id`, `external_id`, `name`, `description`, `image_url`, `prep_time`, `cook_time`, `servings`, `ingredients_json`, `instructions_json`, `nutrition_json`, `cached_at`, `created_at`, `updated_at`
  - Indexes: `external_id` (unique), `name`

### Models
- [ ] **Model**: `MealPlan` with relationships
  - hasMany: `meals`
  - belongsTo: `user`
  - Scopes: `current()`, `forWeek()`, `upcoming()`

- [ ] **Model**: `Meal` with relationships
  - belongsTo: `mealPlan`, `recipe`
  - Scopes: `forDate()`, `byType()`

- [ ] **Model**: `Recipe` with relationships
  - hasMany: `meals`
  - Casts: `ingredients_json`, `instructions_json`, `nutrition_json` to array

### External API
- [ ] **RecipeApiClient** - Integration with recipe API (Spoonacular/Edamam)
  - Methods: `searchRecipes()`, `getRecipeById()`, `getRandomRecipes()`

### Caching
- [ ] **Strategy**: Redis caching
  - Current week's meal plan: 30 minutes TTL
  - Recipe details: 1 hour TTL
  - Recipe alternatives: 15 minutes TTL
  - Cache keys: `meal_plan:{user_id}:{week}`, `recipe:{id}`, `alternatives:{meal_id}`

## Application Layer (Orchestration)

### Form Requests
- [ ] **SwapMealRequest**
  - Validation: `meal_id` (required, exists), `new_recipe_id` (required_without:random, exists)

- [ ] **CreateMealPlanRequest**
  - Validation: `start_date` (required, date, after_or_equal:today), `days` (required, integer, min:1, max:7)

### Policies
- [ ] **MealPlanPolicy**
  - `view`: User owns the meal plan
  - `update`: User owns the meal plan
  - `delete`: User owns the meal plan

- [ ] **MealPolicy**
  - `update`: User owns the meal's plan
  - `swap`: User owns the meal's plan

### Events & Listeners
- [ ] **Event**: `MealSwapped` → **Listener**: `UpdateShoppingList`
  - Triggered when a meal is swapped to update shopping list items

- [ ] **Event**: `MealPlanCreated` → **Listener**: `GenerateInitialShoppingList`
  - Triggered when new meal plan is created

## Presentation Layer (UI)

### Livewire Components
- [ ] **Component**: `Home/DailyDigest`
  - Properties: `$currentDate`, `$meals`, `$user`
  - Methods: `swapMeal()`, `cookNow()`, `loadMeals()`
  - Events: Listen for `meal-swapped`, dispatch `navigate-to-recipe`

- [ ] **Component**: `Home/WeeklyPlanner`
  - Properties: `$currentWeek`, `$mealPlan`, `$calendar`, `$upcomingMeals`
  - Methods: `navigateWeek()`, `selectDay()`, `swapMeal()`, `createMealPlan()`, `generateGroceryList()`
  - Events: Listen for `week-changed`, `meal-updated`

- [ ] **Sub-component**: `Home/MealCard`
  - Reusable meal display card for both views
  - Properties: `$meal`, `$showActions`
  - Methods: `handleSwap()`, `handleCook()`

- [ ] **Sub-component**: `Home/CalendarWidget`
  - Calendar navigation for weekly planner
  - Properties: `$currentMonth`, `$selectedDate`
  - Methods: `previousMonth()`, `nextMonth()`, `selectDate()`

### Blade Views
- [ ] **View**: `livewire/home/daily-digest.blade.php`
  - Mobile-optimized layout
  - Vertical meal cards
  - Fixed header with app title

- [ ] **View**: `livewire/home/weekly-planner.blade.php`
  - Desktop layout with calendar sidebar
  - Meal plan table
  - Quick actions section
  - Upcoming meals section

- [ ] **View**: `livewire/home/meal-card.blade.php`
  - Shared meal card component template

- [ ] **View**: `livewire/home/calendar-widget.blade.php`
  - Calendar component template

### Alpine.js
- [ ] **Calendar date selection**: Click handling for date selection
- [ ] **Meal card hover effects**: Show/hide quick actions on hover
- [ ] **Loading states**: Skeleton loaders during data fetch
- [ ] **Swipe gestures**: (Mobile) Swipe to change days in daily digest

## Tests

### Unit Tests
- [ ] **GetDailyMealsTest**
  - Test retrieval of meals for specific date
  - Test handling of dates with no meals
  - Test proper meal type ordering

- [ ] **SwapMealTest**
  - Test successful meal swap
  - Test swap with dietary restrictions
  - Test swap with invalid meal ID

- [ ] **CreateMealPlanTest**
  - Test creation with default preferences
  - Test creation with custom date range
  - Test duplicate plan prevention

- [ ] **MealPlannerServiceTest**
  - Test coordination of multiple actions
  - Test recipe selection based on preferences
  - Test error handling for API failures

- [ ] **RecipeRecommendationServiceTest**
  - Test recommendation filtering
  - Test dietary preference matching
  - Test allergen exclusion

### Component Tests
- [ ] **DailyDigestTest**
  - Test meal loading for current date
  - Test swap meal interaction
  - Test cook now navigation
  - Test date change handling

- [ ] **WeeklyPlannerTest**
  - Test week navigation
  - Test meal plan display
  - Test quick actions functionality
  - Test calendar interaction

- [ ] **MealCardTest**
  - Test conditional action button display
  - Test event emission on actions

### E2E Tests
- [ ] **ViewDailyMealsTest** (Dusk)
  - User views today's meals on mobile
  - User navigates between days
  - User sees proper meal images and names

- [ ] **SwapMealFlowTest** (Dusk)
  - User clicks swap on a meal
  - User selects alternative recipe
  - User sees updated meal
  - Shopping list updates automatically

- [ ] **WeeklyPlanningTest** (Dusk)
  - User navigates between weeks
  - User creates new meal plan
  - User generates grocery list
  - User views upcoming meals

- [ ] **ResponsiveLayoutTest** (Dusk)
  - Mobile shows daily digest
  - Desktop shows weekly planner
  - Proper breakpoint switching

## Execution Order

1. **Infrastructure Setup** (Foundation)
   - Create migrations for `meal_plans`, `meals`, `recipes`
   - Run migrations to create database schema
   - Create Eloquent models with relationships
   - Set up Redis caching configuration

2. **Domain Implementation** (Business Logic)
   - Create `MealType` enum
   - Implement DTOs (`DailyMealsDTO`, `WeeklyMealPlanDTO`, `MealSwapRequestDTO`)
   - Create Actions (`GetDailyMeals`, `GetWeeklyMealPlan`, `SwapMeal`, `CreateMealPlan`)
   - Build Services (`MealPlannerService`, `RecipeRecommendationService`)
   - Implement `RecipeApiClient` for external API

3. **Application Layer** (Request Handling)
   - Create Form Requests (`SwapMealRequest`, `CreateMealPlanRequest`)
   - Implement Policies (`MealPlanPolicy`, `MealPolicy`)
   - Set up Events and Listeners

4. **Presentation Layer** (UI)
   - Build `DailyDigest` Livewire component
   - Build `WeeklyPlanner` Livewire component
   - Create reusable sub-components (`MealCard`, `CalendarWidget`)
   - Design Blade views with Tailwind CSS
   - Add Alpine.js interactions

5. **Testing** (Quality Assurance)
   - Write unit tests for Actions and Services
   - Create component tests for Livewire
   - Implement E2E tests with Dusk
   - Run full test suite and fix issues

## Key Considerations

### Acceptance Criteria
- [ ] Mobile users see daily digest with breakfast, lunch, and dinner
- [ ] Desktop users see weekly meal planner with calendar
- [ ] "Swap Meal" button replaces current meal with alternative
- [ ] "Cook Now" button navigates to recipe details
- [ ] Calendar shows current day highlighted in orange
- [ ] Meal plan table displays all meals for the week
- [ ] Quick actions work: Add Recipe, Create Meal Plan, Generate Grocery List
- [ ] Upcoming meals section shows future meals with times
- [ ] Images load quickly with proper caching
- [ ] Responsive design switches correctly between mobile/desktop

### Dependencies
- User authentication system must be implemented (OAuth)
- User preferences system needed for dietary restrictions
- Recipe API integration required for meal suggestions
- Shopping list domain for grocery list generation

### Security
- **Authentication**: All routes require authenticated user (auth middleware)
- **Authorization**: Users can only view/modify their own meal plans (Policies)
- **Validation**: All user inputs validated via Form Requests
- **CSRF**: Protection enabled on all forms (Laravel default)
- **XSS**: Blade escaping for all user-generated content

### Performance
- **N+1 Prevention**: Eager load relationships
  - `MealPlan::with(['meals.recipe'])`
  - `Meal::with(['recipe', 'mealPlan.user'])`
- **Caching Strategy**:
  - Cache current week's meal plan (30 min TTL)
  - Cache recipe details from API (1 hour TTL)
  - Cache recipe alternatives (15 min TTL)
- **Database Indexes**:
  - Composite index on `(user_id, start_date)` for meal_plans
  - Composite index on `(meal_plan_id, date, meal_type)` for meals
- **Pagination**: Upcoming meals limited to 10 items
- **Image Optimization**: Lazy loading with placeholder images

### Edge Cases
- **No meals planned**: Show call-to-action to create meal plan
- **Recipe API down**: Show cached recipes, display error message for new searches
- **Missing recipe image**: Display default placeholder image
- **Very long recipe names**: Truncate with ellipsis after 50 characters
- **Past dates**: Disable swap/cook actions for past meals
- **Concurrent updates**: Handle race conditions with database locks
- **Invalid date navigation**: Prevent navigation beyond reasonable date range (±1 year)
- **Missing user preferences**: Use sensible defaults (omnivore, no allergies)

## DDD Validation Checklist

- [ ] **No business logic in Livewire components** - All logic in Actions/Services
- [ ] **Actions have single responsibility** - Each Action does one thing
- [ ] **DTOs are readonly** - All DTO properties use `public readonly`
- [ ] **Services coordinate, don't contain business logic** - Services orchestrate Actions
- [ ] **Domain boundaries respected** - No cross-domain model access
- [ ] **Proper layer separation maintained** - Clear separation between Domain/Application/Infrastructure/Presentation
- [ ] **Models contain only data and relationships** - No business logic in Eloquent models
- [ ] **Form Requests handle validation** - No validation in controllers/components
- [ ] **Policies handle authorization** - No auth checks in components
- [ ] **Events decouple domains** - Domains communicate via events
- [ ] **Caching at infrastructure layer** - Not in domain logic
- [ ] **External APIs wrapped in services** - No direct API calls from Actions