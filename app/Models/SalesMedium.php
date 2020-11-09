<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMedium extends Model
{
    use HasFactory;
    protected $table  = 'sales_medium';
    protected $fillable = [
        'name',
        'utility_percent',
    ];
}
