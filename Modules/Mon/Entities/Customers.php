<?php

namespace Modules\Mon\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customers extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table ='customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    
    protected $fillable = [
        'name',
        'phone',
        'email',
        'status',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
