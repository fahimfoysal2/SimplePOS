<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "isbn",
        "name",
        "description",
        "item_status",
        "buying_price",
        "selling_price",
        "inventory_size",
    ];
}
