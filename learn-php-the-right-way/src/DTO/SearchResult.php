<?php

namespace App\DTO;

class SearchResult
{

    /**
     * @param  int                 $page
     * @param  SimpleCollection[]  $results
     */
    public function __construct(public int $page, public array $results) {}

}
