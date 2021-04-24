<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use DB;
class Client extends Model
{
	use Userstamps;

    protected $table ="users";
    protected $guarded =['id'];

public static function saveClient($data='')
{
	$save=Client::create([
		'first_name'=>$data['fname'],
		'last_name'=>$data['last_name'],
		'email'=>$data['email'],
		'password'=>bcrypt('phone_number'),
		'vat_number'=>$data['vat_number'],
		'role_id'=>0,
		'user_type'=>2,
		'phone_number'=>$data['phone_number'],
		'created_at'=>date('Y-m-d H:i:s'),
	]);
	if ($save) {
	DB::table('user_address')->insert([
		'user_id'=>$save->id,
		'invoice_address'=>$data['i_address'],
		'post_code'=>$data['i_code'],
		'city'=>$data['i_city'],
		'country_name'=>$data['i_country'],
		'shipping_address'=>$data['s_address'],
		'shipping_post_code'=>$data['s_code'],
		'shopping_city'=>$data['s_city'],
		'shipping_country_name'=>$data['s_country'],
		'status'=>1,
	]);

	return true;
	}
	return false;
}


public static function updateClient($data='',$id)
{
	$save=Client::where('id',$id)->update([
		'first_name'=>$data['fname'],
		'last_name'=>$data['last_name'],
		'email'=>$data['email'],
		'password'=>bcrypt('phone_number'),
		'vat_number'=>$data['vat_number'],
		'role_id'=>0,
		'user_type'=>2,
		'phone_number'=>$data['phone_number'],
		'created_at'=>date('Y-m-d H:i:s'),
	]);
	if ($save) {
	DB::table('user_address')->where('user_id',$id)->update([
		'invoice_address'=>$data['i_address'],
		'post_code'=>$data['i_code'],
		'city'=>$data['i_city'],
		'country_name'=>$data['i_country'],
		'shipping_address'=>$data['s_address'],
		'shipping_post_code'=>$data['s_code'],
		'shopping_city'=>$data['s_city'],
		'shipping_country_name'=>$data['s_country'],
		'status'=>1,
	]);

	return true;
	}
	return false;
}

public static function clientAddress($id='')
{
	$data=DB::table('user_address')->where('user_id',$id)->first();
	return $data;
}

public static function deleteclient($id='')
{
	$result=Client::where('id',$id)->delete();
	if ($result) {
	DB::table('user_address')->where('user_id',$id)->delete();
	return true;
	}
	return false;
}


}
