# Meal Planner - Comprehensive Project Plan

## Executive Summary

**Meal Planner** is a Laravel + Livewire full-stack application designed to solve the universal family problem: "What's for dinner tonight?" Built with Domain-Driven Design principles, the application prioritizes simplicity and intuitive use for families seeking stress-free meal planning and shopping organization.

### Key Objectives
- Eliminate daily meal decision stress
- Streamline grocery shopping with organized lists
- Respect dietary preferences and allergies
- Provide meal inspiration through recipe discovery
- Deliver a production-ready MVP with incremental feature rollout

---

## 1. Current State Analysis

### Existing Assets
- **Documentation**: Complete project documentation structure established
  - Memory Bank: PROJECT_BRIEF, ARCHITECTURE, ROADMAP, STACK
  - Rules: CONVENTIONS documentation
  - Issues: Feature specifications (1-4) with mockups
  - AI Instructions: CLAUDE.md context files

### Project Status
- **Phase**: Pre-development (documentation complete)
- **Laravel**: Not yet initialized
- **Infrastructure**: Not configured
- **Domains**: Architecture defined, implementation pending

---

## 2. Architecture Overview

### Domain-Driven Design Structure

The application follows DDD principles with four bounded contexts:

```
app/Domain/
├── MealPlanning/         # Weekly planning, meal organization
├── Recipes/              # External API, search, filtering
├── ShoppingList/         # Auto-generation, categories, export
└── UserPreferences/      # Dietary restrictions, allergies
```

### Layered Architecture

1. **Domain Layer**: Pure business logic (Actions, Services, DTOs, Enums)
2. **Application Layer**: Orchestration (Livewire components, Form Requests)
3. **Infrastructure Layer**: External integrations (APIs, Cache, Repositories)

### Key Architectural Principles
- **Single Responsibility**: One Action = One business operation
- **Separation of Concerns**: No business logic in UI components
- **Data Transfer Objects**: Readonly data carriers between layers
- **Event-Driven**: Livewire components communicate via events

---

## 3. Technical Stack

### Core Technologies
- **Backend**: Laravel 11.x (PHP 8.2+)
- **Frontend**: Livewire 3.x (full-page components)
- **Styling**: Tailwind CSS 3.x
- **Database**: MySQL 8.0
- **Cache**: Redis
- **Development**: Docker with Laravel Sail
- **Testing**: PHPUnit, Livewire Testing, Laravel Dusk
- **CI/CD**: GitHub Actions
- **Deployment**: Laravel Forge

### External Integrations
- **Authentication**: OAuth via Laravel Socialite (Google, Facebook)
- **Recipe API**: Spoonacular/Edamam/TheMealDB (TBD)
- **Email**: Mailpit (development), Production mailer (TBD)

---

## 4. MVP Features Breakdown

### Feature #1: Home Page (Priority #1)

#### Domains Involved
- **MealPlanning**: Core domain for meal organization
- **Recipes**: Display recipe information
- **UserPreferences**: Apply dietary filters

#### Required Components

**Actions**:
- `MealPlanning/Actions/CreateMealPlan.php`
- `MealPlanning/Actions/SwapMeal.php`
- `MealPlanning/Actions/GetCurrentWeekPlan.php`
- `MealPlanning/Actions/GetTodayMeals.php`

**Services**:
- `MealPlanning/Services/MealPlannerService.php` (orchestrates plan creation)

**DTOs**:
- `MealPlanning/DTOs/MealPlanDTO.php`
- `MealPlanning/DTOs/MealDTO.php`

**Livewire Components**:
- `Application/Livewire/Home/DailyDigest.php` (mobile view)
- `Application/Livewire/Home/WeeklyPlanner.php` (desktop view)

**Database Tables**:
```sql
- meal_plans (id, user_id, week_start_date, status)
- meals (id, meal_plan_id, recipe_id, meal_type, date, position)
```

**Tests Required**:
- Unit: CreateMealPlan, SwapMeal actions
- Component: DailyDigest meal swapping, WeeklyPlanner interactions
- E2E: User creates weekly meal plan, swaps meal

---

### Feature #2: Settings

#### Domains Involved
- **UserPreferences**: Primary domain

#### Required Components

**Actions**:
- `UserPreferences/Actions/UpdateDietaryPreferences.php`
- `UserPreferences/Actions/ManageAllergies.php`
- `UserPreferences/Actions/ExcludeIngredients.php`
- `UserPreferences/Actions/UpdateMealFrequency.php`

**Enums**:
- `UserPreferences/Enums/DietType.php` (Omnivore, Vegetarian, Vegan, etc.)
- `UserPreferences/Enums/Allergen.php` (Gluten, Dairy, Nuts, etc.)

**DTOs**:
- `UserPreferences/DTOs/PreferencesDTO.php`

**Livewire Components**:
- `Application/Livewire/Settings/PreferencesForm.php`
- `Application/Livewire/Settings/AllergyManager.php`

**Database Tables**:
```sql
- user_preferences (id, user_id, diet_type, meals_per_day, plan_duration)
- user_allergies (id, user_id, allergen)
- excluded_ingredients (id, user_id, ingredient_name)
```

