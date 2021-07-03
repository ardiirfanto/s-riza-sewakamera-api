<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        "user_id",
        "cust_name",
        "cust_address",
        "cust_phone"
    ];

    public $timestamps = false;
}
