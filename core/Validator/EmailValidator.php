<?php

namespace Core\Validation;

use Core\UserRepository;
use Exception;

class EmailValidator implements ValidatorInterface {
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Exception
     */
    public function validate(array $data): void {
        $email = $data['email'];
        if(empty($email)) {
            throw new Exception('email');
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('email_format');
        }

        if($this->userRepository->existsByEmail($email)) {
            throw new Exception('email_exists');
        }
    }
}