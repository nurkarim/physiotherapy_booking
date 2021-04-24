<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Role;
use App\Http\Models\Menu;
class RoleController extends Controller
{
  public function index()
  {
  	 $roles=Role::all();
    return view('backend.role.index',compact('roles'));
  }

  public function create()
  {
  	$menu=Menu::all();
  	$subMenu=Menu::subMenu();
    return view('backend.role.create',compact('menu','subMenu'));
  }  

  public function edit($id)
  {
  	$menu=Menu::all();
  	$subMenu=Menu::subMenu();
  	$role=Role::find($id);
  	$roleMenu=Role::roleMenu($id);
  	$roleSubMenu=Role::roleSubMenu($id);
    return view('backend.role.edit',compact('menu','subMenu','role','roleMenu','roleSubMenu'));
  }

  public function store(Request $request)
  {
  
    $save=Role::saveRole($request->all());
    if ($save==true) {
            $request->session()->flash('success', " create successfully");
        }else{
            $request->session()->flash('error', "Sorry!! create Unsuccessfully");
        }

        return redirect('roles');
    
  }  

  public function update(Request $request,$id)
  {
  
  	$save=Role::updatedRole($request->all(),$id);
  	if ($save==true) {
            $request->session()->flash('success', " edit successfully");
        }else{
            $request->session()->flash('error', "Sorry!! edit Unsuccessfully");
        }

        return redirect('roles');
  	
  }

public function destory($id='')
{
  $result=Role::deleteRole($id);
    if ($result==true) {
      return response()->json(['success'=>true]);
    }else{
      return response()->json(['success'=>false]);
    }
}

}
