<?php
namespace App\Interfaces;

interface OrderInterface 
{
    const CART = "C";
    const NOT_PAY = "N";
    const PAYED = "Y";
    const CANCEL_ORDER = 'X';

    public static function instance();
    
    public function getId();
    
    public function getAllContent();
}