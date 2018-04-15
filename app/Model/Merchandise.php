<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    protected $table = 'merchandises';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        "status",
        "name_tw",
        "name_cn",
        "name_en",
        "introduction",
        "brand",
        "type",
        "photos",
        "price",
        "remain_count",
        "extra_info",
    ];    
}
