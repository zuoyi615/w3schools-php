<?php

namespace App;

use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\DataObjects\RegisterUserData;
use App\Enum\AuthAttemptStatus;
use App\Mail\SignupEmail;
use App\Mail\TwoFactorAuthEmail;
use App\Services\UserLoginCodeService;

class Auth implements AuthInterface
{

    private ?UserInterface $user;

    public function __construct(
        private readonly UserProviderServiceInterface $userProvider,
        private readonly SessionInterface             $session,
        private readonly SignupEmail                  $signupEmail,
        private readonly TwoFactorAuthEmail           $twoFactorAuthEmail,
        private readonly UserLoginCodeService         $userLoginCodeService
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

    /**
     * @throws \Random\RandomException
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function attemptLogin(array $data): AuthAttemptStatus
    {
        $user = $this->userProvider->getByCredentials($data);
        if (!$this->checkCredentials($user, $data)) {
            return AuthAttemptStatus::FAILED;
        }

        if ($user->hasTwoFactorAuthEnabled()) {
            $this->startLoginWith2FA($user);

            return AuthAttemptStatus::TWO_FACTOR_AUTH;
        }

        $this->login($user);

        return AuthAttemptStatus::SUCCESS;
    }

    public function checkCredentials(?UserInterface $user, array $data): bool
    {
        if (!$user) {
            return false;
        }

        return password_verify($data['password'], $user->getPassword());
    }

    public function logout(): void
    {
        $this->session->forget('user');
        $this->session->regenerate();
        $this->user = null;
    }

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function register(RegisterUserData $data): UserInterface
    {
        $user = $this->userProvider->createUser($data);

        $this->signupEmail->sendTo($user);

        $this->login($user);

        return $user;
    }

    public function login(UserInterface $user): void
    {
        $this->session->regenerate();
        $this->session->put('user', $user->getId());
        $this->user = $user;
    }

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @throws \Random\RandomException
     */
    public function startLoginWith2FA(UserInterface $user): void
    {
        $this->session->regenerate();
        $this->session->put('2fa', $user->getId());
        $this->twoFactorAuthEmail->sendCode($this->userLoginCodeService->generate($user));
    }

    public function attemptTwoFactorLogin(array $data): bool
    {
        $userId = $this->session->get('2fa');
        if (!$userId) {
            return false;
        }

        $user = $this->userProvider->getById($userId);
        if (!$user) {
            return false;
        }

        if ($user->getEmail() !== $data['email']) {
            return false;
        }

        if (!$this->userLoginCodeService->verify($user, $data['code'])) {
            return false;
        }

        $this->session->forget('2fa');

        $this->login($user);

        return true;
    }

}
