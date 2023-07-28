<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariablesModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'category',
        'publicable',
    ];

    protected $table = 'variables';

    protected function value(): Attribute {
        return Attribute::make(
            get: fn (string $value) => $value,
            set: function (mixed $value) {
                if (is_array($value)) {
                    return json_encode($value);
                } else {
                    return $value;
                }
            }
        );
    }
}
