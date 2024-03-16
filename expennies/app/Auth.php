<?php

namespace App;

use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\DataObjects\RegisterUserData;
use App\Mail\SignupEmail;

class Auth implements AuthInterface
{

    private ?UserInterface $user;

    public function __construct(
        private readonly UserProviderServiceInterface $userProvider,
        private readonly SessionInterface             $session,
        private readonly SignupEmail                  $signupEmail
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

    public function attemptLogin(array $data): bool
    {
        $user = $this->userProvider->getByCredentials($data);
        if (!$this->checkCredentials($user, $data)) {
            return false;
        }

        $this->login($user);

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
        $this->session->forget('user');
        $this->session->regenerate();
        $this->user = null;
    }

    public function register(RegisterUserData $data): UserInterface
    {
        $user = $this->userProvider->createUser($data);

        // Send Email
        $this->signupEmail->sendTo($user->getEmail());

        $this->login($user);

        return $user;
    }

    public function login(UserInterface $user): void
    {
        $this->session->regenerate();
        $this->session->put('user', $user->getId());
        $this->user = $user;
    }

}
