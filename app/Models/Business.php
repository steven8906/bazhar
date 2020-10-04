<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $table    = 'business';
    protected $fillable = [
      'name',
      'name_contact',
      'last_name_contact',
      'nit',
      'phone',
      'address',
      'name_logo',
      'url_logo',
    ];
}
