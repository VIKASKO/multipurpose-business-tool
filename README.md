# Personal Business ERP (Laravel 12)

This repository contains a Laravel 12 implementation baseline for a multi-business personal ERP system.

## Implemented Foundation

- Multi-business architecture (`businesses` table + `business_id` foreign keys)
- Core modules: Accounts, Income, Expense, Customers, Orders, Projects, Tasks, Dashboard
- Eloquent models with relationships
- Request validation classes
- Resource controllers + routes
- Bootstrap 5 Blade scaffold (sidebar, cards, forms, tables, delete confirmations, toast messages)
- Dynamic account balances (`income - expense`, not stored)
- Role field on users (`admin`, `staff`) and gate definitions
- Seeders for Businesses, Income Sources, Expense Categories, and Accounts

## Migrations Included

- users (updated)
- businesses
- accounts
- income_sources
- incomes
- expense_categories
- expenses
- customers
- orders
- projects
- tasks

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
