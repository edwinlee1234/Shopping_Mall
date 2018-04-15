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
    
    public function infoPage()
    {
        $datas = array(
            'title' => 'Info'
        );

        return view('Page/Customer/Infos')->with($datas);        
    }
    
    public function contactPage()
    {
        $datas = array(
            'title' => 'Contact'
        );

        return view('Page/Customer/Contact')->with($datas);        
    }
}

