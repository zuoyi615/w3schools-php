<?php

namespace App\Contracts;

interface SessionInterface
{

    public function start(): void;

    public function save(): void;

    public function forget(string $key): void;

    public function regenerate(): bool;

    public function put(string $key, mixed $value): void;

    public function get(string $key, mixed $default = null): mixed;

}
