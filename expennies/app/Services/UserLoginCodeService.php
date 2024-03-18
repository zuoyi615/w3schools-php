<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\Entity\User;
use App\Entity\UserLoginCode;
use DateTime;

readonly class UserLoginCodeService
{

    public function __construct(private EntityManagerServiceInterface $em) {}

    /**
     * @throws \Random\RandomException
     */
    public function generate(User $user): UserLoginCode
    {
        $userLoginCode = new UserLoginCode();
        $code          = random_int(100000, 999999);

        $userLoginCode
            ->setCode((string) $code)
            ->setExpiration(new DateTime('+10 minutes'))
            ->setUser($user);

        $this->em->sync($userLoginCode);

        return $userLoginCode;
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
