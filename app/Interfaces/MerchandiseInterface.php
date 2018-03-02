<?php
namespace App\Interfaces;

interface MerchandiseInterface 
{
    public static function instance();
    
    public function getId();
    
    public function getAllContent();
    
    public function createMerchandise(array $merchandiseDatas);
    
    public function editMerchandise(array $merchandiseDatas);
    
    public function deleteMerchandise();
}