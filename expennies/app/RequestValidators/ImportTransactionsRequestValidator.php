<?php

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exception\ValidationException;
use League\MimeTypeDetection\FinfoMimeTypeDetector;
use Psr\Http\Message\UploadedFileInterface;

readonly class ImportTransactionsRequestValidator implements RequestValidatorInterface
{

    public function validate(array $data): array
    {
        /** @var UploadedFileInterface $file */
        $file = $data['transaction'] ?? null;
        if (!$file) {
            new ValidationException(['transaction' => ['Please select a transaction file']]);
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new ValidationException(['transaction' => ['Failed to upload the transaction file']]);
        }

        $maxFilesize = 4 * 1024 * 1024;
        if ($file->getSize() > $maxFilesize) {
            throw new ValidationException(['transaction' => ['Maximum allowed size is 4 MB']]);
        }

        $filename = $file->getClientFilename();
        if (!preg_match('/^[a-z-A-Z0-9\s._-]+$/', $filename)) {
            throw new ValidationException(['receipt' => ['Invalid filename']]);
        }

        $allowedMimeTypes = ['text/csv'];
        if (!in_array($file->getClientMediaType(), $allowedMimeTypes)) {
            throw new ValidationException(['transaction' => ['Transaction has to be a .csv document']]);
        }

        $tmpFilePath = $file->getStream()->getMetadata('uri');
        $detector    = new FinfoMimeTypeDetector();
        $mimeType    = $detector->detectMimeTypeFromFile($tmpFilePath);

        if (!in_array($mimeType, $allowedMimeTypes)) {
            throw new ValidationException(['transaction' => ['Invalid file type']]);
        }

        return $data;
    }
}
