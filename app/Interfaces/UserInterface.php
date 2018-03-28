<?php
namespace App\Interfaces;

interface UserInterface 
{
    public static function instance();
    
    public function getId();
    
    public function getAllContent();
    
//    public function logIn(array $logInDatas);
    
    public function logOut();
    
    public function register(array $registerDatas);
    
    public function editInfo();
}