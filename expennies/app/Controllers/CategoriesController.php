<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\RequestValidators\CreateCategoryRequestValidate;
use App\Services\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class CategoriesController
{

    public function __construct(
        private Twig $twig,
        private RequestValidatorFactoryInterface $factory,
        private CategoryService $categoryService,
    ) {}

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        return $this
            ->twig
            ->render($response, 'categories/index.twig');
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $this
            ->factory
            ->make(CreateCategoryRequestValidate::class)
            ->validate($request->getParsedBody());

        $user = $request->getAttribute('user');
        $this->categoryService->create($data['name'], $user);

        return $response
            ->withHeader('Location', '/categories')
            ->withStatus(302);
    }

    public function delete(Request $request, Response $response): Response
    {
        return $response
            ->withHeader('Location', '/categories')
            ->withStatus(302);
    }

}
