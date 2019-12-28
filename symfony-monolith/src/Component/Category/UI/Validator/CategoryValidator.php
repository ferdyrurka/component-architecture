<?php
declare(strict_types=1);

namespace App\Component\Category\UI\Validator;

class CategoryValidator
{
    public function validateName(string $name): bool
    {
        return !((bool) preg_match('/^[A-Z|a-z| |0-9|-]{1,255}$/', $name));
    }
}
