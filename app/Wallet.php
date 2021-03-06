<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Wallet extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'balance',
        'created_at',
        'updated_at'

        // 'department_id',
    ];

     public function user()
     {
         return $this->belongsTo(User::class,'email');
     }

     public function movement()
     {
         return $this->hasMany(Movement::class);
     }
}


