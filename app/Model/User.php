<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        "name",
        "email",
        "password",
        "address",
    ];
}