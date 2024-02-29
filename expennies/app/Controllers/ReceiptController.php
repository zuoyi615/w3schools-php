<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\RequestValidators\UploadReceiptRequestValidator;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;

readonly class ReceiptController
{
    public function __construct(
        private Filesystem                       $filesystem,
        private RequestValidatorFactoryInterface $validatorFactory,
    ) {}

    /**
     * @throws FilesystemException
     */
    public function store(Request $request, Response $response, array $args): Response
    {
        /** @var UploadedFileInterface $file */
        $files = $this->validatorFactory->make(UploadReceiptRequestValidator::class)->validate($request->getUploadedFiles());
        $file = $files['receipt'];

        $id = (int) $args['id'];

        $filename = $file->getClientFilename();
        $this->filesystem->write('receipts/'.$filename, $file->getStream()->getContents());

        return $response;
    }
}
