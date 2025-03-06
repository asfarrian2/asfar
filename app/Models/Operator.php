<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Operator extends Authenticatable
{    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "tb_operator";
    protected $primaryKey = "id_operator";
    public $incrementing = false;
    protected $fillable = [
        'id_operator',
        'username',
        'id_agency',
        'id_tahun',
        'password'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}


