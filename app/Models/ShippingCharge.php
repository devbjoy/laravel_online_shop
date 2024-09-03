<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingCharge extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function shipping_charge(){
        return $this->hasOne(Country::class,'id','country_id');
    }
}
