<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\{Connection, DriverManager, Exception};

/**
 * @mixin Connection
 */
class DB
{

    private Connection $connection;

    /**
     * @throws Exception
     */
    public function __construct(private readonly array $config)
    {
        $this->connection = DriverManager::getConnection($this->config);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }

}
