<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'position',
        'email',
        'phone',
        'address',
        'website',
    ];
}
