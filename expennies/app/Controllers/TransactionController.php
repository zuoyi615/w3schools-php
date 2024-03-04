<?php

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\DataObjects\TransactionData;
use App\Entity\Receipt;
use App\Entity\Transaction;
use App\RequestValidators\CreateTransactionRequestValidator;
use App\RequestValidators\ImportTransactionsRequestValidator;
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
use Psr\Http\Message\UploadedFileInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class TransactionController
{

    public function __construct(
        private Twig                             $twig,
        private CategoryService                  $categoryService,
        private ResponseFormatter                $formatter,
        private RequestValidatorFactoryInterface $validatorFactory,
        private TransactionService               $transactionService,
        private RequestService                   $requestService,
    ) {}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $this
            ->validatorFactory
            ->make(CreateTransactionRequestValidator::class)
            ->validate($request->getParsedBody());

        $this->transactionService->create(
            new TransactionData(
                description: $data['description'],
                amount     : (float) $data['amount'],
                date       : new DateTime($data['date']),
                category   : $data['category']
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
        $params       = $this->requestService->getDataTableQueryParameters($request);
        $transactions = $this->transactionService->getPaginatedTransactions($params);

        $transformer = function (Transaction $transaction) {
            return [
                'id'           => $transaction->getId(),
                'description'  => $transaction->getDescription(),
                'amount'       => $transaction->getAmount(),
                'date'         => $transaction->getDate()->format('Y-m-d H:i'),
                'categoryName' => $transaction->getCategory()?->getName(),
                'categoryId'   => $transaction->getCategory()?->getId(),
                'receipts'     => $transaction->getReceipts()->map(function (Receipt $receipt) {
                    return [
                        'name' => $receipt->getFilename(),
                        'id'   => $receipt->getId(),
                    ];
                })->toArray(),
            ];
        };

        return $this->formatter->asDataTable(
            response: $response,
            data    : array_map($transformer, (array) $transactions->getIterator()),
            draw    : $params->draw,
            total   : count($transactions),
        );
    }

    public function get(Request $request, Response $response, array $args): Response
    {
        $transaction = $this->transactionService->getById((int) $args['id']);
        if (!$transaction) {
            return $response->withStatus(404);
        }

        return $this->formatter->asJson(
            response: $response,
            data    : [
                'id'          => $transaction->getId(),
                'description' => $transaction->getDescription(),
                'amount'      => $transaction->getAmount(),
                'date'        => $transaction->getDate()->format('Y-m-d H:i'),
                'category'    => $transaction->getCategory()->getId(),
            ]
        );
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->transactionService->delete((int) $args['id']);

        return $response->withStatus(204);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $args + $request->getParsedBody();
        $data = $this->validatorFactory->make(CreateTransactionRequestValidator::class)->validate($data);

        $id = (int) $data['id'];
        if (!$id || !($transaction = $this->transactionService->getById($id))) {
            return $response->withStatus(404);
        }

        $this->transactionService->update(
            $transaction,
            new TransactionData(
                description: $data['description'],
                amount     : (float) $data['amount'],
                date       : new DateTime($data['date']),
                category   : $data['category'],
            )
        );

        return $response->withStatus(204);
    }

    /**
     * @throws Exception
     * @throws ORMException
     */
    public function import(Request $request, Response $response): Response
    {
        $files = $this
            ->validatorFactory
            ->make(ImportTransactionsRequestValidator::class)
            ->validate($request->getUploadedFiles());

        /** @var UploadedFileInterface $file */
        $file       = $files['transaction'];
        $user       = $request->getAttribute('user');
        $resource   = fopen($file->getStream()->getMetadata('uri'), 'r');
        $categories = $this->categoryService->getAllKeyedByName();

        fgetcsv($resource); // first line is fields columns

        while (($row = fgetcsv($resource)) !== false) {
            [$date, $description, $categoryName, $amount] = $row;

            $date     = new DateTime($date);
            $category = $categories[$categoryName] ?? null;
            $amount   = (float) str_replace(['$', ','], '', $amount);

            $transactionData = new TransactionData(
                description: $description,
                amount     : $amount,
                date       : $date,
                category   : $category,
            );

            $this->transactionService->create($transactionData, $user);
        }

        return $response->withStatus(201);
    }

}
