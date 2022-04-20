# Dev Notes

- Symfony 5 & API Platform
- PHP version 7.4.5
- `composer create-project symfony/skeleton ifox-api-test`
- `composer require api`
- `composer require symfony/maker-bundle --dev`
- Launch local PHP server : `php -S 127.0.0.1:8000 -t public/`
- Database : MySQL
- `rm -rf migrations/* && php bin/console doctrine:database:drop --force && php bin/console doctrine:database:create && php bin/console make:migration && php bin/console doctrine:migrations:migrate --no-interaction && php bin/console doctrine:fixtures:load --no-interaction` - For development use
- BUILD : `docker-compose up --build -d`
- URL : http://localhost:8000/
- DB GUI : http://localhost:8000/adminer.php?server=database&username=myuser&db=mydb
- Connect to App Terminal : `docker exec -it fx_php_fpm ash`

# Installation

- Operating system : **Windows**
- `composer install`
- `php bin/console doctrine:database:create && php bin/console make:migration && php bin/console doctrine:migrations:migrate --no-interaction && php bin/console doctrine:fixtures:load --no-interaction`
- Swagger GUI : http://127.0.0.1:8000/

# UML & Database structure

- Table `groups`
- - `id`
- - `details`

- Table `users`
- - `id`
- - `group_id`
- - `name`