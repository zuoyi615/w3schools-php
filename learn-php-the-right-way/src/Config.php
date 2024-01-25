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
     * @param  array  $env
     */
    public function __construct(array $env)
    {
        $this->config = [
            'db'     => [
                'host'      => $env['DB_HOST'],
                'database'  => $env['DB_DATABASE'],
                'username'  => $env['DB_USER'],
                'password'  => $env['DB_PASS'],
                'driver'    => $env['DB_DRIVER'] ?? 'mysql',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ],
            'mailer' => [
                'dsn' => $env['MAILER_DSN'],
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
