<?php

namespace App\Contracts;

interface AuthInterface
{

    public function getUser(): ?UserInterface;

    public function attemptLogin(array $data): bool;

    public function checkCredentials(UserInterface $user, array $data): bool;

    public function logout(): void;

}
