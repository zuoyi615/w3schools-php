<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\{SyntaxError, RuntimeError, LoaderError};

readonly class HomeController
{

    public function __construct(private Twig $twig) {}

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'index.twig');
    }

}
