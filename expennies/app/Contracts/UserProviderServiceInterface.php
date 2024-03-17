<?php

namespace App\Contracts;

use App\DataObjects\RegisterUserData;

interface UserProviderServiceInterface
{

    public function getById(int $id): ?UserInterface;

    public function getByCredentials(array $data): ?UserInterface;

    public function createUser(RegisterUserData $data): UserInterface;

    public function verifyUser(UserInterface $user);

}
