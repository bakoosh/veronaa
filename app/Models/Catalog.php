<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'uuid', 'slug', 'picture_path'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function getProductsByUuid($uuid)
    {
        return self::with('products')->where('uuid', $uuid)->first();
    }
}
