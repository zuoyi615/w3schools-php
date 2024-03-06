<?php

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Entity\User;
use App\Exception\ValidationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Valitron\Validator;

readonly class RegisterUserRequestValidator implements RequestValidatorInterface
{

    public function __construct(private EntityManagerInterface $em) {}

    public function validate(array $data): array
    {
        $v = new Validator($data);
        $v->rule(
            'required',
            ['name', 'email', 'password', 'confirmPassword']
        );
        $v->rule('email', 'email');
        $v
            ->rule('equals', 'confirmPassword', 'password')
            ->label('Confirm Password');
        $v
            ->rule(function ($field, $value) {
                return !$this
                    ->em
                    ->getRepository(User::class)
                    ->count(['email' => $value]);
            }, 'email')
            ->message('User with the given email address already exists.');

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }

}
