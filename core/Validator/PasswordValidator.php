<?php

namespace Core\Validation;

use Exception;

class PasswordValidator implements ValidatorInterface {
    /**
     * @throws Exception
     */
    public function validate(array $data): void{
        $password = $data['password'] ?? '';
        $password2 = $data['password2'] ?? '';

        if(empty($password) || mb_strlen($password) < 8) {
            throw new Exception('password');
        }

        if(empty($password2) || mb_strlen($password2) < 8) {
            throw new Exception('password2');
        }

        if($password !== $password2) {
            throw new Exception('password_mismatch');
        }
    }
}