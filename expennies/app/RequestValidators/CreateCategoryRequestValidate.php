<?php

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface as RVI;
use App\Entity\User;
use App\Exception\ValidationException;
use Doctrine\ORM\EntityManager;
use Valitron\Validator;

readonly class CreateCategoryRequestValidate implements RVI
{

    public function __construct(private EntityManager $em) {}

    public function validate(array $data): array
    {
        $v = new Validator($data);
        $v->rule('required', 'name');
        $v->rule('lengthMax', 'name', 50);

        $v
            ->rule(function ($field, $value) {
                return !$this
                    ->em
                    ->getRepository(User::class)
                    ->count(['email' => $value]);
            }, 'name')
            ->message('Category with the given name already exists.');

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }

}
