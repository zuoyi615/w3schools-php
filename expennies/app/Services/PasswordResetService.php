<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\Entity\PasswordReset;
use App\Entity\User;
use App\Entity\UserLoginCode;
use DateTime;

readonly class PasswordResetService
{

    public function __construct(private EntityManagerServiceInterface $em) {}

    /**
     * @throws \Random\RandomException
     */
    public function generate(string $email): PasswordReset
    {
        $passwordReset = new PasswordReset();

        $passwordReset
            ->setToken(bin2hex(random_bytes(32)))
            ->setExpiration(new DateTime('+20 minutes'))
            ->setEmail($email);

        $this->em->sync($passwordReset);

        return $passwordReset;
    }

    public function verify(User $user, string $code): bool
    {
        $criteria      = ['code' => $code, 'user' => $user];
        $userLoginCode = $this->em->getRepository(UserLoginCode::class)->findOneBy($criteria);

        if (!$userLoginCode) {
            return false;
        }

        if ($userLoginCode->getExpiration() <= new DateTime()) {
            return false;
        }

        return true;
    }

}
