<?php

namespace App\Models;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pizza extends Model
{
    use HasFactory;
    protected $fillable=[
        'pizza_id',
        'pizza_name',
        'image',
        'price',
        'publish_status',
        'category_id',
        'discount_price',
        'buy_one_get_one_status',
        'waiting_time',
        'description',
    ];
}
