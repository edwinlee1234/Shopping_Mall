<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\User;

class UserTest extends TestCase
{
    
    public function testGetId()
    {
        $userClass = new User();
        $expect = "getId";
        
        $this->assertEquals($expect, $userClass->getId());
    }
    
    public function testGetAllContent()
    {
        $userClass = new User();
        $expect = "getAllContent";
        
        $this->assertEquals($expect, $userClass->getAllContent());
    }    
    
    public function testLogIn()
    {
        $userClass = new User();
        $expect = "logIn";
        
        $this->assertEquals($expect, $userClass->logIn());
    } 
    
    public function testLogOut()
    {
        $userClass = new User();
        $expect = "logOut";
        
        $this->assertEquals($expect, $userClass->logOut());
    } 
    
    public function testRegister()
    {
        $userClass = new User();
        $expect = "register";
        
        $this->assertEquals($expect, $userClass->register());
    }  
    
    public function testEditInfo()
    {
        $userClass = new User();
        $expect = "editInfo";
        
        $this->assertEquals($expect, $userClass->editInfo());
    }  
}