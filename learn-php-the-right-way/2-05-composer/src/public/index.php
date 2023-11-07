<?php

    require __DIR__.'/../vendor/autoload.php';

    use Ramsey\Uuid\{Uuid, UuidFactory};
    use App\PaymentGateway\Paddle\Transaction;

    $paddleTransaction = new Transaction();
    $uuid              = Uuid::uuid4();
    $id                = new UuidFactory();
    echo $uuid->toString();
    echo '<br />';
    echo $id->uuid4()->toString();
    echo '<br />';
    var_dump($paddleTransaction);

    /**
     * composer require ramsey/uuid
     * composer dump-autoload
     * composer dump-autoload -o // optimize
     * composer install
     */
