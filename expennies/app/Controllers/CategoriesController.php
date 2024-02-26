<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Entity\Category;
use App\RequestValidators\CreateCategoryRequestValidator;
use App\RequestValidators\UpdateCategoryRequestValidator;
use App\ResponseFormatter;
use App\Services\CategoryService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'categories/index.twig');
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $this
            ->factory
            ->make(CreateCategoryRequestValidator::class)
            ->validate($request->getParsedBody());

        $user = $request->getAttribute('user');
        $this->categoryService->create($data['name'], $user);

        return $response->withStatus(200);
    }

    /**
     * @throws ORMException
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->categoryService->delete((int)$args['id']);

        return $response->withStatus(204);
    }

    public function get(Request $request, Response $response, array $args): Response
    {
        $category = $this->categoryService->getById((int)$args['id']);
        if (!$category) {
            return $this->formatter->asJson($response->withStatus(404), ['status' => 404, 'message' => 'Not Found']);
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
        $data = $this
            ->factory
            ->make(UpdateCategoryRequestValidator::class)
            ->validate($args + $request->getParsedBody());

        $category = $this->categoryService->getById((int)$data['id']);
        if (!$category) {
            return $response->withStatus(404);
        }

        $this->categoryService->update($category, $data['name']);

        $data = ['status' => 'ok'];

        return $this->formatter->asJson($response, $data);
    }

    /**
     * @throws Exception
     */
    public function load(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();

        $orderBy = $params['columns'][$params['order'][0]['column']]['data'];
        $orderDir = $params['order'][0]['dir'];

        // var_dump($params['search']['value']);
        $categories = $this->categoryService->getPaginatedCategories(
            (int)$params['start'],
            (int)$params['length'],
            $orderBy,
            $orderDir,
            $params['search']['value']
        );

        $transformer = function (Category $category) {
            return [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'createdAt' => $category->getCreatedAt()->format('m/d/Y g:i A'),
                'updatedAt' => $category->getCreatedAt()->format('m/d/Y g:i A'),
            ];
        };

        return $this->formatter->asJson(
            $response,
            [
                'data' => array_map($transformer, (array)$categories->getIterator()),
                'draw' => (int)$params['draw'],
                'recordsTotal' => count($categories),
                'recordsFiltered' => count($categories),
            ]
        );
    }

}
