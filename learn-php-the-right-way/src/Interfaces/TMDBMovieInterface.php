<?php

namespace App\Interfaces;

use App\DTO\AuthenticationResult;
use App\DTO\SearchResult;

interface TMDBMovieInterface
{

    public function authenticate(): AuthenticationResult;

    public function getPopularMovies(): array;

    public function searchMovies(string $query): SearchResult;

}
