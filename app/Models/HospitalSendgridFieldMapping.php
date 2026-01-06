<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalSendgridFieldMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'sendgrid_field',
        'our_field',
        'common_value',
        'description',
    ];
}
