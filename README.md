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