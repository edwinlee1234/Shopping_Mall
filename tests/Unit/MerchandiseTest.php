<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Merchandise;

class MerchandiseTest extends TestCase
{
    
    public function testGetId()
    {
        $MerchandiseClass = new Merchandise();
        $expect = "getId";
        
        $this->assertEquals($expect, $MerchandiseClass->getId());
    }
    
    public function testGetAllContent()
    {
        $MerchandiseClass = new Merchandise();
        $expect = "getAllContent";
        
        $this->assertEquals($expect, $MerchandiseClass->getAllContent());
    }
    
    public function testCreateMerchandise()
    {
        $MerchandiseClass = new Merchandise();
        $expect = "createMerchandise";
        
        $this->assertEquals($expect, $MerchandiseClass->createMerchandise());
    }  
    
    public function testEditMerchandise()
    {
        $MerchandiseClass = new Merchandise();
        $expect = "editMerchandise";
        
        $this->assertEquals($expect, $MerchandiseClass->editMerchandise());
    }    
    
    public function testDeleteMerchandise()
    {
        $MerchandiseClass = new Merchandise();
        $expect = "deleteMerchandise";
        
        $this->assertEquals($expect, $MerchandiseClass->deleteMerchandise());
    }       
}
