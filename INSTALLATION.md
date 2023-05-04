# Installation

## Requirements

- PHP 8.1+
- Composer
- MySQL

## Installation

* Create an empty database for your application (MySQL/MariaDB).
* Copy the content from .env.example and put it into .env file.
* Replace value tagged with 123 inside the .env file.
* Run composer to install all the dependencies required.

    ```bash
    composer install
    ```
* Run database migrations to create tables inside database.

    ```bash
    php artisan migrate --seed
    ```

* And you're done.

* Also included `laravelpracticaltest.postman_collection` for import to postman

## Example for toggle input field for specific form via API

* Get form input id from `{{url}}/api/{{version}}/attach`

```json
{
          "name": "toggleInputFields",
          "request": {
            "method": "POST",
            "header": [],
            "body": {
              "mode": "formdata",
              "formdata": [
                {
                  "key": "form_id",
                  "value": "1",
                  "type": "text"
                },
                {
                  "key": "input_id",
                  "value": "5",
                  "type": "text"
                },
                {
                  "key": "toggle",
                  "value": "1",
                  "type": "text"
                }
              ]
            },
            "url": {
              "raw": "{{url}}/api/{{version}}/attach",
              "host": [
                "{{url}}"
              ],
              "path": [
                "api",
                "{{version}}",
                "attach"
              ]
            }
          },
          "response": []
        }
```

* Choose the input id you want attach to the form id
* toggle is bool true | false

## API Versioning

* run command `php artisan api:increase_version {{current_version}} {{new_version}}`

* example `php artisan api:increase_version 1 1.1`

### Important

* Missing input id key parameter will not update the input visibility in the form survey
* All endpoints that needs authentication, you need to pass the `Authorization` header with the value
  of `Bearer {token}`
* You can get the token from `api/register` or `api/login`