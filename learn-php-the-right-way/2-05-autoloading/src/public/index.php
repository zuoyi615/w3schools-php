<?php

    declare(strict_types=1);

    // require_once '../app/PaymentGateway/Paddle/Transaction.php';
    // require_once '../app/PaymentGateway/Paddle/CustomerProfile.php';
    // require_once '../app/PaymentGateway/Stripe/Transaction.php';
    // require_once '../app/Notification/Email.php';


    /**
     * @link https://www.php-fig.org/
     */
    spl_autoload_register(function ($class) {
        $class    = str_replace('\\', '/', $class);
        $filename = "$class.php";
        $filename = lcfirst($filename);
        $path     = __DIR__.'/../'.$filename;
        if (file_exists($path)) {
            require_once $path;
        }
    });

    use App\PaymentGateway\Paddle\Transaction;

    $paddleTransaction = new Transaction();
    var_dump($paddleTransaction);
