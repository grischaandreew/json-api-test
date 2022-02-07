## Installation



### Development
- `composer install`
- Start application: `php artisan serve` and go to `http://127.0.0.1:8000/api/v1`


- Run Tests: `codeception run` or when only localy installed `./vendor/bin/codecept run`
- Run Tests with codecoverage: `./vendor/codeception/codeception/codecept run unit,functional --coverage --coverage-html` and open code coverage results: `open tests/_output/coverage/index.html`


- migrate test database `artisan --env=testing-base migrate`
- reset test database and seed new data `artisan --env=testing-base migrate:fresh --seed`


- Update Swagger document `php artisan update:swagger`



## Installation with Docksal



### Development
- Install docksal -> https://docs.docksal.io/getting-started/setup/ 
- `cd PROJECT_DIRECTORY`
- `fin up`
- open `http://editorial-app.docksal/api/v1` or `http://editorial-app.docksal/api/v1.yaml` for YAML definition to show JSON API endpoints and configurations 


- Run Tests: `fin exec php vendor/bin/codecept run` 
- Run Tests with codecoverage: `fin exec php vendor/bin/codecept run run unit,functional --coverage --coverage-html` and open code coverage results: `open tests/_output/coverage/index.html`


- migrate test database `fin exec php artisan --env=testing-base migrate`
- reset test database and seed new data `fin exec php artisan --env=testing-base migrate:fresh --seed`


- Update Swagger document `fin exec php artisan update:swagger`
