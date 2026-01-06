<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolReturnFedexFieldMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'fedex_field',
        'our_field',
        'common_value',
        'description',
    ];
}
