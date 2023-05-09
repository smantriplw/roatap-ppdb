<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Archive extends Authenticatable implements JWTSubject
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
        'address',
        'email',
        'type',
        'religion',
        
        'photo_path',
        'skhu_path',
        'certificate_path',
        'kip_path',
        'kk_path',
        'mutation_path',
        'verificator_id',
    ];

    public function nilai(): HasMany {
        return $this->hasMany(NilaiSemester::class, 'archive_id');
    }

    public function verificator(): BelongsTo {
        return $this->belongsTo(User::class, 'id', 'verificator_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
