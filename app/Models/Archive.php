<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Archive extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nik',
        'nisn',
        'name',
        'mother_name',
        'father_name',
        'birthday',
        'school',
        'graduated_year',
        'phone',
        'email',
        'type',
        
        'photo_path',
        'skhu_path',
        'certificate_path',
        'kip_path',
        'kk_path',
        'mutation_path',
        'verificator_id',
    ];

    protected $casts = [
        'birthday' => 'date:d/M/Y',
    ];

    public function nilai(): HasMany {
        return $this->hasMany(NilaiSemester::class, 'archive_id');
    }

    public function verificator(): BelongsTo {
        return $this->belongsTo(User::class, 'id', 'verificator_id');
    }
}