**Tests Required**:
- Unit: All preference update actions
- Component: PreferencesForm validation and saving
- E2E: User updates dietary preferences and allergies

---

### Feature #3: Shopping List

#### Domains Involved
- **ShoppingList**: Primary domain
- **MealPlanning**: Source of ingredients from meal plans

#### Required Components

**Actions**:
- `ShoppingList/Actions/GenerateShoppingList.php`
- `ShoppingList/Actions/ToggleItem.php`
- `ShoppingList/Actions/AddManualItem.php`
- `ShoppingList/Actions/CategorizeItems.php`
- `ShoppingList/Actions/ExportToPDF.php`

**Services**:
- `ShoppingList/Services/ShoppingListGenerator.php`

**Enums**:
- `ShoppingList/Enums/ItemCategory.php` (Produce, Dairy, Meat, Pantry)

**DTOs**:
- `ShoppingList/DTOs/ShoppingListDTO.php`
- `ShoppingList/DTOs/ShoppingItemDTO.php`

**Livewire Components**:
- `Application/Livewire/ShoppingList/ShoppingListManager.php`
- `Application/Livewire/ShoppingList/CategorySection.php`

**Database Tables**:
```sql
- shopping_lists (id, user_id, meal_plan_id, created_at)
- shopping_list_items (id, list_id, name, quantity, unit, category, is_checked)
```

**Tests Required**:
- Unit: GenerateShoppingList from meal plan
- Component: Toggle items, add manual items
- E2E: User generates and manages shopping list

---

### Feature #4: Recipe Discovery

#### Domains Involved
- **Recipes**: Primary domain

#### Required Components

**Actions**:
- `Recipes/Actions/SearchRecipes.php`
- `Recipes/Actions/FilterRecipes.php`
- `Recipes/Actions/CacheRecipe.php`
- `Recipes/Actions/GetRecipeDetails.php`

**Services**:
- `Recipes/Services/RecipeApiService.php` (external API integration)
- `Recipes/Services/RecipeCacheService.php` (Redis caching)

**DTOs**:
- `Recipes/DTOs/RecipeDTO.php`
- `Recipes/DTOs/RecipeSearchDTO.php`

**Livewire Components**:
- `Application/Livewire/Recipes/RecipeDiscovery.php`
- `Application/Livewire/Recipes/RecipeCard.php`
- `Application/Livewire/Recipes/FilterChips.php`

**Database Tables**:
```sql
- recipes (id, external_id, name, description, image_url, prep_time, cook_time, servings, cached_data)
- recipe_ingredients (id, recipe_id, ingredient_name, quantity, unit)
```

**Tests Required**:
- Unit: SearchRecipes with filters, caching logic
- Component: Recipe filtering, search interactions
- E2E: User discovers and adds recipe to meal plan

---

## 5. Development Phases

### Phase 1: Foundation Setup (Week 1)

**Technical Setup**:
- [ ] Initialize Laravel project with Sail
- [ ] Configure Docker environment
- [ ] Setup Tailwind CSS and Livewire
- [ ] Configure Redis for caching
- [ ] Setup GitHub repository with branch protection

**Database Foundation**:
- [ ] Design complete database schema
- [ ] Create all migration files
- [ ] Setup seeders for development data

**Authentication**:
- [ ] Install Laravel Socialite
- [ ] Configure OAuth providers (Google, Facebook)
- [ ] Create authentication middleware
- [ ] Setup user registration flow

**DDD Structure**:
- [ ] Create domain folder structure
- [ ] Setup base Action and Service classes
- [ ] Create DTO base structure
- [ ] Configure autoloading

---

### Phase 2: Core Domain Implementation (Week 2-3)

**UserPreferences Domain**:
- [ ] Create all Enums (DietType, Allergen)
- [ ] Implement preference Actions
- [ ] Create PreferencesDTO
- [ ] Write unit tests (100% coverage)

**MealPlanning Domain**:
- [ ] Implement CreateMealPlan Action
- [ ] Implement SwapMeal Action
- [ ] Create MealPlannerService
- [ ] Setup meal plan Models and relationships
- [ ] Write comprehensive unit tests

**Recipes Domain**:
- [ ] Integrate external Recipe API
- [ ] Implement RecipeApiService
- [ ] Setup Redis caching layer
- [ ] Create recipe search/filter Actions
- [ ] Mock API for testing

**ShoppingList Domain**:
- [ ] Implement GenerateShoppingList Action
- [ ] Create categorization logic
- [ ] Setup PDF export functionality
- [ ] Write unit tests

---

### Phase 3: UI Implementation (Week 3-4)

**Home Page Components**:
- [ ] Build DailyDigest component (mobile)
- [ ] Build WeeklyPlanner component (desktop)
- [ ] Implement meal swapping UI
- [ ] Create responsive layouts
- [ ] Add loading states and transitions

**Settings Page**:
- [ ] Build PreferencesForm component
- [ ] Create allergy multi-select
- [ ] Implement save/update logic
- [ ] Add validation and error handling

