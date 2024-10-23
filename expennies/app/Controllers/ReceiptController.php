<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\EntityManagerServiceInterface;
use App\Contracts\RequestValidatorFactoryInterface;
use App\Entity\Receipt;
use App\Entity\Transaction;
use App\RequestValidators\UploadReceiptRequestValidator;
use App\Services\ReceiptService;
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
        private ReceiptService                   $receiptService,
        private EntityManagerServiceInterface    $em,
    ) {}

    /**
     * @throws FilesystemException
     * @throws RandomException
     */
    public function store(Request $request, Response $response, Transaction $transaction): Response
    {
        /** @var UploadedFileInterface $file */
        $files = $this
            ->validatorFactory
            ->make(UploadReceiptRequestValidator::class)
            ->validate($request->getUploadedFiles());

        $file           = $files['receipt'];
        $randomFilename = bin2hex(random_bytes(24));
        $filename       = $file->getClientFilename();

        $this->filesystem->write('receipts/'.$randomFilename, $file->getStream()->getContents());

        $receipt = $this->receiptService->create($transaction, $filename, $randomFilename, $file->getClientMediaType());

        $this->em->sync($receipt);

        return $response;
    }

    /**
     * @throws FilesystemException
     */
    public function download(Response $response, Transaction $transaction, Receipt $receipt): Response
    {
        if ($receipt->getTransaction()->getId() !== $transaction->getId()) {
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
     * @throws FilesystemException
     */
    public function delete(Response $response, Transaction $transaction, Receipt $receipt): Response
    {
        if ($receipt->getTransaction()->getId() !== $transaction->getId()) {
            return $response->withStatus(401);
        }

        $filename = 'receipts/'.$receipt->getStorageFilename();
        if (!$this->filesystem->fileExists($filename)) {
            return $response->withStatus(404);
        }

        $this->filesystem->delete($filename);
        $this->em->delete($receipt, true);

        return $response->withStatus(204);
    }

}
