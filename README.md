# Email archiver 

## Getting started
1. Clone repo and cd into `email_archiver` directory.
2. Stand-up a development DB with `docker compose up -d`
3. Install dependencies with `composer install` and `npm install`
4. If it's not already installed, install the `mailparse` php extension: `pecl install mailparse` 
4. Run DB migrations: `php artisan migrate`
5. Compile static assets and run dev server with `npm run dev`
6. In a separate terminal window fire up the backend server with `php artisan serve`
