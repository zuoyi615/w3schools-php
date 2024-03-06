<?php

namespace App\Contracts;

use App\DataObjects\RegisterUserData;

interface AuthInterface
{

    public function getUser(): ?UserInterface;

    public function attemptLogin(array $data): bool;

    public function checkCredentials(UserInterface $user, array $data): bool;

    public function logout(): void;

    public function register(RegisterUserData $data): UserInterface;

    public function login(UserInterface $user): void;

}
