<?php

namespace Core\Validator;

use Core\Validation\ValidatorInterface;
use Exception;

class MaxMindValidator implements ValidatorInterface{
    /**
     * @throws Exception
     */
    public function validate(array $data): void{
        $email = $data['email'] ?? '';
        $ip = $data['ip'] ?? '';

        if(str_contains($email, 'fraud') || $ip === '127.0.0.66') {
            throw new Exception('maxmind_blocked');
        }
    }
}