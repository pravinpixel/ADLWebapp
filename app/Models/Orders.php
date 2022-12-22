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
        'status',
    ];

    public function Tests()
    {
       return $this->hasMany(OrderedTests::class, 'order_id', 'id');
    }
}
