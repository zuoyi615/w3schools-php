<?php

namespace App\Controllers;

use App\Attributes\Get;
use App\Interfaces\TMDBMovieInterface;

readonly class CurlController
{

    public function __construct(private TMDBMovieInterface $movieService) {}

    #[Get('/curl')]
    public function index(): void
    {
        $result = $this->movieService->authenticate();

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }

    #[Get('/curl/search/collection')]
    public function searchMovies(): void
    {
        $result = $this->movieService->searchMovies('Hallo');

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }

    #[Get('/curl/person/popular')]
    public function getPopularMovies(): void
    {
        $result = $this->movieService->getPopularMovies();

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }

}