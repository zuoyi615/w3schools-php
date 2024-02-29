<?php

namespace App\Contracts;

interface UserInterface
{

    public function getId(): int;

    public function getPassword(): string;

    public function getName(): string;

}
