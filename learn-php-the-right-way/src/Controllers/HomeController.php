<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\{Get, Post, Put, Route};
use App\Enums\HttpMethod;
use App\Services\InvoiceService;
use App\View;

class HomeController
{

    public function __construct(private InvoiceService $invoiceService) {}

    #[Get('/')]
    #[Route('/home', HttpMethod::HEAD)]
    public function index(): View
    {
        $this->invoiceService->process([], 25);

        return View::make('index');
    }

    #[Post('/')]
    public function store(): void {}

    #[Put('/')]
    public function update(): void {}

}
