<?php

namespace App\Controllers;

use App\Attributes\Get;
use App\Services\TMDBMovieService;

class CurlController
{

    public function __construct(private TMDBMovieService $movieService) {}

    #[Get('/curl')]
    public function index(): void
    {
        $result = $this->movieService->authenticate();

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }

}
