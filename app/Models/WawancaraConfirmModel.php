<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WawancaraConfirmModel extends Model
{
    use HasFactory;
    protected $table = 'wawancara_confirm';
    protected $fillable = [
        'archive_id',
        'confirm',
    ];
}
