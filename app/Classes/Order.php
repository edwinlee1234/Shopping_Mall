<?php
namespace App\Classes;

use App\Interfaces\OrderInterface;

class Order implements OrderInterface 
{
    public function getId() 
    {
        return "getId";
    }
    
    public function getAllContent()
    {
        return "getAllContent";
    }
}