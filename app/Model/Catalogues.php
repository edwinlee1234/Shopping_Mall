<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Catalogues extends Model
{
    protected $table = 'catalogues';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        "type",
        "parents",
    ];       
}
