<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() 
    {
        $datas = array(
            'title' => 'Shopping Mall'
        );

        return view('Page/Customer/Home')->with($datas);
    }
    
    public function adminIndex()
    {
        $datas = array(
            'title' => 'Admin'
        );

        return view('Page/Admin/Home')->with($datas);
    }
}

