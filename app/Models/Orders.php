<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'razorpay_order_id',
        'user_id',
        'appoinment',
        'datetime',
        'payment_status',
        'order_status',
        'order_response'
    ];

    public function Tests()
    {
       return $this->hasMany(OrderedTests::class, 'order_id', 'id');
    }

    public function User()
    {
       return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}
