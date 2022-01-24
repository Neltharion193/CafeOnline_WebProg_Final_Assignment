<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrDetail extends Model
{
    use HasFactory;

    public function TrHeader(){
        return $this->belongsTo(TrHeader::class);
    }

    public function MsProduct(){
        return $this->belongsTo(MsProduct::class);
    }
}
