<?php

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\DataObjects\RegisterUserData;
use App\Entity\User;
use DateTime;

readonly class UserProviderService implements UserProviderServiceInterface
{

    public function __construct(
        private EntityManagerServiceInterface $em,
        private HashService                   $hashService,
    ) {}

    public function getById(int $id): ?UserInterface
    {
        return $this
            ->em
            ->getRepository(User::class)
            ->find($id);
    }

    public function getByCredentials(array $data): ?UserInterface
    {
        return $this
            ->em
            ->getRepository(User::class)
            ->findOneBy(['email' => $data['email']]);
    }

    public function createUser(RegisterUserData $data): UserInterface
    {
        $hashed = $this->hashService->hashPassword($data->password);
        $user   = new User();

        $user->setName($data->name);
        $user->setEmail($data->email);
        $user->setPassword($hashed);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function verifyUser(UserInterface $user): void
    {
        $user->setVerifiedAt(new DateTime());
        $this->em->sync($user);
    }

}
