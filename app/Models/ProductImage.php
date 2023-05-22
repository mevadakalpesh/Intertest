<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class ProductImage extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static $filePath = 'product-images/';

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) =>  (!blank($value))  ? config('constant.storage_path').self::$filePath.$value : config('constant.default_image').$value,
        );
    }
}
