# Code Review Guide - Meal Planner

You are conducting a comprehensive functional and technical review of an implementation following Domain-Driven Design principles.

## Your Task

1. **Identify what to review**: The user will specify which feature, domain, or component to review
2. **Conduct comprehensive analysis**: Evaluate functionality, code quality, architecture, security, and performance
3. **Generate detailed report**: Create a structured review document in `docs/reviews/`

## Review Process

### Step 1: Identify Review Scope

Ask the user what they want to review:
- Specific feature (e.g., "Meal planning functionality")
- Domain layer (e.g., "MealPlanning domain")
- Component (e.g., "WeeklyPlanner Livewire component")
- Recent changes (e.g., "Last 3 commits")
- Full application review

### Step 2: Gather Context

Read relevant documentation:
- `docs/memory_bank/ARCHITECTURE.md` - DDD structure and principles
- `docs/rules/CONVENTIONS.md` - Coding standards
- `docs/issues/issue-*.md` - Feature specifications
- `docs/tasks/TASK-*.md` - Technical plans (if exist)

### Step 3: Conduct Multi-Dimensional Review

#### A. Functional Review

**Requirements Compliance**
- [ ] Feature matches specification in `docs/issues/`
- [ ] All acceptance criteria met
- [ ] User flows work as expected
- [ ] Edge cases handled appropriately
- [ ] Error messages are clear and actionable

**User Experience**
- [ ] UI is intuitive and responsive
- [ ] Mobile and desktop views work correctly
- [ ] Loading states implemented
- [ ] Success/error feedback provided
- [ ] Accessibility considerations (ARIA labels, keyboard navigation)

#### B. Technical Review

**Domain-Driven Design Architecture**
- [ ] Code organized in correct domain (`MealPlanning`, `Recipes`, `ShoppingList`, `UserPreferences`)
- [ ] Actions have single responsibility
- [ ] Services coordinate multiple actions appropriately
- [ ] DTOs used for type-safe data transfer
- [ ] Enums used for fixed value sets
- [ ] Models have proper relationships

**Code Quality**
- [ ] Laravel Pint formatting applied (PSR-12)
- [ ] Naming conventions followed (PascalCase, camelCase, snake_case)
- [ ] SOLID principles respected
- [ ] DRY: No code duplication
- [ ] KISS: Code is simple and readable
- [ ] YAGNI: No unnecessary abstractions
- [ ] PHPDoc blocks present and accurate
- [ ] No debug code or commented-out code

**Database Design**
- [ ] Migrations follow naming conventions
- [ ] Columns have appropriate types and constraints
- [ ] Foreign keys defined correctly
- [ ] Indexes added for query optimization
- [ ] No missing relationships
- [ ] Soft deletes used where appropriate

**Livewire Components**
- [ ] Public properties properly typed
- [ ] Validation rules defined
- [ ] Actions call domain layer (not direct DB access)
- [ ] Events dispatched for component communication
- [ ] Session flash messages for user feedback
- [ ] No business logic in components (delegated to Actions/Services)

#### C. Security Review

**Authentication & Authorization**
- [ ] Routes protected with `auth` middleware
- [ ] Users can only access their own data
- [ ] Authorization policies implemented where needed
- [ ] Session management secure

**Input Validation**
- [ ] All inputs validated with Form Requests
- [ ] Validation rules comprehensive
- [ ] Custom validation messages clear
- [ ] File uploads validated (type, size)

**Security Best Practices**
- [ ] CSRF protection on all forms
- [ ] XSS prevention (using `{{ }}` not `{!! !!}`)
- [ ] SQL injection prevented (Eloquent, no raw queries)
- [ ] Rate limiting on API endpoints
- [ ] Sensitive data not logged
- [ ] No secrets in code (use .env)

#### D. Performance Review

**Database Optimization**
- [ ] No N+1 query issues (eager loading used)
- [ ] Appropriate use of `select()` to limit columns
- [ ] Queries optimized (no unnecessary joins)
- [ ] Database indexes present
- [ ] Pagination used for large datasets

