<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\Entity\PasswordReset;
use App\Entity\User;
use DateTime;

readonly class PasswordResetService
{

    public function __construct(
        private EntityManagerServiceInterface $em,
        private HashService                   $hashService,
    ) {}

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

    public function findByToken(string $token): ?PasswordReset
    {
        return $this
            ->em
            ->getRepository(PasswordReset::class)
            ->createQueryBuilder('pr')
            ->select('pr')
            ->where('pr.token = :token')
            ->andWhere('pr.isActive = :active')
            ->andWhere('pr.expiration > :now')
            ->setParameter('token', $token)
            ->setParameter('active', true)
            ->setParameter('now', new DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function deactivateAllPasswordReset(string $email): void
    {
        $this
            ->em
            ->getRepository(PasswordReset::class)
            ->createQueryBuilder('pr')
            ->update()
            ->set('pr.isActive', 0)
            ->where('pr.email = :email')
            ->andWhere('pr.isActive = 1')
            ->setParameter('email', $email)
            ->getQuery()
            ->execute();
    }

    public function updatePassword(User $user, string $password): void
    {
        $this->em->wrapInTransaction(function () use ($user, $password) {
            $this->deactivateAllPasswordReset($user->getEmail());
            $user->setPassword($this->hashService->hashPassword($password));
            $this->em->sync($user);
        });
    }

}
