<?php

namespace App;

use App\Contracts\AuthInterface;
use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;

class Auth implements AuthInterface
{

    private ?UserInterface $user;

    public function __construct(
        private readonly UserProviderServiceInterface $userProvider
    ) {
        $this->user = null;
    }

    public function getUser(): ?UserInterface
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $id = $_SESSION['user'] ?? null;
        if (!$id) {
            return null;
        }

        $user = $this->userProvider->getById($id);
        if (!$user) {
            return null;
        }

        return ($this->user = $user);
    }

    public function attemptLogin(array $data): bool
    {
        $user = $this
            ->userProvider
            ->getByCredentials(['email' => $data['email']]);

        if (!$this->checkCredentials($user, $data)) {
            return false;
        }

        session_regenerate_id();
        $_SESSION['user'] = $user->getId();

        return true;
    }

    public function checkCredentials(?UserInterface $user, array $data): bool
    {
        if (!$user) {
            return false;
        }

        return password_verify(
            $data['password'],
            $user->getPassword()
        );
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        $this->user = null;
    }

}
