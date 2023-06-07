<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyModel extends Model
{
    use HasFactory;

    protected $table = 'verifies';
    protected $fillable = [
        'isSafe',
        'message',
    ];
}
