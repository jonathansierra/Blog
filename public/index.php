<?php
    //Front Controller

    //initialize the system of the errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //require the library
    require_once '../vendor/autoload.php';

    session_start();

    /*
        Get the base directory and replace the basename($_SERVER['SCRIPT_NAME']) fot '' and this happend
        in the global variable $_SERVER['SCRIPT_NAME']

        Original
        /courses/Platzi/php/Blog/public/index.php
        Function str_replace
        /courses/Platzi/php/Blog/public/
    */
    $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    /*
        Get the host and add the base directory
        Result:
        http://localhost/courses/Platzi/php/Blog/public/
    */
    $baseURL = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;
    //Const
    define('BASE_URL', $baseURL);

    //Variables enviroment
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
    $dotenv->load();

    use Illuminate\Database\Capsule\Manager as Capsule;

    $capsule = new Capsule;

    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => getenv('DB_HOST'),
        'database'  => getenv('DB_NAME'),
        'username'  => getenv('DB_USER'),
        'password'  => getenv('DB_PASS'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);

    // Make this Capsule instance available globally via static methods... (optional)
    $capsule->setAsGlobal();

    // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
    $capsule->bootEloquent();

    $route = $_GET['route'] ?? '/';

    use Phroute\Phroute\RouteCollector;

    $router = new RouteCollector();

    //Add filter
    $router->filter('auth', function() {
        if(!isset($_SESSION['userId'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            return false;
        }
    });

    /*
        This return the name of the class
        App\Controllers\IndexController::class
    */
    $router->controller('/', App\Controllers\IndexController::class);
    $router -> controller('/detail', App\Controllers\DetailController::class);
    $router->controller('/auth', App\Controllers\AuthController::class);

    /*
        Wrap multiple routes in a route group to apply that filter to every route
        defined within. You can nest route groups if required.
    */
    $router->group(['before' => 'auth'], function($router) {
        $router->controller('/admin', App\Controllers\Admin\IndexController::class);
        $router->controller('/admin/posts', App\Controllers\Admin\PostController::class);
        $router->controller('/admin/users', App\Controllers\Admin\UserController::class);
    });

    $dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

    echo $response;

?>