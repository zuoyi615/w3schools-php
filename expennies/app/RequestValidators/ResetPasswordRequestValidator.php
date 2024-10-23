<?php

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exception\ValidationException;
use Valitron\Validator;

class ResetPasswordRequestValidator implements RequestValidatorInterface
{

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['password', 'confirmPassword', 'token']);
        $v->rule('equals', 'confirmPassword', 'password')->label('Confirm Password');

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }

}
