# Technical Stack

## Main Framework
**Laravel + Livewire** (Full-stack)
- Laravel: Modern PHP backend with complete ecosystem
- Livewire: Full-page reactive components without complex JavaScript
- Tailwind CSS: Utility-first styling

## Database
**MySQL**
- Relational database for user data, meal plans, and shopping lists
- Management via Eloquent ORM

## Infrastructure
**Docker with Laravel Sail**
- Turnkey Dockerized development environment
- Services: PHP, MySQL, Redis, Mailpit
- Simplified commands via `sail` CLI

## Authentication
**OAuth**
- Laravel Socialite for OAuth integration
- Providers: Google, Facebook (to be defined)
- Session-based authentication

## External API
**Recipes: Third-party API**
- Candidate options: Spoonacular, Edamam, TheMealDB
- Integration via Laravel HTTP Client
- Recipe caching for optimization

## Testing
**PHPUnit + Laravel Dusk**
- Unit tests: PHPUnit (feature tests, unit tests)
- Component tests: Livewire Testing
- E2E tests: Laravel Dusk (browser automation)

## Code Quality
**Laravel Pint**
- Automatic PHP code formatting
- PSR-12 standards

## CI/CD
**GitHub Actions**
- Automatic tests on push/PR
- Quality checks (Pint)
- Automatic deployment to production

## Deployment
**Laravel Forge**
- Automated provisioning and deployment
- Environment management (staging, production)
- SSL, monitoring, backups

## Additional Services
- **Redis**: Cache and queues
- **Mailpit**: Local email testing
- **Horizon**: Queue monitoring (optional)
