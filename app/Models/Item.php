<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        "category_id",
        "item_name",
        "item_stock",
        "item_price"
    ];

    public $timestamps = false;
}
