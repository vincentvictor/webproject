<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use App\Mail\MyEmail;

class loginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(Request $req) 
    {
    	$username = $req->input('username');
    	$password = $req->input('password');

    	
    	$checkLogin = DB::table('users')->where(['username'=>$username, 'password'=>$password])->get();
    		
    	if(count($checkLogin) > 0)
    	{
    		echo 'Login successful';
    		print_r($req->input());
    	}
    	else
    	{
    		echo 'Login failed wrong password';
    	}
    	
    }

 
}
