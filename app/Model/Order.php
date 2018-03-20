<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        "user_id",
    ];
}