**Caching Strategy**
- [ ] API responses cached (1 hour minimum)
- [ ] User preferences cached
- [ ] Meal plans cached appropriately
- [ ] Cache invalidation implemented
- [ ] Redis configured and used

**Code Performance**
- [ ] No expensive operations in loops
- [ ] Collections used efficiently
- [ ] Lazy loading avoided where eager loading needed
- [ ] Large file processing handled async (queues)

#### E. Testing Review

**Test Coverage**
- [ ] Unit tests for Actions/Services (minimum 80% coverage)
- [ ] Component tests for Livewire components
- [ ] E2E tests for critical user flows (Dusk)
- [ ] Edge cases covered
- [ ] Error scenarios tested

**Test Quality**
- [ ] Tests follow Given-When-Then pattern
- [ ] Test names descriptive (`test_user_can_create_meal_plan`)
- [ ] Tests are isolated (no dependencies)
- [ ] Factories used for test data
- [ ] Assertions are specific and meaningful
- [ ] All tests passing

#### F. Code Maintainability

**Documentation**
- [ ] PHPDoc blocks on public methods
- [ ] Complex logic explained with comments
- [ ] README updated if needed
- [ ] API documentation current

**Dependencies**
- [ ] No unused dependencies in composer.json
- [ ] Dependencies up to date (security patches)
- [ ] Package versions specified correctly

**Error Handling**
- [ ] Try-catch blocks where appropriate
- [ ] Exceptions logged properly
- [ ] User-friendly error messages
- [ ] Failed jobs handled gracefully

### Step 4: Generate Review Report

Create a comprehensive report in `docs/reviews/` with this structure:

**Filename Format**: `REVIEW-YYYY-MM-DD-{feature-name}.md`
**Example**: `REVIEW-2025-11-06-meal-planning.md`

## Review Report Template

