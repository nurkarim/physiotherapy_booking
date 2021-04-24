<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ClientRequest;
use Auth;
use Session;
use App\Http\Models\Country;
use App\User;
use Mail;
use App\Http\Models\Company;
class LoginController extends Controller
{

   public function logout()
    {
    	Auth::logout();
     return redirect('login');
        
    }
     public function index()
    {
if (Auth::check()) {
    if (Auth::user()->user_type==1||Auth::user()->user_type==3) {
       return redirect('dashboard');
    }elseif (Auth::user()->user_type==2) {
         return redirect('my-account');
    }
}
    	return view('auth.login');
        
    }

	public function checkLogin(LoginRequest $request)
	{
    	$credential = ['email' => $request->email,'password' => $request->password];
        if (Auth::attempt($credential)) {
if (Auth::user()->user_type==1||Auth::user()->user_type==3) {
		return redirect()->intended('dashboard');
}elseif (Auth::user()->user_type==2) {
    return redirect()->intended('my-account');
}else{
    Auth::logout();
   Session::flash('flash_error', 'Your Given Credential Is Wrong.');
            return redirect('login'); 
}
}else{
			Session::flash('flash_error', 'Your Given Credential Is Wrong.');
    		return redirect('login');
		}
	}


public function createAccount()
{
        $country=Country::all();
    return view("auth.register",compact('country'));
}

public function saveAccount(ClientRequest $request)
{
   $save=User::saveNewAccount($request->all());

   if ($save) {
       $request->session()->flash('success',"create new account successfully.Please check your email and login");

       $email=$request->email;
$name=$request->first_name;
$namelst=$request->last_name;
$data=array('email'=>$email,'name'=>$name,'namelst'=>$request->last_name);
$cmp=Company::where('id_number',123)->first();

 $res=Mail::send('email.newCustomer',compact('data','cmp'), function($message)use ($data) {
         $message->to($data['email'], $data['name'])->subject
            ('New Account Create');
         $message->from('info@jemkin.be','Jemkine');
      });

   }else{
    $request->session()->flash('error', "opps!sorry account create unsuccessfully");
   }

   return redirect('login');
}

}
