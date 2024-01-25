<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\{Get, Post, Put, Route};
use App\Enums\HttpMethod;
use App\View;

readonly class HomeController
{

    #[Get('/')]
    #[Route('/home', HttpMethod::HEAD)]
    public function index(): View
    {
        return View::make('index');
    }

    #[Post('/')]
    public function store(): void {}

    #[Put('/')]
    public function update(): void {}

}
