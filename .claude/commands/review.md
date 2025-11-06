You are conducting a comprehensive functional and technical code review.

## Your Task

1. **Read the review guide**: Check [docs/prompts/REVIEW.md](docs/prompts/REVIEW.md) for the complete review methodology
2. **Identify review scope**: Ask user what to review (feature, domain, component, recent changes, or full application)
3. **Conduct systematic analysis**: Evaluate functionality, architecture, security, performance, and testing
4. **Generate detailed report**: Create structured review document in `docs/reviews/`

## Review Dimensions

### 1. Functional Review
- Requirements compliance (match specs in `docs/issues/`)
- User experience (UI/UX, responsiveness, accessibility)
- Edge cases and error handling
- User flows and acceptance criteria

### 2. Technical Review
- **DDD Architecture**: Domain organization, Actions, Services, DTOs, Enums
- **Code Quality**: PSR-12, naming conventions, SOLID, DRY, KISS, YAGNI
- **Database Design**: Migrations, relationships, indexes
- **Livewire Components**: Structure, validation, event handling

### 3. Security Review
- Authentication & Authorization (middleware, policies)
- Input Validation (Form Requests)
- Security Best Practices (CSRF, XSS, SQL injection, rate limiting)

### 4. Performance Review
- Database Optimization (N+1 queries, eager loading, indexes)
- Caching Strategy (Redis, cache invalidation)
- Code Performance (loops, collections, async processing)

### 5. Testing Review
- Test Coverage (unit, component, E2E)
- Test Quality (Given-When-Then, isolation, assertions)
- All tests passing

### 6. Maintainability Review
- Documentation (PHPDoc, README, comments)
- Dependencies (versions, unused packages)
- Error Handling (try-catch, logging, user messages)

## Workflow

1. **Ask user**: "What would you like me to review?"
   - Feature name (e.g., "meal planning")
   - Domain (e.g., "MealPlanning domain")
   - Component (e.g., "WeeklyPlanner")
   - Recent changes (e.g., "last 3 commits")
   - Full application

2. **Use TodoWrite**: Create review checklist
   ```
   - [ ] Read relevant documentation
   - [ ] Functional Review
   - [ ] Technical Review
   - [ ] Security Review
   - [ ] Performance Review
   - [ ] Testing Review
   - [ ] Maintainability Review
   - [ ] Generate report
   ```

3. **Gather Context**:
   - Read `docs/memory_bank/ARCHITECTURE.md`
   - Read `docs/rules/CONVENTIONS.md`
   - Read relevant `docs/issues/issue-*.md`
   - Read relevant `docs/tasks/TASK-*.md` (if exists)

4. **Explore Codebase**:
   - Use Glob to find relevant files
   - Use Grep to search for patterns
   - Use Read to examine code
   - Run tests: `php artisan test`
   - Check formatting: `./vendor/bin/pint --test`

5. **Document Findings**:
   - Note strengths and issues
   - Link to specific code (file:line)
   - Categorize by priority (High/Medium/Low)
   - Provide actionable recommendations

6. **Generate Report**:
   - Filename: `docs/reviews/REVIEW-YYYY-MM-DD-{feature-name}.md`
   - Use template from `docs/prompts/REVIEW.md`
   - Include:
     - Executive Summary
     - Detailed findings for each dimension
     - Code references with file:line
     - Recommendations by priority
     - Action items
     - Conclusion

7. **Present Summary**:
   - Overall status (🟢 Approved | 🟡 Approved with Comments | 🔴 Changes Required)
   - Key strengths (3-5 highlights)
   - Critical issues (if any)
   - Link to full report

## Report Structure

```markdown
# Code Review: {Feature Name}

**Date**: YYYY-MM-DD
**Reviewer**: Claude AI
**Scope**: {What was reviewed}
**Overall Status**: 🟢 | 🟡 | 🔴

## Executive Summary
{2-3 paragraphs}

**Key Strengths**: {...}
**Critical Issues**: {...}

## 1. Functional Review
**Status**: ✅ Pass | ⚠️ Partial | ❌ Fail
**Findings**: {...}

## 2. Technical Review
**Status**: ✅ Pass | ⚠️ Partial | ❌ Fail
**Findings**: {...}

## 3. Security Review
**Status**: ✅ Pass | ⚠️ Partial | ❌ Fail
**Findings**: {...}

## 4. Performance Review
**Status**: ✅ Pass | ⚠️ Partial | ❌ Fail
**Findings**: {...}

## 5. Testing Review
**Status**: ✅ Pass | ⚠️ Partial | ❌ Fail
**Findings**: {...}

## 6. Maintainability Review
**Status**: ✅ Pass | ⚠️ Partial | ❌ Fail
**Findings**: {...}

## Recommendations

### High Priority (Must Fix)
1. {Issue with solution}

### Medium Priority (Should Fix)
2. {Improvement with suggestion}

### Low Priority (Nice to Have)
3. {Optimization with benefit}

## Positive Highlights
{What was done exceptionally well}

## Action Items
- [ ] {Concrete next steps}

## Conclusion
{Final assessment and recommendation}
```

## Review Principles

1. **Be Constructive**: Focus on improvement, acknowledge strengths
2. **Be Thorough**: Check all dimensions systematically
3. **Be Objective**: Base on project standards, not preferences
4. **Be Specific**: Link to code (file:line), provide examples
5. **Be Actionable**: Suggest concrete solutions
6. **Be Balanced**: Highlight both issues and strengths

## Key Standards to Check Against

**Architecture** (from ARCHITECTURE.md):
- DDD structure: `app/Domain/{Domain}/`
- Actions: Single-responsibility business logic
- Services: Coordinate multiple actions
- DTOs: Type-safe data transfer
- Enums: Fixed value sets

**Conventions** (from CONVENTIONS.md):
- Naming: PascalCase (classes), camelCase (methods/vars), snake_case (DB)
- Formatting: Laravel Pint (PSR-12), 4 spaces, 120 chars
- Principles: SOLID, DRY, KISS, YAGNI

**Security Checklist**:
- [ ] Auth middleware on protected routes
- [ ] Authorization policies where needed
- [ ] Input validation with Form Requests
- [ ] CSRF protection on forms
- [ ] XSS prevention ({{ }} not {!! !!})
- [ ] SQL injection prevention (Eloquent)
- [ ] Rate limiting on API endpoints

**Performance Checklist**:
- [ ] No N+1 queries (eager loading)
- [ ] Caching implemented (API, preferences, meal plans)
- [ ] Database indexes added
- [ ] Pagination for long lists

## Tools Usage

- **Grep**: Search for anti-patterns, security issues
  - Example: `pattern: "DB::raw|{!!|->where\('id',"` (find security risks)
- **Glob**: Find files by pattern
  - Example: `pattern: "app/Domain/MealPlanning/**/*.php"`
- **Read**: Examine specific files
- **Bash**: Run tests, check git log, run Pint

---

**Now ask the user**: What would you like me to review? (feature, domain, component, recent changes, or full application)
