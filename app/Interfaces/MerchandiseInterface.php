<?php
namespace App\Interfaces;

interface MerchandiseInterface 
{
    public function getId();
    
    public function getAllContent();
    
    public function createMerchandise();
    
    public function editMerchandise();
    
    public function deleteMerchandise();
}