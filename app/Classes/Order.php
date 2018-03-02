<?php
namespace App\Classes;

use App\Interfaces\OrderInterface;

class Order implements OrderInterface 
{
    private static $orderClass;
    
    public static function instance()
    {
        if (self::$orderClass) {
            return self::$orderClass;
        }
        
        self::$orderClass = new self();
        
        return self::$orderClass;
    }
    
    public function getId() 
    {
        return "getId";
    }
    
    public function getAllContent()
    {
        return "getAllContent";
    }
}