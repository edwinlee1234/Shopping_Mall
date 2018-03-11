<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Order;

class OrderTest extends TestCase
{
    
    public function testGetId()
    {
        $OrderClass = new Order();
        $expect = "getId";
        
        $this->assertEquals($expect, $OrderClass->getId());
    }
    
    public function testGetAllContent()
    {
        $OrderClass = new Order();
        $expect = "getAllContent";
        
        $this->assertEquals($expect, $OrderClass->getAllContent());
    }    
}
