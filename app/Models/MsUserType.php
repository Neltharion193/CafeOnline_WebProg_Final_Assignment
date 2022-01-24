<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsUserType extends Model
{
    use HasFactory;

    public function MsUser(){
        return $this->hasMany(MsUser::class);
    }
}
