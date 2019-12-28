<?php

namespace App;

use App\Http\Resources\Wallet;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Movement extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;    

    protected $fillable = [
        'id',
        'wallet_id',
        'type',
        'transfer',
        'transfer_movement_id',
        'transfer_wallet_id',
        'type_payment',
        'category_id',
        'iban',
        'mb_entity_code',
        'mb_payment_reference',
        'description',
        'source_description',
        'date',
        'start_balance',
        'end_balance',
        'value',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     public function wallet()
     {
         return $this->belongsTo(Wallet::class);
     }
     public function category()
     {
         return $this->belongsTo(Category::class);
     }

}


