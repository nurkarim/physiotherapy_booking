<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Session;
use Auth;
class MyAccount extends Model
{

public static function selectAppointment()
{
	$data=DB::table('appointments')
	->where('user_id',Auth::user()->id)
	->where('active_status','1')
	->orderBy('id','DESC')
	->paginate(20);

	return $data;
}

public static function selectWhereAppointment($id)
{
	$data=DB::table('appointments')
	->where('id',$id)
	->first();
	return $data;
}



}
