<?php
namespace App\Classes;

use App\Interfaces\UserInterface;

class User implements UserInterface 
{
    public function getId() 
    {
        return "getId";
    }
    
    public function getAllContent()
    {
        return "getAllContent";
    }
    
    public function logIn()
    {
        return "logIn";
    }
    
    public function logOut()
    {
        return "logOut";
    }
    
    public function register()
    {
        return "register";
    }
    
    public function editInfo()
    {
        return "editInfo";
    }    
}