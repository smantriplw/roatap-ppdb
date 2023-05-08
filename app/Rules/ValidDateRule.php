<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $formats = explode(',', $value);
        if (count($formats) !== 2) {
            $fail('The :attribute doesn\'t valid');
        }

        try {
            Carbon::parseFromLocale($formats[1], config('app.timezone'));
        } catch (\Exception $e) {
            $fail('invalid date');
        }
    }
}
