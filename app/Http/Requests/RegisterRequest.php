<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required_without:email|min:4|max:20',
            'password' => 'required|min:7|max:30',
            'email' => 'required_without:username|unique|max:255',
            'status' => [
                'required',
                'integer',
                Rule::in([1, 2, 0]),
            ],
        ];
    }
}
