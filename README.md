# IT223 Backend

A Laravel-based RESTful API backend for a library management system, supporting user authentication, book management, borrowing/returning books, and dashboard statistics.

## Features

- User registration and authentication (with Laravel Sanctum)
- Book CRUD operations
- Borrow and return books with late fee calculation
- Transaction history and statistics
- RESTful API endpoints
- Database seeding and factories for development/testing

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm (for frontend assets, if needed)
- PostgreSQL (or SQLite/MySQL, configurable via `.env`)

## Getting Started

### 1. Clone the repository

```sh
git clone <your-repo-url>
cd IT223_backend
```

### 2. Install dependencies

```sh
composer install
npm install
```

### 3. Environment setup

Copy the example environment file and edit as needed:

```sh
cp .env.example .env
```

Set your database credentials and `APP_KEY` in `.env`. Generate an app key if needed:

```sh
php artisan key:generate
```

### 4. Database setup

Run migrations and seeders:

```sh
php artisan migrate --seed
```

### 5. Run the development server

```sh
php artisan serve
```

## API Endpoints

All API routes are defined in [routes/api.php](routes/api.php):

- **Books:**  
  `GET /api/books`  
  `POST /api/books`  
  `GET /api/books/{id}`  
  `PUT /api/books/{id}`  
  `DELETE /api/books/{id}`

- **Users:**  
  `POST /api/register`  
  `POST /api/login`  
  (Protected) `GET /api/users`, `GET /api/users/{id}`, etc.

- **Transactions:**  
  `POST /api/borrow`  
  `POST /api/return/{id}`  
  `GET /api/transactions`  
  `GET /api/transactions/{id}`  
  `GET /api/transactions/user/{id}`

- **Dashboard:**  
  (Protected) `GET /api/dashboard/counts`

## Authentication

- Uses Laravel Sanctum for API token authentication.
- Login returns a Bearer token to be used in the `Authorization` header.

## Testing

Run tests with:

```sh
php artisan test
```

## Project Structure

- `app/Http/Controllers/` — API controllers
- `app/Models/` — Eloquent models
- `database/migrations/` — Database schema
- `database/seeders/` — Seed data
- `database/factories/` — Model factories for testing
- `routes/api.php` — API route definitions

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
