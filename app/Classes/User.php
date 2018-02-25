<?php
namespace App\Classes;

use App\Interfaces\UserInterface;
use App\Model\User as UserModel;
use Illuminate\Support\Facades\Hash;

class User implements UserInterface 
{
    private static $userClass;
    
    public static function instance()
    {
        if (self::$userClass) {
            return self::$userClass;
        }
        
        self::$userClass = new self();
        
        return self::$userClass;
    }
    
    public function getId() 
    {
        return "getId";
    }
    
    public function getAllContent()
    {
        return "getAllContent";
    }
    
    public function adminLogIn(array $logInDatas)
    {
        $errorMessage = array();

        $user = UserModel::where('email', $logInDatas['email'])
        ->where('type', 'A')->first();
        
        if (count($user) <= 0) {
            $errorMessage['email'] = 'Email address does not exist';
            
            return $errorMessage;
        }

        $isPasswordCorrect = Hash::check($logInDatas['password'], $user->password);
        
        if (!$isPasswordCorrect) {
            $errorMessage['email'] = 'Email or Password Wrong';
            
            return $errorMessage;
        }
        
        session()->put('admin_info', array(
            'id' => $user->id, 
            'name' => $user->name,
        ));

        return true;        
    }
    
    public function logIn(array $logInDatas)
    {
        $errorMessage = array();

        $user = UserModel::where('email', $logInDatas['email'])->first();
        
        if (count($user) <= 0) {
            $errorMessage['email'] = 'Email address does not exist';
            
            return $errorMessage;
        }

        $isPasswordCorrect = Hash::check($logInDatas['password'], $user->password);
        
        if (!$isPasswordCorrect) {
            $errorMessage['email'] = 'Email or Password Wrong';
            
            return $errorMessage;
        }
        
        session()->put('user_info', array(
            'id' => $user->id, 
            'name' => $user->name,
        ));

        return true;
    }
    
    public function logOut()
    {
        session()->forget('user_info');
        
        return true;
    }
    
    public function register(array $registerDatas)
    {
        if (count($registerDatas) <= 0) {
            
            return false;
        }
        
        $registerDatas['password'] = Hash::make($registerDatas['password']);
        UserModel::create($registerDatas);

        return true;
    }
    
    public function editInfo()
    {
        return "editInfo";
    }    
}