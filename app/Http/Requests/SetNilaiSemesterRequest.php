<?php

namespace App\Http\Requests;

use App\Enums\LessonTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SetNilaiSemesterRequest extends FormRequest
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
            'lesson' => ['required', new Enum(LessonTypes::class)],
            's1' => ['required', 'integer', 'min:0', 'max:100'],
            's2' => ['required', 'integer', 'min:0', 'max:100'],
            's3' => ['required', 'integer', 'min:0', 'max:100'],
            's4' => ['required', 'integer', 'min:0', 'max:100'],
            's5' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }
}
