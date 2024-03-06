<?php

namespace App\Services;

use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\DataObjects\RegisterUserData;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class UserProviderService implements UserProviderServiceInterface
{

    public function __construct(private EntityManagerInterface $em) {}

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
        $pass   = $data->password;
        $hashed = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
        $user   = new User();

        $user->setName($data->name);
        $user->setEmail($data->email);
        $user->setPassword($hashed);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

}
