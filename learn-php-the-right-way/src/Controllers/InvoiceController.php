<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Services\InvoiceService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\{SyntaxError, RuntimeError, LoaderError};

readonly class InvoiceController
{

    public function __construct(private InvoiceService $invoiceService) {}

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    #[Get('/invoices')]
    public function index(Request $request, Response $response): Response
    {
        return Twig
            ::fromRequest($request)
            ->render(
                $response,
                'invoices/index.twig',
                ['invoices' => $this->invoiceService->getPaidInvoices()]
            );
    }

    #[Get('/invoices/create')]
    public function create(): void {}

}
