<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedBack extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "name",
        "mobile",
        "email",
        "location",
        "message",
        'remark',
        "corporate_id",
        "reg_no",
        "branch"
    ];
}
