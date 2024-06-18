<?php

namespace App\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ObjectValidator
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Check object is valid
     */
    public function isValid(object $object): bool
    {
        $errors = $this->validator->validate($object);

        if (count($errors) > 0) {
            return false;
        }

        return true;
    }
}
