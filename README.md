## About Project

Simple application where users can create, manage, and book events.

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## Requirement

- laravel v10.2.3
- php v8.2.11
- composer v2.5.8

## How To Run

- Clone this project
- Clone file .env.example and rename to .env
- Create database name: event_booking_system_db
- Run : composer install
- Run : php artisan migrate
- Run : php artisan db:seed --class=UserSeeder
- Run : php artisan serve
- Access Admin : admin@gmail.com | superadmin88

If you want to use notification system, please change on .env to your credintials

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME={your username}
MAIL_PASSWORD={your password}