```markdown
# Code Review: {Feature Name}

**Date**: YYYY-MM-DD
**Reviewer**: Claude AI
**Scope**: {What was reviewed}
**Branch/Commit**: {Git reference if applicable}

---

## Executive Summary

{2-3 paragraph overview of the review findings}

**Overall Status**: =â Approved | =á Approved with Comments | =4 Changes Required

**Key Strengths**:
- {Strength 1}
- {Strength 2}
- {Strength 3}

**Critical Issues**:
- {Issue 1}
- {Issue 2}
- {Issue 3}

---

## 1. Functional Review

### Requirements Compliance
{Analysis of how well the implementation matches specifications}

**Status**:  Pass |   Partial | L Fail

**Findings**:
-  {What works well}
-   {What needs improvement}
- L {What is missing or broken}

### User Experience
{Analysis of UX quality}

**Status**:  Pass |   Partial | L Fail

**Findings**:
- {Detailed findings}

---

## 2. Technical Review

### Domain-Driven Design Architecture
{Analysis of DDD structure adherence}

**Status**:  Pass |   Partial | L Fail

**Findings**:
- {Domain organization}
- {Action/Service structure}
- {DTO usage}
- {Model relationships}

**Code References**:
- `app/Domain/{Domain}/Actions/{Action}.php:42`
- `app/Domain/{Domain}/Models/{Model}.php:15`

### Code Quality
{Analysis of code standards and principles}

**Status**:  Pass |   Partial | L Fail

**Findings**:
- {Naming conventions}
- {SOLID principles}
- {DRY/KISS/YAGNI}
- {Code readability}

**Code References**:
{Link to specific files and lines}

### Database Design
{Analysis of database structure}

**Status**:  Pass |   Partial | L Fail

**Findings**:
- {Migration structure}
- {Indexes}
- {Relationships}

---

## 3. Security Review

### Authentication & Authorization
**Status**:  Pass |   Partial | L Fail

**Findings**:
{Detailed security analysis}

### Input Validation
**Status**:  Pass |   Partial | L Fail

**Findings**:
{Validation review}

### Security Best Practices
**Status**:  Pass |   Partial | L Fail

**Findings**:
{CSRF, XSS, SQL injection, rate limiting}

**Critical Security Issues**: {None | List of issues}

---

## 4. Performance Review

### Database Optimization
**Status**:  Pass |   Partial | L Fail

**Findings**:
- N+1 queries: {Analysis}
- Eager loading: {Usage}
- Indexes: {Coverage}

**Code References**:
{Link to specific queries}

### Caching Strategy
**Status**:  Pass |   Partial | L Fail

**Findings**:
{Cache implementation review}

### Code Performance
**Status**:  Pass |   Partial | L Fail

**Findings**:
{Performance bottlenecks}

---

## 5. Testing Review

### Test Coverage
**Status**:  Pass |   Partial | L Fail

**Coverage**: {X}%

**Findings**:
- Unit tests: {Count} tests, {Coverage}%
- Component tests: {Count} tests
- E2E tests: {Count} tests

**Missing Tests**:
- {Test case 1}
- {Test case 2}

### Test Quality
**Status**:  Pass |   Partial | L Fail

**Findings**:
{Test quality analysis}

**Test Results**: {All passing | X failing}

---

## 6. Maintainability Review

### Documentation
**Status**:  Pass |   Partial | L Fail

**Findings**:
{Documentation completeness}

### Dependencies
**Status**:  Pass |   Partial | L Fail

**Findings**:
{Dependency analysis}

### Error Handling
**Status**:  Pass |   Partial | L Fail

**Findings**:
{Error handling review}

---

## Recommendations

### High Priority (Must Fix)
1. **{Issue Title}**
   - **Impact**: High
   - **Effort**: {Low/Medium/High}
   - **Description**: {Detailed description}
   - **Suggested Fix**: {How to fix}
   - **Code Reference**: {File:line}

2. {Continue...}

### Medium Priority (Should Fix)
1. {Issue and recommendations}

### Low Priority (Nice to Have)
1. {Improvements and optimizations}

---

## Positive Highlights

{Acknowledge what was done exceptionally well}

1. **{Highlight 1}**: {Description}
2. **{Highlight 2}**: {Description}
3. **{Highlight 3}**: {Description}

---

## Action Items

- [ ] {Action item 1}
- [ ] {Action item 2}
- [ ] {Action item 3}

---

## Conclusion

{Final thoughts and overall assessment}

**Recommendation**: {Approve | Request Changes | Reject}

**Estimated Time to Address Issues**: {X hours/days}

---

**Review Checklist Completed**:
- [x] Functional Review
- [x] Technical Review
- [x] Security Review
- [x] Performance Review
- [x] Testing Review
- [x] Maintainability Review

**Next Steps**: {What should happen next}
```

---

## Important Guidelines

### Be Constructive
- Focus on helping improve the code
- Acknowledge what was done well
- Provide actionable feedback
- Suggest specific solutions

### Be Thorough
- Review all relevant files
- Check git history if needed
- Run tests to verify functionality
- Use tools (Grep, Glob, Read) to explore code

### Be Objective
- Base findings on project standards (ARCHITECTURE.md, CONVENTIONS.md)
- Reference specific code locations (file:line)
- Provide evidence for claims
- Distinguish between critical issues and preferences

### Be Specific
- Link to exact files and line numbers
- Quote problematic code when relevant
- Provide before/after examples for suggested changes
- Quantify issues (X tests missing, Y% coverage)

---

## Tools to Use

1. **Grep**: Search for patterns, security issues, anti-patterns
2. **Glob**: Find relevant files by pattern
3. **Read**: Examine specific files
4. **Bash**: Run tests, check git history, run Pint
5. **TodoWrite**: Track review progress

---

## Review Workflow

```
1. Ask user what to review
   “
2. Create TodoWrite checklist
   “
3. Read relevant documentation
   “
4. Explore codebase systematically
   “
5. Run tests and analysis tools
   “
6. Document findings as you go
   “
7. Generate comprehensive report
   “
8. Save report to docs/reviews/
   “
9. Present summary to user
```

---

**Now ask the user**: What would you like me to review? (feature, domain, component, recent changes, or full application)
