<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpMethod: string
{

    case GET    = 'get';
    case POST   = 'post';
    case PATCH  = 'patch';
    case PUT    = 'put';
    case DELETE = 'delete';
    case HEAD   = 'head';

}
