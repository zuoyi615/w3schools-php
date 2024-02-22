<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\RequestValidators\CreateCategoryRequestValidator;
use App\RequestValidators\UpdateCategoryRequestValidator;
use App\ResponseFormatter;
use App\Services\CategoryService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class CategoriesController
{

    public function __construct(
        private Twig                             $twig,
        private RequestValidatorFactoryInterface $factory,
        private CategoryService                  $categoryService,
        private ResponseFormatter                $formatter,
    )
    {
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        return $this
            ->twig
            ->render(
                $response,
                'categories/index.twig',
                ['categories' => $this->categoryService->getAll()]
            );
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $this
            ->factory
            ->make(CreateCategoryRequestValidator::class)
            ->validate($request->getParsedBody());

        $user = $request->getAttribute('user');
        $this->categoryService->create($data['name'], $user);

        return $response
            ->withHeader('Location', '/categories')
            ->withStatus(302);
    }

    /**
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function delete(
        Request  $request,
        Response $response,
        array    $args
    ): Response
    {
        $this->categoryService->delete((int)$args['id']);

        return $response
            ->withHeader('Location', '/categories')
            ->withStatus(302);
    }

    public function get(
        Request  $request,
        Response $response,
        array    $args
    ): Response
    {
        $category = $this->categoryService->getById((int)$args['id']);
        if (!$category) {
            return $response->withStatus(404);
        }

        $data = [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ];

        return $this->formatter->asJson($response, $data);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $this->factory->make(UpdateCategoryRequestValidator::class)->validate($request->getParsedBody());

        $category = $this->categoryService->getById((int)$args['id']);
        if (!$category) {
            return $response->withStatus(404);
        }

        $this->categoryService->update($category, $data['name']);

        $data = ['status' => 'ok'];

        return $this->formatter->asJson($response, $data);
    }

}
