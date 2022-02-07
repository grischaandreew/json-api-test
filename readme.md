
# json-api-test
This headless Laravel application provides a JSONAPI conform REST API for
editorial content. It stores meta data in a Sqlite database.


## Installation with Docksal


### Development
- Install docksal -> https://docs.docksal.io/getting-started/setup/ 
- `git clone git@github.com:grischaandreew/json-api-test.git`
- `cd json-api-test`
- `fin init`
- open `http://json-api-test.docksal/api/v1` or `http://json-api-test.docksal/api/v1.yaml` for YAML definition to show JSON API endpoints and configurations 


- Run Tests: `fin exec php vendor/bin/codecept run` 
- Run Tests with codecoverage: `fin exec php vendor/bin/codecept run run unit,functional --coverage --coverage-html` and open code coverage results: `open tests/_output/coverage/index.html`


- migrate test database `fin exec php artisan --env=testing-base migrate`
- reset test database and seed new data `fin exec php artisan --env=testing-base migrate:fresh --seed`


- Update Swagger document `fin exec php artisan update:swagger`


[Installation instructions](./docs/installation.md)

[API description](./docs/api/swagger.yaml)
