<?php

namespace App\Http\Requests;

use App\Enums\ArchiveTypes;
use App\Enums\LessonTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\File;

class AddArchiveRequest extends FormRequest
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
            'nik' => 'required|numeric|regex:/^[0-9]{16}$/',
            'nisn' => 'required|numeric|regex:/^[0-9]{10}$/',
            'name' => 'required|min:3',
            'mother_name' => 'required|min:3',
            'father_name' => 'required|min:3',
            'birthday'    => 'required|date',
            'school'      => 'required',
            'graduated_year' => 'required|integer',
            'phone'          => ['required', 'regex:/^(62|0)[0-9]{11}$/'],
            'email'          => 'required|email',
            'type'           => [
                'required',
                new Enum(ArchiveTypes::class),
            ],
            'photo' => [
                'required',
                File::image(),
                'max:1024',
            ],
            'skhu' => [
                'required',
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'max:1024',
            ],
            'certificate' => [
                'required_if:type,prestasi',
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'max:1024',
            ],
            'kip' => [
                'required_if:type,afirmasi',
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'max:1024',
            ],
            'mutation' => [
                'required_if:type,mutasi',
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'max:1024',
            ],
            'kk' => [
                'required_if:type,zonasi',
                File::types(['pdf', 'png', 'jpg', 'jpeg']),
                'max:1024',
            ],
        ];
    }
}
