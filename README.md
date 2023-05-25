composer update
php artisan passport:install
php artisan passport:keys
php artisan migrate

1. Within your app/Http directory, create a helpers.php file and add your functions.
2. Within composer.json, in the autoload block, add "files": ["app/Http/helpers.php"].
3. Run composer dump-autoload.

php artisan migrate --path=\\database\\migrations\\fileName.php

php artisan migrate:rollback --path=/database/migrations/fileName.php


# project install

1. casino-web
    - npm i
    - npm run dev

2. casino-admin

    - npm i
    - npm run dev

3. casino-api3

    - composer install
    - composer dump-autoload
    - php artisan passport:install
    - php artisan config:clear
    - php artisan serve

4. casino-socket (file path: casino-api3/casino-socket)
    
    - npm i
    - node(nodemon) server.js
# laravel-api-test
