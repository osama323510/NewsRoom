<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ForbiddenWordsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    protected array $forbiddenWords = [
        'badword1',
        'badword2'
    ];
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $lowercaseValue = strtolower($value);
        foreach ($this->forbiddenWords as $word) {
            if (str_contains($lowercaseValue, strtolower($word))) {
                $fail("The {$attribute} contains an unallowed or inappropriate word: '{$word}'.");
                break; 
            }
        }
    }
}
