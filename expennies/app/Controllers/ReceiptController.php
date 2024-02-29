<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\RequestValidators\UploadReceiptRequestValidator;
use App\Services\ReceiptService;
use App\Services\TransactionService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;
use Random\RandomException;

readonly class ReceiptController
{
    public function __construct(
        private Filesystem                       $filesystem,
        private RequestValidatorFactoryInterface $validatorFactory,
        private TransactionService               $transactionService,
        private ReceiptService                   $receiptService,
    ) {}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws FilesystemException
     * @throws RandomException
     */
    public function store(Request $request, Response $response, array $args): Response
    {
        /** @var UploadedFileInterface $file */
        $files = $this->validatorFactory->make(UploadReceiptRequestValidator::class)->validate($request->getUploadedFiles());
        $file  = $files['receipt'];

        $id = (int) $args['id'];
        if (!$id || !($transaction = $this->transactionService->getById($id))) {
            return $response->withStatus(404);
        }

        $randomFilename = bin2hex(random_bytes(24));
        $filename       = $file->getClientFilename();
        $this->filesystem->write('receipts/'.$randomFilename, $file->getStream()->getContents());

        $this->receiptService->create($transaction, $filename, $randomFilename);

        return $response;
    }
}
