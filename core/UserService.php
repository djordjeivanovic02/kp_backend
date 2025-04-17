<?php

namespace Core;

use Core\Validation\ValidatorInterface;

class UserService{
    private array $validators;
    private UserRepository $repo;
    private Mailer $mailer;

    public function __construct(array $validators, UserRepository $repo, Mailer $mailer){
        $this->validators = $validators;
        $this->repo = $repo;
        $this->mailer = $mailer;
    }

    public function register(string $email, string $password, string $password2, string $ip): array{
        $data = compact('email', 'password', 'password2', 'ip');
        foreach ($this->validators as $validator) {
            $validator->validate($data);
        }
        $userId = $this->repo->insert([
            'email' => $email,
            'password' => $password,
            'posted' => 'NOW()'
        ]);

        $this->mailer->sendWelcomeEmail($email);
        $this->repo->insertLog($userId);

        return ['id' => $userId];
    }
}