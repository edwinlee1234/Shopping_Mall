<?php
namespace App\Interfaces;

interface OrderInterface 
{
    public static function instance();
    
    public function getId();
    
    public function getAllContent();
}