# How to create a module

## Module Directory structure

To create a module, first you'll need to know the structure of the directory.

- `config.json` : The JSON format configuration file of the particular module. It configure the database for the module, setup user permission to access the module, etc.
- `Controller.php`: The php code define the operation when request enter the module. It could be showing a page or add data to database, etc.
- `pages`: The is a directory contain the Twig template for rendering purpose, the controller can use these template for showing a page.

## Example

In this example scenario, we want to add a module to connect MySQL database and present the data table `Traffic`. The database is hosted on `localhost` and the name of database is called `office`.

We will give you a step-by-step guideline to show how to create the module.

1. Create directory in this directory, and name it to the name of the module
```bash
mkdir Traffic
```

2. Define the configuration to `config.json` inside the directory
```json
{
  "display": "Traffic",
  "route": "/traffic",
  "order": 3, # The order in the module list.
  "permission": 1, # User need privilege at least 8 to use this module.
  "database": {
    "dsn": "mysql:host=localhost;dbname=office",
    "username": "board",
    "password": "******",
  }
}
```

3. Add display template following the Twig Templates.
4. Add controller to display the data.
```php
<?php
namespace BoostBoard\Modules\Welcome;

use BoostBoard\Core\BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct(__DIR__);

        $this->addRoute(
            '/', function () {
                return $this->view('pages/index.twig');
            }
        );
    }
}
```
