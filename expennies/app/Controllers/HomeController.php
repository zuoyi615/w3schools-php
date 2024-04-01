<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

readonly class HomeController
{

    public function __construct(private Twig $twig) {}

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function index(Response $response): Response
    {
        return $this->twig->render($response, 'dashboard.twig');
    }

    public function getYearToDateStatistics(Response $response): Response
    {
        return $response;
    }

}
