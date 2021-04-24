<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Role;
use App\Http\Models\Country;
use App\User;
use App\Http\Requests\ClientRequest;

class UserController extends Controller
{
   public function index()
   {
   	$users=User::join('roles','users.role_id','=','roles.id')->select('users.*','roles.role_name')->where('users.user_type',3)->get();
   	return view('backend.user.index',compact('users'));
   }

   public function create()
   {
   	$role=Role::all();
   	$country=Country::all();
   	return view('backend.user.create',compact('role','country'));
   }

   public function edit($id)
   {
   	$role=Role::all();
   	$country=Country::all();
   	$user=User::find($id);
   	$address=User::userAddress($id);
   	return view('backend.user.edit',compact('role','country','user','address'));
   }

   public function store(ClientRequest $request)
   {
   	$save=User::saveUser($request->all());
   	if ($save==true) {
    		$request->session()->flash('success', " create successfully");
    	}else{
    		$request->session()->flash('error', "Sorry!! create Unsuccessfully");
    	}

    	return redirect('users');
   }   

   public function update(Request $request,$id)
   {
   	$save=User::updateUser($request->all(),$id);
   	if ($save==true) {
    		$request->session()->flash('success', " edit successfully");
    	}else{
    		$request->session()->flash('error', "Sorry!! edit Unsuccessfully");
    	}

    	return redirect('users');
   }



}
