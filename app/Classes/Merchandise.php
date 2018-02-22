<?php
namespace App\Classes;

use App\Interfaces\MerchandiseInterface;

class Merchandise implements MerchandiseInterface 
{
    public function getId() 
    {
        return "getId";
    }
    
    public function getAllContent()
    {
        return "getAllContent";
    }
    
    public function createMerchandise()
    {
        return "createMerchandise";
    }
    
    public function editMerchandise()
    {
        return "editMerchandise";
    }
    
    public function deleteMerchandise()
    {
        return "deleteMerchandise";
    }   
}