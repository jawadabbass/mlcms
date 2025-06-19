<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckIfFavicon implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value->getClientOriginalExtension() != 'ico' && $value->getClientOriginalExtension() != 'png') {
            $fail('Please select favicon file.');
        }
    }
}
