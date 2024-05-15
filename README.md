# Email archiver 

## Getting started
1. Clone repo and cd into `email_archiver` directory.
2. Stand-up a development DB with `docker compose up -d`
3. Install dependencies with `composer install` and `npm install`
4. If it's not already installed, install the `mailparse` php extension: `pecl install mailparse`
5. Run DB migrations: `php artisan migrate`
6. Compile static assets and run dev server with `npm run dev`
7. In a separate terminal window fire up the backend server with `php artisan serve`

## Notes
* Without knowing any specifics around potential users and their objectives with this app it's hard to know what they might find valuable in the email body output. So I've stored both plain text and html versions of the body and I output plaintext if it exists, otherwise I output escaped html with the tags stripped but it's worth storing both for potential future use cases, like pulling links out of the body for example. 
* I added some basic styling to make things readable, but it's very basic because of time constraints.
* The mail parsing package is hardcoded to use UTF-8 encoding so php needs to be set up to use UTF-8.
* Would likely need indexes on the DB columns used in the table search as the dataset grows but it's fine for this scale app.
