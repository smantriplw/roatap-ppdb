<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DaftarUlangModel extends Model
{
    use HasFactory;

    protected $table = 'daftar_ulang';
    protected $fillable = [
        'no_kk',
        'kabupaten',
        'kecamatan',
        'no_kip',
        'height_body',
        'width_body',
        'head_circumference',
        'school_distance',
        'school_est_time',
        'siblings',
        'siblings_position',
        'transportation',
        'live',

        'nik_father',
        'birth_father',
        'last_edu_father',
        'job_father',
        'salary_father',

        'nik_mother',
        'birth_mother',
        'last_edu_mother',
        'job_mother',
        'salary_mother',

        'nik_wali',
        'birth_wali',
        'last_edu_wali',
        'job_wali',
        'salary_wali',

        'archive_id',
    ];
    public $timestamps = true;

    public function archive(): BelongsTo {
        return $this->belongsTo(Archive::class, 'id', 'archive_id');
    }
}
