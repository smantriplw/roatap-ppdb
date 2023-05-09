<?php

namespace App\Http\Requests;

use App\Enums\GenderTypes;
use App\Enums\ReligionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditDetailsArchiveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('archive')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nik' => 'required|regex:/^[0-9]{16}$/',
            'address' => ['required', 'min:6'],
            'name' => 'required|min:3',
            'mother_name' => 'required|min:3',
            'father_name' => 'required|min:3',
            'school'      => 'required',
            'graduated_year' => 'required|integer',
            'phone'          => ['required', 'regex:/^(08[0-9]{9,10})$/'],
            'email'          => 'required|email',
            'religion'       => ['required', Rule::enum(ReligionTypes::class)],
            'gender'         => ['required', Rule::enum(GenderTypes::class)],
        ];
    }
}
