<?php
    
    declare(strict_types=1);
    
    use SendEmail\App;
    use SendEmail\Config;
    use SendEmail\Container;
    use SendEmail\Controllers\GeneratorExampleController;
    use SendEmail\Controllers\HomeController;
    use SendEmail\Controllers\InvoiceController;
    use SendEmail\Controllers\UserController;
    use SendEmail\Exceptions\RouteNotFoundException;
    use SendEmail\Router;
    
    require_once __DIR__.'/../vendor/autoload.php';
    
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    
    const STORAGE_PATH = __DIR__.'/../storage';
    const VIEW_PATH    = __DIR__.'/../views';
    
    $container = new Container();
    $router    = new Router($container);
    
    try {
        $router->registerRoutesFromControllerAttributes(
            [
                HomeController::class,
                GeneratorExampleController::class,
                InvoiceController::class,
                UserController::class,
            ]
        );
    } catch (RouteNotFoundException $e) {
        print_r($e);
    }
    
    (new App(
        $container,
        $router,
        ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
        new Config($_ENV)
    ))->run();
