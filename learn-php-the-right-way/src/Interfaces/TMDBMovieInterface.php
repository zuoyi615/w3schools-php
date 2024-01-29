<?php

namespace App\Interfaces;

interface TMDBMovieInterface
{

    public function authenticate(): array;

    public function getPopularMovies(): array;

    public function searchMovies(string $query): array;

}
