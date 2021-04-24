<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use DB;
class Role extends Model
{
	use Userstamps;


    protected $guarded =['id'];

    public static function saveRole($data='')
    {
    	$role=Role::create([
    		'role_name'=>$data['type_name'],
    		'status'=>1,
    	]);
    	if ($role) {
    	for ($i=0; $i <sizeof($data['menu_name']) ; $i++) { 
  		$menu_id=explode("_", $data['menu_name'][$i]);

  		DB::table('permission')->insert([
  			'role_id'=>$role->id,
  			'route'=>$menu_id[0],
  		]);
		DB::table('roles_menu')->insert([
  			'role_id'=>$role->id,
  			'menu_id'=>$menu_id[1],
  		]);
  		}

   	for ($j=0; $j <sizeof($data['sub_menu_name']) ; $j++) { 
  		$submenu_id=explode("_", $data['sub_menu_name'][$j]);

  		DB::table('permission')->insert([
  			'role_id'=>$role->id,
  			'route'=>$submenu_id[0],
  		]);
		DB::table('roles_submenu')->insert([
  			'role_id'=>$role->id,
  			'menu_id'=>$submenu_id[2],
  			'sub_menu_id'=>$submenu_id[1],
  		]);
  		}
  		return true;
    	}
    	return false;
    }

public static function roleMenu($id='')
{
  $data=DB::table('roles_menu')->where('role_id',$id)->get();
  return $data;
}

public static function roleSubMenu($id='')
{
  $data=DB::table('roles_submenu')->where('role_id',$id)->get();
  return $data;
}


    public static function updatedRole($data='',$id)
    {
      $role=Role::where('id',$id)->update([
        'role_name'=>$data['type_name'],
        'status'=>1,
      ]);
      if ($role) {
        DB::table('permission')->where('role_id',$id)->delete();
        DB::table('roles_menu')->where('role_id',$id)->delete();

      for ($i=0; $i <sizeof($data['menu_name']) ; $i++) { 
      $menu_id=explode("_", $data['menu_name'][$i]);

      DB::table('permission')->insert([
        'role_id'=>$id,
        'route'=>$menu_id[0],
      ]);
    DB::table('roles_menu')->insert([
        'role_id'=>$id,
        'menu_id'=>$menu_id[1],
      ]);
      }

    DB::table('roles_submenu')->where('role_id',$id)->delete();

    for ($j=0; $j <sizeof($data['sub_menu_name']) ; $j++) { 
      $submenu_id=explode("_", $data['sub_menu_name'][$j]);

      DB::table('permission')->insert([
        'role_id'=>$id,
        'route'=>$submenu_id[0],
      ]);
      
    DB::table('roles_submenu')->insert([
        'role_id'=>$id,
        'menu_id'=>$submenu_id[2],
        'sub_menu_id'=>$submenu_id[1],
      ]);
      }
      return true;
      }
      return false;
    }

public static function deleteRole($id='')
{
  $delete=Role::where('id',$id)->delete();
  if ($delete) {
   
  DB::table('roles_submenu')->where('role_id',$id)->delete();
  DB::table('permission')->where('role_id',$id)->delete();
  DB::table('roles_menu')->where('role_id',$id)->delete();
  return true;
  }
  return false;
}


}