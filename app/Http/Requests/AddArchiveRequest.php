<?php

namespace App\Http\Requests;

use App\Enums\ArchiveTypes;
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
            'nisn' => 'required|numeric|gt:5',
            'name' => 'required|min:3',
            'mother_name' => 'required|min:3',
            'father_name' => 'required|min:3',
            'birthday'    => 'required|date',
            'school'      => 'required',
            'graduated_year' => 'required|numeric',
            'phone'          => 'required',
            'email'          => 'required|email',
            'type'           => [
                'required',
                new Enum(ArchiveTypes::class),
            ],
            'photo' => [
                'required',
                File::image(),
                'size:1000',
            ],
            'skhu' => [
                'required',
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'size:1000',
            ],
            'certificate' => [
                'required_if:type,prestasi',
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'size:1000',
            ],
            'kip' => [
                'required_if:type,afirmasi',
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'size:1000',
            ],
            'mutation' => [
                'required_if:type,mutasi',
                File::types(['pdf', 'jpeg', 'jpg', 'png']),
                'size:1000',
            ],
        ];
    }
}
