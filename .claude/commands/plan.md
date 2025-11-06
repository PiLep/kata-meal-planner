You are helping plan a new feature following the Implementation → Test → Review workflow.

## Your Task

1. **Read the planning guide**: Check [docs/PLAN.md](docs/PLAN.md) for the workflow explanation
2. **Ask the user** what feature or task they want to plan
3. **Create a detailed plan** following the template from docs/PLAN.md

## Plan Structure

Create a plan with these sections:

### Phase 1: Implementation
Break down into concrete tasks:
- Database layer (migrations, models, relationships)
- Domain layer (Actions, DTOs, Services, Enums)
- Application layer (Livewire components, methods)
- Validation (Form Requests, rules)
- UI (Blade views, Tailwind CSS)

### Phase 2: Test
Define test coverage:
- Unit tests (Actions, Services, Models)
- Component tests (Livewire interactions)
- E2E tests (User flows with Dusk)

### Phase 3: Review
Quality checklist:
- Code quality (Pint, conventions, principles)
- Security (auth, validation, CSRF, authorization)
- Performance (N+1 queries, caching, indexes)
- Documentation (PHPDoc, updates to memory bank)

## Important Guidelines

- **Be specific**: Name exact files, classes, and methods
- **Break into small tasks**: 15-30 minutes each
- **Follow DDD**: Check [docs/memory_bank/ARCHITECTURE.md](docs/memory_bank/ARCHITECTURE.md)
- **Follow conventions**: Check [docs/rules/CONVENTIONS.md](docs/rules/CONVENTIONS.md)
- **Reference specs**: Link to relevant [docs/issues/](docs/issues/) files
- **Use TodoWrite**: Create trackable checklist with the TodoWrite tool

## Example Output

```markdown
# Feature: [Name]

**Reference**: [Link to issue]
**Priority**: [High/Medium/Low]
**Estimated Time**: [X hours]

## Phase 1: Implementation

### Step 1: Database Layer
- [ ] Create migration for `table_name`
- [ ] Add Eloquent relationships

### Step 2: Domain Layer
- [ ] Create `ActionName` in `app/Domain/{Domain}/Actions/`
- [ ] Create `DTO` with readonly properties

[...continue with all steps...]

## Phase 2: Test

### Unit Tests
- [ ] Test action with valid data
- [ ] Test action with invalid data

[...continue...]

## Phase 3: Review

### Code Quality
- [ ] Run Laravel Pint
- [ ] Check naming conventions

[...continue...]
```

## After Creating the Plan

1. Ask user if they want to proceed with implementation
2. If yes, use TodoWrite to create the checklist
3. Start with Phase 1, Step 1

**Now ask the user**: What feature or task would you like to plan?
