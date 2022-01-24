<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MsUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_type_id',
        'fullname',
        'email',
        'password',
        'address',
        'gender',
    ];

    public function MsUserType(){
        return $this->belongsTo(MsUserType::class);
    }

    public function TrHeader(){
        return $this->hasMany(TrHeader::class);
    }
}
