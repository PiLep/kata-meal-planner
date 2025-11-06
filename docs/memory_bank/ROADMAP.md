# Roadmap - MVP Development

## Priority #1: Home Page
**Goal:** Enable families to visualize their daily/weekly meals at a glance

### Mobile Version - Daily Digest
- Display today's meals (breakfast, lunch, dinner)
- Meal cards with recipe images and titles
- Quick actions: "Swap Meal" and "Cook Now" buttons
- Responsive design optimized for mobile devices

### Desktop Version - Weekly Planner
- Monthly calendar navigation
- Weekly meal table view (7 days × meal types)
- Quick actions toolbar (Add Recipe, Create Meal Plan, Generate Grocery List)
- Upcoming meals preview section

**Estimated complexity:** High (foundation for the entire app)

---

## Feature #2: Settings
**Goal:** Allow families to customize meal preferences

### Mobile & Desktop
- Dietary preferences selector (Omnivore, Vegetarian, Vegan, Pescatarian, Keto, Paleo, Low Carb, Mediterranean)
- Allergy management dropdown with multi-select
- Meals per day configuration (2, 3, or 4)
- Save preferences to user profile

### Desktop Additional
- Ingredient exclusion list
- Meal plan duration setting (1 week, 2 weeks)
- Include leftovers toggle
- Auto-generate shopping lists toggle

**Estimated complexity:** Medium

---

## Feature #3: Shopping List
**Goal:** Streamline grocery shopping with organized lists

### Mobile & Desktop
- Category organization (Produce, Dairy, Meat, Pantry)
- Interactive checkboxes with visual feedback (orange when checked)
- Add items manually with quantity and category
- Auto-sync with selected meal plan recipes
- Print/PDF export functionality

**Estimated complexity:** Medium

---

## Feature #4: Recipe Discovery
**Goal:** Help families find meal inspiration easily

### Mobile & Desktop
- Text-based search bar
- Filter chips (Quick & Easy, Vegetarian, Gluten-Free, Low Carb, Family-Friendly, Desserts, Breakfast, Lunch, Dinner)
- Recipe cards grid display (image 80×80px, title, short description)
- Real-time filtering
- Responsive card layout
- Empty state with helpful message

**Estimated complexity:** Medium (depends on API integration)

---

## Technical Milestones

### Phase 1: Foundation
- [ ] Laravel project setup with Sail
- [ ] Tailwind CSS configuration
- [ ] Database schema design and migrations
- [ ] OAuth authentication setup (Socialite)
- [ ] DDD folder structure

### Phase 2: Core Features
- [ ] Recipe API integration with caching
- [ ] User preferences domain
- [ ] Meal planning domain (create, update, swap)
- [ ] Shopping list domain (generate, toggle items)

### Phase 3: UI Implementation
- [ ] Home Page (mobile + desktop)
- [ ] Settings page
- [ ] Shopping List page
- [ ] Recipe Discovery page

### Phase 4: Testing
- [ ] Unit tests (Actions, Services)
- [ ] Livewire component tests
- [ ] E2E tests (Dusk) for critical user flows

### Phase 5: Deployment
- [ ] GitHub Actions CI/CD pipeline
- [ ] Laravel Forge provisioning
- [ ] Production deployment
- [ ] Monitoring setup

---

## Post-MVP Ideas
*(Not in initial scope, but potential future enhancements)*

- Meal plan sharing between family members
- Recipe rating and favorites
- Nutritional information display
- Meal prep time estimates
- Cost estimation for shopping lists
- Mobile app (React Native / Flutter)
- Recipe suggestions based on pantry items
- Integration with grocery delivery services
