<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartHeader extends Model
{
    use HasFactory;

    public function CartDetail(){
        return $this->hasMany(CartDetail::class);
    }

    public function MsUser(){
        return $this->belongsTo(MsUser::class);
    }
}
