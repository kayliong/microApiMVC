# <h1> MicroAPIMVC - Simple API Framework With MVC Supported

This is a flexible micro framework with Models, Views and Classes. Suitable for testing small piece of code, database and API prototyping.
* Currently only support apache web server.
* Very bare minimum code.
* Added JWT authentication. 
* Stateless with Login and logout functionality.
* User registration form. 
* Has DB connection class handle necessary query.
* Has basic message class handle API response.
* Route class may refer to : https://github.com/steampixel/simplePHPRouter

# <h2>Installation
* Run on apache ONLY, there is .htaccess in the folder for routing. 
* Run file "initial-run.sql" to generate a test database, a users table and a tasks tables.
* Visit the site URL, example: http://microapimvc:8888
* Success installation will land on the login form.

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


# <h2> Demo
- DEMO: http://microapimvc.keenlio.com/

# <h2> Supports for Composer
- Composer packages install under vendor/ folder.
- Usage of composer package, example
    ```php
    use \Firebase\JWT\JWT;
    ```
- Layout package is using CoreUI
- JWT package is using 
    ```json
    "firebase/php-jwt": "^5.2"
    ```

# <h2> Variables
- There are some variables under classes/ variables.php
- The password is encrypt using password_hash, to change the cost, change this constant
    ```php
    CONST HASHCOST = 6;
    ```
- For Json Web Token encode JWT, modify below constants
    ```php
    CONST JWT_NAME = "<anyname>";
    CONST JWT_KEY = "<anykey>";
    CONST JWT_EXPIRE_HOURS = 1;// hours
    CONST JWT_EXPIRE_SECS = 60;// seconds
    CONST JWT_ISSUER = "<your issuer>";
    ```

# <h2> Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.


# <h2> License
[MIT](https://choosealicense.com/licenses/mit/)