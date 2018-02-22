<?php
namespace App\Interfaces;

interface UserInterface 
{
    public function getId();
    
    public function getAllContent();
    
    public function logIn();
    
    public function logOut();
    
    public function register();
    
    public function editInfo();
}