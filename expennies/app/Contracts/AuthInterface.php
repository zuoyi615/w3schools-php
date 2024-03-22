<?php

namespace App\Contracts;

use App\DataObjects\RegisterUserData;
use App\Enum\AuthAttemptStatus;

interface AuthInterface
{

    public function getUser(): ?UserInterface;

    public function attemptLogin(array $data): AuthAttemptStatus;

    public function checkCredentials(UserInterface $user, array $data): bool;

    public function logout(): void;

    public function register(RegisterUserData $data): UserInterface;

    public function login(UserInterface $user): void;

    public function attemptTwoFactorLogin(array $data): bool;

}
