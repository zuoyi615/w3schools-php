<?php

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\DataObjects\TransactionData;
use App\RequestValidators\CreateTransactionRequestValidator;
use App\ResponseFormatter;
use App\Services\CategoryService;
use App\Services\TransactionService;
use DateTime;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class TransactionsController
{
    public function __construct(
        private Twig                             $twig,
        private CategoryService                  $categoryService,
        private ResponseFormatter                $formatter,
        private RequestValidatorFactoryInterface $validatorFactory,
        private TransactionService               $transactionService,
    ) {}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Exception
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $this->validatorFactory->make(CreateTransactionRequestValidator::class)->validate($request->getParsedBody());

        $this->transactionService->create(
            new TransactionData(
                description: $data['description'],
                amount: (float) $data['amount'],
                date: new DateTime($data['date']),
                category: $data['category']
            ),
            $request->getAttribute('user'),
        );

        return $response->withStatus(201);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        $categories = $this->categoryService->getCategoryNames();

        return $this->twig->render($response, 'transactions/index.twig', ['categories' => $categories]);
    }

    public function load(Request $request, Response $response): Response
    {
        return $this->formatter->asJson($response,
            [
                'data'            => [],
                'draw'            => 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
            ]
        );
    }

}
