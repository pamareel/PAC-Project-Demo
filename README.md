## About

Website PAC-DSS dashboard with Laravel framework version 7.5.1 and SQL.

### Run project

1. Clone project

```
git clone <project url>
cd PAC-Project-Demo
```

2. Get composer from https://getcomposer.org/download/ 

3. Install composer to the project

```
cmd PAC-Project-Demo
composer install
```

4. After composer installing, create .env

```
copy .env.example .env
```

5. Config .env, change variables for your environment such as database connection.

```
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=example 
DB_USERNAME=sa
DB_PASSWORD=Dockersql123
```

6. Change variable in \config\database.php 


```
'sqlsrv' => [
           'driver' => 'sqlsrv',
           'url' => env('DATABASE_URL'),
           'host' => env('DB_HOST', 'localhost'),
           'port' => env('DB_PORT', '1433'),
           'database' => env('DB_DATABASE', 'example'),
           'username' => env('DB_USERNAME', 'sa'),
           'password' => env('DB_PASSWORD', 'Dockersql123'),
           'charset' => 'utf8',
           'prefix' => '',
           'prefix_indexes' => true,
       ],
```

7. Run project

```
php artisan key:generate
php artisan serve
```

8. The project can be opened in browser “localhost:8000”

    For policy maker user: “localhost:8000/DashboardPage”
    For hospital user: “localhost:8000/DashboardHosUser”



