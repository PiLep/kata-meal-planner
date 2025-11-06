# Project Brief - Meal Planner

## Vision
Solve the universal family problem: **"What's for dinner tonight?"**

A meal planning application that simplifies daily family life by eliminating the stress of food decisions and grocery shopping organization.

## Target Audience
**Families** looking for a simple solution to organize their weekly meals without complexity.

## Core Value
**Simplicity first**: an intuitive application that requires no training, immediately usable by all family members.

## Problem Solved
- ❌ Daily stress of deciding what to eat
- ❌ Time wasted searching for meal ideas
- ❌ Disorganized shopping and frequent forgetfulness
- ❌ Difficulty managing family preferences and allergies

## Solution Provided
- ✅ Clear visualization of weekly meals
- ✅ Easy discovery of new recipes
- ✅ Automatic and organized shopping list
- ✅ Simplified dietary preference management
- ✅ Quick actions (swap meal, cook now)

## MVP Scope
4 essential features (mobile + desktop):

1. **Home Page** (priority #1)
   - Daily meal view (mobile)
   - Weekly planning with calendar (desktop)
   - Quick actions (swap, cook now)

2. **Settings**
   - Dietary preferences (Omnivore, Vegetarian, Vegan, etc.)
   - Allergy management
   - Meals per day frequency
   - Ingredient exclusions

3. **Shopping List**
   - Category organization (Produce, Dairy, Meat, Pantry)
   - Interactive checkboxes
   - Manual item addition
   - PDF/Print export

4. **Recipe Discovery**
   - Text search
   - Multiple filters (Quick & Easy, Vegetarian, etc.)
   - Recipe cards with images
   - Real-time filtering

## Project Goals
- **Type**: Personal project
- **Ambition**: Functional and deployed MVP
- **Timeline**: Incremental development toward complete MVP

## Data Sources
- Recipes: External API (Spoonacular, Edamam, or similar)
- Users: OAuth authentication
- User data: MySQL database

## Deployment
- Development: Docker with Laravel Sail
- Production: Laravel Forge
- CI/CD: GitHub Actions
