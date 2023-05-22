<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    //protected $appends =['category_name'];

    protected $casts = [
        "price" => "decimal:2",
        "created_at" =>'date:Y-m-d'
    ];


    public function images(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
    
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
  
  
    
}
