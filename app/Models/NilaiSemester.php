<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiSemester extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson',
        's1',
        's2',
        's3',
        's4',
        's5',
        'archive_id',
    ];

    public function archive(): BelongsTo {
        return $this->belongsTo(Archive::class, 'id', 'archive_id');
    }
}
