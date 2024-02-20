<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class HomeController
{

    public function __construct(private Twig $twig) {}

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        /**@var User | null $user */
        $user = $request->getAttribute('user');
        var_dump($user?->getName());

        return $this->twig->render($response, 'dashboard.twig');
    }

}
