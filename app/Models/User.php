<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['userPoint'];

    public function referrals()
    {
        return $this->hasMany(User::class, 'registeredBy');
    }

    public function userPoint()
    {
        return $this->hasOne(Wallet::class, 'userId');
    }
}
