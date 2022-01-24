<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    public function CartHeader(){
        return $this->belongsTo(CartHeader::class);
    }

    public function MsProduct(){
        return $this->belongsTo(MsProduct::class);
    }
}
