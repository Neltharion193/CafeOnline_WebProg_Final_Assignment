<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsProduct extends Model
{
    use HasFactory;

    public function MsProductType(){
        return $this->belongsTo(MsProductType::class);
    }

    public function TrDetail(){
        return $this->hasMany(TrDetail::class);
    }

    public function CartDetail(){
        return $this->hasMany(CartDetail::class);
    }
}
