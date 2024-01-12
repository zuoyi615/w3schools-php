<?php

declare(strict_types=1);

namespace App\Tests\DataProviders;

class RouterDataProvider
{

    public static function routeNotFoundCases(): array
    {
        return [
            ['/users', 'put'],
            ['/invoices', 'post'],
            ['/users', 'get'],
            ['/users', 'post'],
        ];
    }

}
