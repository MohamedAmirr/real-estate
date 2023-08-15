# Real Estate app

## Technologies

- PHP ^8.2

- Laravel 10.10.1

- MySQL 8

- NGINX

- Docker

- PHPUnit

## Linting and Code Analysis

- PHP CS Fixer

- PHPStan (LaraStan)

## Installation

- Run `docker-compose -f docker/docker-compose.yml -p "realestateapp" --env-file .env up -d`.

- Migrate the tables `docker-compose exec app php artisan migrate`.
