<?php

namespace App;

use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;

class Auth implements AuthInterface
{

    private ?UserInterface $user;

    public function __construct(
        private readonly UserProviderServiceInterface $userProvider,
        private readonly SessionInterface $session
    ) {
        $this->user = null;
    }

    public function getUser(): ?UserInterface
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $id = $this->session->get('user');
        if (!$id) {
            return null;
        }

        $user = $this->userProvider->getById($id);
        if (!$user) {
            return null;
        }

        return ($this->user = $user);
    }

    public function attemptLogin(
        array $data
    ): bool {
        $user = $this
            ->userProvider
            ->getByCredentials(['email' => $data['email']]);

        if (!$this->checkCredentials($user, $data)) {
            return false;
        }

        $this->session->regenerate();
        $this->session->put('user', $user->getId());

        return true;
    }

    public function checkCredentials(
        ?UserInterface $user,
        array $data
    ): bool {
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
        $this->session->forget('user');
        $this->session->regenerate();
        $this->user = null;
    }

}
