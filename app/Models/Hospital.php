<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_title',
        'organization_name',
        'organization_type',
        'contact_person_name',
        'email',
        'how_to_address',
        'valentine_card_count',
        'extra_staff_cards',
        'street',
        'city',
        'county',
        'state',
        'zip',
        'phone',
        'standing_order',
        'public_notes',
        'internal_notes',
        'prefilled_link',
        'update_status',
        'updated_at',
        'token'
    ];

    protected $casts = [
        'valentine_card_count' => 'integer',
        'extra_staff_cards' => 'integer',
        'standing_order' => 'boolean',
        'email_status' => 'boolean',
        'update_status' => 'boolean',
    ];

    public function volunteer() {
        return $this->belongsTo(Volunteer::class);
    }
}
