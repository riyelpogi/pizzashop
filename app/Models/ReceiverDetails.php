<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiverDetails extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','receiver_name', 'receiver_mobile_number'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
