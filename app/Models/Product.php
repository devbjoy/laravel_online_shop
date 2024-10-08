<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function product_images()
    {
        return $this->hasOne(ProductImage::class,'product_id','id');
    }

    public function product_ratings(){
        return $this->hasMany(ProductRating::class)->where('status',1);
    }
}