**Shopping List Page**:
- [ ] Build ShoppingListManager component
- [ ] Implement category sections
- [ ] Add checkbox interactions
- [ ] Create PDF export view

**Recipe Discovery Page**:
- [ ] Build RecipeDiscovery component
- [ ] Create filter chips UI
- [ ] Implement real-time search
- [ ] Design recipe cards

---

### Phase 4: Testing & Quality (Week 4-5)

**Unit Testing**:
- [ ] 100% coverage for all Actions
- [ ] Service layer tests
- [ ] Model relationship tests
- [ ] DTO validation tests

**Component Testing**:
- [ ] Test all Livewire components
- [ ] Validate event dispatching
- [ ] Test form validations
- [ ] Check error states

**E2E Testing (Dusk)**:
- [ ] Complete meal planning flow
- [ ] Recipe discovery to meal plan
- [ ] Shopping list generation
- [ ] Settings update flow

**Quality Assurance**:
- [ ] Run Laravel Pint for code formatting
- [ ] Security audit (authentication, authorization)
- [ ] Performance profiling with Debugbar
- [ ] N+1 query detection and optimization

---

### Phase 5: Deployment (Week 5-6)

**CI/CD Pipeline**:
- [ ] Setup GitHub Actions workflows
- [ ] Configure test automation
- [ ] Add code quality checks
- [ ] Setup deployment triggers

**Laravel Forge Setup**:
- [ ] Provision production server
- [ ] Configure environment variables
- [ ] Setup SSL certificates
- [ ] Configure database backups

**Production Readiness**:
- [ ] Setup monitoring (Laravel Telescope)
- [ ] Configure error tracking
- [ ] Setup queue workers if needed
- [ ] Performance optimization

**Launch Checklist**:
- [ ] Final security review
- [ ] Load testing
- [ ] Documentation review
- [ ] Rollback plan

---

## 6. Implementation Roadmap

### Week 1: Foundation
- Laravel setup with Sail
- Database design and migrations
- OAuth authentication
- DDD folder structure

### Week 2: Core Domains (Part 1)
- UserPreferences complete implementation
- MealPlanning Actions and Services
- Initial unit tests

### Week 3: Core Domains (Part 2) + UI Start
- Recipes API integration
- ShoppingList domain
- Begin Home Page components

### Week 4: UI Completion
- Complete all Livewire components
- Responsive design implementation
- Component testing

### Week 5: Testing & Optimization
- Complete test coverage
- E2E test scenarios
- Performance optimization
- Security audit

### Week 6: Deployment
- CI/CD pipeline setup
- Laravel Forge configuration
- Production deployment
- Post-launch monitoring

---

## 7. Success Metrics

### Technical Metrics
- **Test Coverage**: >80% overall, 100% for Actions
- **Performance**: Page load <2s, API responses <500ms
- **Security**: Zero critical vulnerabilities
- **Code Quality**: PSR-12 compliance, no duplications

### User Experience Metrics
- **Simplicity**: Zero training required
- **Mobile-First**: 100% responsive
- **Reliability**: 99.9% uptime
- **Speed**: Instant meal swapping, <3s recipe search

---

## 8. Risk Mitigation

### Technical Risks
- **API Rate Limits**: Implement aggressive caching (1-hour minimum)
- **Performance Issues**: Use eager loading, pagination, Redis caching
- **Security Vulnerabilities**: Regular audits, dependency updates

### Project Risks
- **Scope Creep**: Strict adherence to MVP features only
- **Timeline Delays**: Weekly progress reviews, parallel development
- **Technical Debt**: Continuous refactoring, maintain test coverage

---

## 9. Post-MVP Considerations

### Immediate Enhancements
- Recipe favorites and ratings
- Nutritional information display
- Meal prep time estimates
- Cost estimation for shopping lists

### Future Features
- Family member sharing
- Mobile app development
- Pantry management
- Grocery delivery integration
- AI-powered meal suggestions

---

## 10. Getting Started Checklist

### Developer Setup
1. [ ] Clone repository
2. [ ] Install Docker Desktop
3. [ ] Run `./vendor/bin/sail up`
4. [ ] Configure `.env` file
5. [ ] Run migrations: `sail artisan migrate`
6. [ ] Install dependencies: `sail composer install && sail npm install`
7. [ ] Start development: `sail npm run dev`

### First Implementation Steps
1. [ ] Create first domain folder: `app/Domain/UserPreferences`
2. [ ] Implement first Action: `UpdateDietaryPreferences`
3. [ ] Create first Livewire component: `PreferencesForm`
4. [ ] Write first unit test
5. [ ] Verify DDD structure compliance

---

## Conclusion

This comprehensive project plan provides a clear roadmap from initial setup to production deployment. The focus remains on delivering a simple, intuitive meal planning solution for families while maintaining architectural integrity through Domain-Driven Design principles.

**Key Success Factors**:
- Incremental delivery of working features
- Strict adherence to DDD patterns
- Comprehensive testing at all levels
- User-centric design decisions
- Production-ready from day one

The plan is designed to deliver a functional MVP within 6 weeks while establishing a solid foundation for future enhancements.