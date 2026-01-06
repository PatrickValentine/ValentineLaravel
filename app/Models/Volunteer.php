<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'role',
        'notes',
        'description',
        'linkedin_url',
        'resume_url',
        'classification',
        'needs_school_credit',
    ];

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function hospitals()
    {
        return $this->hasMany(Hospital::class);
    }

}
