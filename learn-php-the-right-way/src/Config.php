<?php

declare(strict_types=1);

namespace App;

/**
 * @property-read array db
 * @property-read array mailer
 * @property-read array tmdb
 */
class Config
{

    protected array $config = [];

    /**
     * @param  array  $env
     */
    public function __construct(array $env)
    {
        $this->config = [
            'db'     => [
                'host'     => $env['DB_HOST'],
                'user'     => $env['DB_USER'],
                'password' => $env['DB_PASS'],
                'dbname'   => $env['DB_DATABASE'],
                'driver'   => $env['DB_DRIVER'] ?? 'pdo_mysql',
            ],
            'mailer' => [
                'dsn' => $env['MAILER_DSN'],
            ],
            'tmdb'   => [
                'token' => $env['TMDB_TOKEN'] ?? null,
            ],
        ];
    }

    /**
     * @param  string  $name
     *
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->config[$name] ?? null;
    }

}
