<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DaftarUlangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $auth = auth('archive');

        if ($auth->check()) {
            return isset($auth->user()->verificator_id);
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $educations = [
            'D1', 'D2', 'D3', 'D4',
            'Informal', 'Lainnya', 'Non formal',
            'Paket A', 'Paket B', 'Paket C', 'PAUD',
            'Putus SD', 'S1', 'S2', 'S2 Terapan', 'S3',
            'SD', 'SMP', 'Sp-1','Sp-2', 'Tidak sekolah', 'TK',
        ];
        $jobs = [
            'Tidak bekerja', 'Nelayan', 'Petani', 'Peternak',
            'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang Kecil', 'Pedagang Besar',
            'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan', 'Tenaga Kerja Indonesia',
            'Karyawan BUMN', 'Tidak dapat diterapkan', 'Sudah Meninggal', 'Lainnya',
        ];
        $salaries = [
            '< Rp.500.000', 'Rp.500.000 - Rp.999.999', 'Rp.1.000.000 - Rp.1.999.999',
            'Rp.2.000.000 - Rp.4.999.999', 'Rp.5.000.000 - Rp.20.000.000',
            '> Rp.20.000.000', 'Tidak Berpenghasilan',
        ];

        return [
            'no_kk' => 'required|regex:/^[0-9]{16}$/',
            'kabupaten' => 'required|max:255',
            'kecamatan' => 'required|max:255',
            'no_kip' => 'sometimes|numeric',
            
            'height_body' => 'required|numeric|min:30',
            'width_body' => 'required|numeric',
            'head_circumference' => 'required|numeric',
            'school_distance' => 'required|numeric',
            'school_est_time' => 'required|numeric',
            'siblings' => 'required|numeric|min:1',
            'siblings_position' => 'required|numeric',

            'transportation' => ['required', Rule::in([
                'Jalan Kaki', 'Angkutan umum/bus/pete-pete', 'Mobil/bus antar jemput',
                'Kereta Api', 'Ojek', 'Andong/bendi/sado/dokar/delman/becak',
                'Perahu penyeberangan/rakit/getek', 'Kuda', 'Sepeda',
            ])],
            'live' => ['required', Rule::in([
                'Bersama orang tua', 'Wali', 'Kost', 'Asrama',
                'Panti Asuhan', 'Pesantren', 'Lainnya',
            ])],
            
            'nik_mother' => 'required|regex:/^[0-9]{16}$/',
            'birth_mother' => 'required|numeric',
            'job_mother' => ['required', Rule::in($jobs)],
            'last_edu_mother' => ['required', Rule::in($educations)],
            'salary_mother' => ['required', Rule::in($salaries)],
            
            'nik_father' => 'required|regex:/^[0-9]{16}$/',
            'birth_father' => 'required|numeric',
            'job_father' => ['required', Rule::in($jobs)],
            'last_edu_father' => ['required', Rule::in($educations)],
            'salary_father' => ['required', Rule::in($salaries)],

            'nik_wali' => 'sometimes|regex:/^[0-9]{16}$/',
            'birth_wali' => 'sometimes|numeric',
            'job_wali' => ['sometimes', Rule::in($jobs)],
            'last_edu_wali' => ['sometimes', Rule::in($educations)],
            'salary_wali' => ['sometimes', Rule::in($salaries)],
        ];
    }
}
