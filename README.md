<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# News API Project

This Laravel-based API project allows you to manage news entries. It includes CRUD operations for news, authentication, and more. Below is a guide to set up and use the project.

## Getting Started

Follow these steps to get the project up and running on your local environment.

### Prerequisites

- PHP >= 8.1
- Composer installed
- Docker (for running in a containerized environment, optional)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/gorkemgenc95/sdui-news.git

2. Navigate to the project directory:
   ```bash
   cd sdui-news

3. Install project dependencies:
   ```bash
   composer install

4. Create a .env file by copying .env.example:
   ```bash
   cp .env.example .env

5. Generate an application key:
   ```bash
   php artisan key:generate

6. Run the migrations to create the database:
   ```bash
   php artisan migrate

7. Seed the database table:
   ```bash
   php artisan db:seed --class=DatabaseSeeder

8. (Optional) If you prefer to run the project in a Docker container, see the Docker section below.
9. Start the development server:
   ```bash
   php artisan serve

## Usage
This API project provides the following features:

Authentication: The project includes Laravel's default authentication for securing API routes. You can use the /register and /login endpoints to create and authenticate users.

News Management: Use the CRUD endpoints to manage news entries.

- Create a new news entry: POST /api/news
- Retrieve all news entries: GET /api/news
- Optionally can paginate news: GET /api/news?page=3
- Retrieve a single news entry: GET /api/news/{id}
- Update a news entry: PUT /api/news/{id}
- Delete a news entry: DELETE /api/news/{id}

User Authentication: Authenticate your API requests by including the bearer token in the Authorization header. Use Laravel Breeze's built-in authentication or customize it based on your needs.

CRON Job: A CRON job is set up to automatically delete news entries older than 14 days. It runs daily to keep your database clean.

Relationships: A belongsTo relationship is established between news entries and users, using the user_id column in the News table.

## Docker (Optional)
If you prefer to run the project in a Docker container:

1. Build and start the Docker image:
   ```bash
   docker-compose up -d --build

2. Access the API at http://localhost:8080. You can update the port configuration in the docker-compose.yml file if needed.

## Testing
The project includes feature tests for CRUD endpoints and built-in authentication tests. Run the tests using:
   
```bash
php artisan test
```
