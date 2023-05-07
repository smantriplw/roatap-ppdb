<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class grecaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('app.recaptchaKey'),
            'response' => $value,
        ]);

        if ($response->status() !== 200) {
            $fail('The :attribute doesn\'t valid');
            return;
        }

        if ($response->json(['success']) !== true) {
            $fail('Couldn\'t verify yourself');
        }
    }
}
