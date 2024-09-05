[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F071bcb2e-0a97-4cf0-8b48-99853b645916%3Fdate%3D1%26commit%3D1&style=plastic)](https://forge.laravel.com/servers/704181/sites/2052472)

# Actual Loading Service

- demo: https://admin-actual-loading.cargis.pro/

## Dev environment

- run `cp .env.example .env`
- run `docker-compose up -d --build`
- run `docker-compose exec app php artisan migrate`
- run `docker-compose exec app php artisan l5-swagger:generate`

## Tests

- run `php artisan test`
- with coverage `XDEBUG_MODE=coverage php artisan test --coverage-html tests/reports/coverage`

## Api Docs

[https://admin-actual-loading.cargis.pro/api/documentation](https://admin-actual-loading.cargis.pro/documentation)