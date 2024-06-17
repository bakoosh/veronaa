<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricesByGroup extends Model
{
    use HasFactory;

    protected $fillable = ['extra_charge', 'name', 'price'];
}
