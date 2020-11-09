<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_presentation',
        'id_business',
        'id_provider',
        'id_tax',
        'description',
        'priceSell',
        'priceShop',
        'isVariable',
        'currency',
    ];
}
