<?php

namespace Core\Validation;

interface ValidatorInterface {
    public function validate(array $data): void;
}