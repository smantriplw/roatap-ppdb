<?php

namespace App\Http\Requests;

use App\Rules\ValidDateRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginPesertaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth('archive')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nisn' => ['required', 'regex:/[0-9]{9,12}/'],
            'birth' => ['required', 'integer', new ValidDateRule],
        ];
    }
}
