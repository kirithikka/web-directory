Laravel RESTful APIs that function as a web directory

## Steps
Run the following commands:
```bash
composer install
php artisan key:generate
php artisan migrate
```

To run the server, run
```bash
php artisan serve
```

Create .env.testing file for testing. Also, create a new DB for running automated tests. Use this DB name in the DB_DATABASE constant.

## Packages used
1. Laravel Sanctum for authentication
2. Spatie laravel data for creating DTO objects and its validation 

## Validations:
1. Authentication
    /api/register
        - name should be 255 characters max
        - email should be valid
        - password should be minimum 5 characters

    /api/login
        - email should be valid
        - password should be minimum 5 characters
