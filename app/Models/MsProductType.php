<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsProductType extends Model
{
    use HasFactory;

    public function MsProduct(){
        return $this->hasMany(MsProduct::class);
    }
}
