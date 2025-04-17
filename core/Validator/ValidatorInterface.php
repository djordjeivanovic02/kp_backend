<?php

namespace Core\Validator;

interface ValidatorInterface {
    public function validate(array $data): void;
}