<?php

namespace App\Contracts;

use DateTime;

interface UserInterface
{

    public function getId(): int;

    public function getPassword(): string;

    public function getEmail(): string;

    public function getName(): string;

    public function setVerifiedAt(DateTime $dateTime): UserInterface;

    public function hasTwoFactorAuthEnabled(): bool;

}
