## Introduction

Hello, I'm Gianfranco, and this is my proposed solution for Light-it's challenge.

## Requirements

PHP >= 8.0

## Steps for getting the project up and running

1. Clone the repo
2. Run `cp .env.example .env`
3. Run `composer install`
4. Run `php artisan key:generate`
5. Run `php artisan migrate --seed`
6. Set your API Medic's account Api Key (API_MEDIC_AUTH_API_KEY) and Secret Key (API_MEDIC_AUTH_SECRET_KEY) in .env
7. You're good to go

## Login credentials

You can either fill out the registration form or use the following default login credentials:

- Email: test@test.com
- Password: test123

## Testing

You can run `php artisan test` to execute all available tests. These include the default Breeze's tests and also the challenge's specifications related tests.
