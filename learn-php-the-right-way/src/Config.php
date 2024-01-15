<?php

declare(strict_types=1);

namespace App;

/**
 * @property-read ?array db
 * @property-read ?array mailer
 */
class Config
{

    protected array $config = [];

    /**
     * @param $env
     */
    public function __construct(array $env)
    {
        $this->config = [
            'db'     => [
                'host'     => $env['DB_HOST'],
                'dbname'   => $env['DB_DATABASE'],
                'user'     => $env['DB_USER'],
                'password' => $env['DB_PASS'],
                'driver'   => $env['DB_DRIVER'] ?? 'pdo_mysql',
            ],
            'mailer' => [
                'dsn' => $env['MAILER_DSN'],
            ],
        ];
    }

    /**
     * @param $name
     */
    public function __get(string $name): mixed
    {
        return $this->config[$name] ?? null;
    }

}
