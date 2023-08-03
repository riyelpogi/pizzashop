<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'province',
        'city',
        'region',
        'postal_id',
        'barangay',
        'street_name'
    ];
}
