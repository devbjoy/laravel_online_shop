<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    public function product_ratings()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
