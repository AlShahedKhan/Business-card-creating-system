<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'first_name',
        'last_name',
        'company_name',
        'position',
        'group_or_individual',
        'emails',  // Now a JSON field
        'phones',  // Now a JSON field
        'websites',  // Now a JSON field
        'social_media_links',  // Now a JSON field
        'address_logo',
        'address',
    ];

     // Casting JSON fields to arrays automatically
     protected $casts = [
        'emails' => 'array',
        'phones' => 'array',
        'websites' => 'array',
        'social_media_links' => 'array',
    ];

    // Add mutator to ensure the address_logo is saved properly
    public function setAddressLogoAttribute($value)
    {
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            // Store the logo if it's an uploaded file
            $this->attributes['address_logo'] = $value->store('logos', 'public');
        } else {
            // If it's a file path, store it as-is
            $this->attributes['address_logo'] = $value;
        }
    }

}
