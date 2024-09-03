<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategorie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categoryName(){

        return $this->hasOne(Categorie::class,'id','category_id'); 
    }
}
