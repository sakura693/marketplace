<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable; /*追加*/

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use Billable; /*追加*/

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     /*fillableにしないと値が書き換えられない！*/
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'postal_code',
        'address',
        'building',  
        'stripe_id',
        'pm_type', 
        'pm_last_four', 
        'trial_ends_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
