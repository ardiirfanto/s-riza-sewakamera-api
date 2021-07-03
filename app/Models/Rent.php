<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        "cust_id",
        "invoice_number",
        "book_datetime",
        "payment_datetime",
        "rent_datetime_start",
        "rent_datetime_end",
        "return_datetime",
        "payment_status",
        "payment_file",
    ];

    public $timestamps = false;
}
