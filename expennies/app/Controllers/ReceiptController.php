<?php

declare(strict_types=1);

namespace App\Controllers;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface;

readonly class ReceiptController
{
    public function __construct(private Filesystem $filesystem) { }

    /**
     * @throws FilesystemException
     */
    public function store(Request $request, Response $response, array $args): Response
    {
        /** @var UploadedFileInterface $file */
        $file = $request->getUploadedFiles()['receipt'];
        if (!$file) {
            return $response->withStatus(400);
        }

        $filename = $file->getClientFilename();
        $id = (int)$args['id'];

        $this->filesystem->write('receipts/' . $filename, $file->getStream()->getContents());

        return $response;
    }
}
