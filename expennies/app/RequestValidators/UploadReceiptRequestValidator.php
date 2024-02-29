<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exception\ValidationException;
use finfo;
use Psr\Http\Message\UploadedFileInterface;

class UploadReceiptRequestValidator implements RequestValidatorInterface
{


    public function validate(array $data): array
    {
        /** @var UploadedFileInterface $file */
        $file = $data['receipt'] ?? null;

        /** #### Validate uploaded File */
        if (!$file) {
            throw new ValidationException(['receipt' => ['Please select a receipt file']]);
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new ValidationException(['receipt' => ['Failed to upload the receipt file']]);
        }

        /** #### Validate the file size */
        $maxFilesize = 4 * 1024 * 1024;
        if ($file->getSize() > $maxFilesize) {
            throw new ValidationException(['receipt' => ['Maximum allowed size is 5 MB']]);
        }

        /** #### Validate the file name */
        $filename = $file->getClientFilename();
        if (!preg_match('/^[a-z-A-Z0-9\s._-]+$/', $filename)) {
            throw new ValidationException(['receipt' => ['Invalid filename']]);
        }

        /** #### Validate the file type */
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($file->getClientMediaType(), $allowedMimeTypes)) {
            throw new ValidationException(['receipt' => ['Receipt has to be either an image or a pdf document']]);
        }

        $allowedExtensions = ['pdf', 'png', 'jpeg', 'jpg'];
        $tmpFilePath = $file->getStream()->getMetadata('uri');

        if (!in_array($this->getExtension($tmpFilePath), $allowedExtensions)) {
            throw new ValidationException(['receipt' => ['Receipt has to be either "pdf", "png", "jpg", "jpeg"']]);
        }

        if (!in_array($this->getMimeType($tmpFilePath), $allowedMimeTypes)) {
            throw new ValidationException(['receipt' => ['Invalid File Type']]);
        }

        return $data;
    }

    private function getExtension(string $path): string
    {
        $fileInfo = new finfo(FILEINFO_EXTENSION);
        return $fileInfo->file($path) ?: '';
    }

    private function getMimeType(string $path): string
    {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        return $fileInfo->file($path) ?: '';
    }
}
