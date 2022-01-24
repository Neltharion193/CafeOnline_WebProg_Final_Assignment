<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrHeader extends Model
{
    use HasFactory;

    public function TrDetail(){
        return $this->hasMany(TrDetail::class);
    }

    public function MsUser(){
        return $this->belongsTo(MsUser::class);
    }
}
