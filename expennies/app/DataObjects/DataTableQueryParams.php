<?php

namespace App\DataObjects;

readonly class DataTableQueryParams
{

    public function __construct(
        public int    $start,
        public int    $length,
        public string $orderBy,
        public string $orderDir,
        public string $search,
        public int    $draw,
    ) {}
}
