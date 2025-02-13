<?php

namespace App\Http\Validation;

use Illuminate\Contracts\Validation\ValidationRule;

final class AnimalValidationRules
{
    /**
     * @var ValidationRule|array|string
     */
    const VALID_ANIMAL_NAME = ["required", "unique:animals,name", "max:255"];

    private function __construct()
    {
    }
}
