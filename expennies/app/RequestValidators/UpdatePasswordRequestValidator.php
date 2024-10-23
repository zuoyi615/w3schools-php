<?php

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Entity\User;
use App\Exception\ValidationException;
use Valitron\Validator;

class UpdatePasswordRequestValidator implements RequestValidatorInterface
{

    public function validate(array $data): array
    {
        /** @var User $user */
        $user = $data['user'];
        $v    = new Validator($data);

        $v->rule('required', ['currentPassword', 'newPassword']);
        $v->rule('lengthMin', 'newPassword', 4)->label('Password');
        $v
            ->rule(fn() => password_verify($data['currentPassword'], $user->getPassword()), 'currentPassword')
            ->message('Invalid current password');

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }

}
