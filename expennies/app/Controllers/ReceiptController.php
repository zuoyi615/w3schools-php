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
use Slim\Psr7\Stream;

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

        $this->receiptService->create($transaction, $filename, $randomFilename, $file->getClientMediaType());

        return $response;
    }

    /**
     * @throws FilesystemException
     */
    public function download(Request $request, Response $response, array $args): Response
    {
        $transactionId = (int) $args['transactionId'];
        if (!$transactionId || !($transaction = $this->transactionService->getById($transactionId))) {
            return $response->withStatus(404);
        }

        $id = (int) $args['id'];
        if (!$id || !($receipt = $this->receiptService->getById($id))) {
            return $response->withStatus(404);
        }

        if ($receipt->getTransaction()->getId() !== $transactionId) {
            return $response->withStatus(401);
        }

        $filename = 'receipts/'.$receipt->getStorageFilename();
        if (!$this->filesystem->fileExists($filename)) {
            return $response->withStatus(404);
        }

        $file     = $this->filesystem->readStream($filename);
        $response = $response
            ->withHeader('Content-Disposition', 'inline; filename="'.$receipt->getFilename().'"')
            ->withHeader('Content-Type', $receipt->getMediaType());

        return $response->withBody(new Stream($file));
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->receiptService->delete((int) $args['id']);

        return $response->withStatus(204);
    }
}
