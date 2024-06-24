Laravel RESTful APIs that function as a web directory

## Steps
- Create(if already not present) .env file in the root of the application. Copy the contents from .env.example to .env. 
- Create a new DB and use this DB in the .env DB_DATABASE constants.

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

To run the seeder and populate the users and categories table, run 
```bash
php artisan db:seed
```

The above command creates two categories in the categories table and creates an admin user with the following credentials:
- email: admin@example.com
- password: password

## Testing

- Create .env.testing file for testing. 
- Create a new DB for running automated tests. Use this DB name in the .env.testing DB_DATABASE constant.
- Add SCOUT_DRIVER=database to .env.testing file (if not already present)

To run the tests, run
```bash
php artisan test
```

## Packages used
1. Laravel Sanctum for authentication
2. Spatie laravel data for creating DTO objects and its validation
3. Laravel Scout for searching

## Validations:
1. Authentication
    - /api/register
        - name should be 255 characters max
        - email should be valid
        - password should be minimum 5 characters

    - /api/login
        - email should be valid
        - password should be minimum 5 characters

2. Websites
    - /api/v1/websites (Create websites)
        - URL should be valid and unique
        - Name, URL, and description can have a maximum of 255 characters
        - Categories should be a valid array (only the IDs present in the categories table)

3. Voting/Unvoting:
    - /api/v1/vote
    - /api/v1/unvote
        - Website id must be valid

## Postman Collections
Please find the postman collections here.
https://drive.google.com/file/d/1JXWdli74xjkXBtbNQoHWUkUnbRnoUPN6/view?usp=drive_link

## Details:
To ensure the web directory is scalable, the following are implemented:
- Database tables are indexed, particularly on columns that are frequently searched.
- Implemented pagination for website search API to handle large datasets more efficiently.

## Next Steps
1. Caching can be implemented for website search to optimize its performance and handle high loads efficiently.
2. CRUD for Categories.
3. Set up Algolia as the Laravel Scout driver for powerful search capabilities.
4. Error handling: Providing more informative and user friendly error messages.
5. The system might need a robust logging system.
6. Rate limiting can be implemented for the APIs to protect them from security threats.
7. Unit tests: This project includes basic tests for Authentication APIs and Website creation. Additional tests for other functionalities can be added.
8. Generating documentation using tools like Swagger.
9. Implementing GitHub actions: To automate the tasks such as running tests, linting code, etc.
