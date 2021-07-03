<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "rent_id",
        "item_id",
        "item_qty",
        "rent_item_price",
    ];

    public $timestamps = false;
}
