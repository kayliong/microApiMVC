# <h1> MicroAPIMVC - Simple API Framework With MVC Supported

This is a flexible micro framework with Model and Classes. Suitable for testing small piece of code, db and API prototyping.
* Currently only support apache web server.
* Very bare minimum code.
* There is no authentication nor authorisation in this version.
* Has DB connection class handle necessary query.
* has message class handle API response.
* Route class may refer to : https://github.com/steampixel/simplePHPRouter

# <h2>Installation
* Run on apache ONLY, there is .htaccess in the folder for routing. 

## <h3> Modify .htaccess
* change the "index.php" to any file naming according to your need
## <h3> Database settings
1. Edit file /conf/database.ini to change the credentials
2. This [LOCAL] refer to your environment variables set in httpd.conf, change it accordingly.
    * SetEnv    ENVIRONMENT    "LOCAL"

# <h2> How it works
## <h3> index.php
- API landing on index.php
- Add new route before the ``` Route::run('/'); ```
## <h3> _autoloader.php
- Modifiy ```_autoloader.php``` inside the ```spl_autoload_register``` to add additional library or class to be auto load.
-

# <h2> Demo / Test
- Run file "flexmicro_test.sql" to generate a test database and a "level" table.
- Sample APIs:
    - POST: /test-post
        - Example post data:
        ```javascript
        test:result
        ```
        - Example response data:
        ``` javascript
        {
            "test": "result"
        }
        ```
    - GET: /test-get
        - Example response data:
        ``` javascript
        {
            "This is a GET!"
        }
        ```
    - GET: /test-dbread

# <h2> Example Error
- 405
```
{
    "status": {
        "code": "405",
        "msg": "Error 405"
    },
    "result": "Method not allowed!"
}
```
