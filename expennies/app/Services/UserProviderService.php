<?php

namespace App\Services;

use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

readonly class UserProviderService implements UserProviderServiceInterface
{

    public function __construct(private EntityManager $em) {}

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

}
