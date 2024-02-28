<?php

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\DataObjects\TransactionData;
use App\Entity\Transaction;
use App\RequestValidators\CreateTransactionRequestValidator;
use App\ResponseFormatter;
use App\Services\CategoryService;
use App\Services\RequestService;
use App\Services\TransactionService;
use DateTime;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
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
        private RequestService                   $requestService
    ) {}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
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

    /**
     * @throws Exception
     */
    public function load(Request $request, Response $response): Response
    {
        $params = $this->requestService->getDataTableQueryParameters($request);
        $transactions = $this->transactionService->getPaginatedTransactions($params);

        $transformer = function (Transaction $transaction) {
            return [
                'id'           => $transaction->getId(),
                'description'  => $transaction->getDescription(),
                'amount'       => $transaction->getAmount(),
                'date'         => $transaction->getDate()->format('m/d/Y g:i A'),
                'categoryName' => $transaction->getCategory()->getName(),
                'categoryId'   => $transaction->getCategory()->getId(),
            ];
        };

        return $this->formatter->asDataTable(
            response: $response,
            data: array_map($transformer, (array) $transactions->getIterator()),
            draw: $params->draw,
            total: count($transactions),
        );
    }

}
