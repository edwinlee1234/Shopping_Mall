<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Classes\User;

class UserController extends Controller
{
    public function signUpPage() 
    {
        $datas = array(
            'title' => 'Register'
        );
        
        return view('Page/Customer/Register')->with($datas);
    }
    
    public function signUpProcess(Request $request) 
    {
        $inputs = $request->all();
        
        $rules = [
            'name' => 'required|max:50',
            'email' => 'required|max:150|email',
            'password' => 'required|same:passwordConfirm|min:6',
            'passwordConfirm' => 'required|min:6',
            'address' => 'required',
        ];
        
        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $userClass = User::instance();
        $result = $userClass->register($inputs);

        if ($result === true) {

            return redirect('/user/auth/sign-in');
        }
    }
    
    public function signInPage()
    {
        $datas = array(
            'title' => 'Login'
        );

        return view('Page/Customer/Login')->with($datas);  
    }
    
    public function signInProcess(Request $request)
    {
        $inputs = $request->all();

        $rules = [
            'email' => 'required|max:150|email',
            'password' => 'required|min:6',
        ];
        
        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }        
 
        $userClass = User::instance();
        $result = $userClass->logIn($inputs);

        if ($result !== true) {
            return redirect()->back()->withErrors($result)->withInput();
        }
        
        // To Home page
        return redirect()->intended('/');
    }
    
    public function signOut() 
    {
        $userClass = User::instance();
        $retult = $userClass->logOut();
        
        if ($retult === true) {
            
            return redirect('/');
        }
    }
}
