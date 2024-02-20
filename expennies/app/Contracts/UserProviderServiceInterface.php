<?php

namespace App\Contracts;

interface UserProviderServiceInterface
{

    public function getById(int $id): ?UserInterface;

    public function getByCredentials(array $data): ?UserInterface;

}
