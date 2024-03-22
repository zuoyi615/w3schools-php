<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\SimpleCache\CacheInterface;
use Slim\Views\Twig;

readonly class HomeController
{

    public function __construct(private Twig $twig, private CacheInterface $cache) {}

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function index(Response $response): Response
    {
        $this->cache->set('name', 'Jon', 10);
        $this->cache->set('age', 17, 10);
        $this->cache->setMultiple(['height' => 180, 'weight' => 65.8]);

        var_dump($this->cache->getMultiple(['name', 'age', 'height', 'weight']));

        return $this->twig->render($response, 'dashboard.twig');
    }

}
