<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'orders',
        'price',
        'billing_address',
        'payment_method',
        'status',
        'payment_status',
        'receiver_name',
        'receiver_number',
        'date_delivered'
        
    ];

    protected $carts = [
        'orders' => 'array'
    ];

    protected function orders(): CastsAttribute
    {
        return CastsAttribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    } 
}
