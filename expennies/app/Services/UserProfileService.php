<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\DataObjects\UserProfileData;
use App\Entity\User;

readonly class UserProfileService
{

    public function __construct(private EntityManagerServiceInterface $em) {}

    public function get(int $userId): UserProfileData
    {
        $user = $this->em->getRepository(User::class)->find($userId);

        return new UserProfileData(
            email    : $user->getEmail(),
            name     : $user->getName(),
            twoFactor: $user->hasTwoFactorAuthEnabled(),
        );
    }

    public function update(User $user, UserProfileData $data): void
    {
        $user->setName($data->name);
        $user->setTwoFactor($data->twoFactor);
        $this->em->sync($user);
    }

}
