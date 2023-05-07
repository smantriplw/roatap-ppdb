<?php

namespace App\Http\Requests;

use App\Enums\ArchiveTypes;
use App\Rules\grecaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CheckArchiveRequest extends FormRequest
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
            'nisn' => 'required|numeric|regex:/^[0-9]{10}$/',
            'type' => [
                'required',
                new Enum(ArchiveTypes::class),
            ],
            '_gtoken' => [
                'required',
                new grecaptcha,
            ],
        ];
    }
}
