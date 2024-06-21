<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id'];


    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
