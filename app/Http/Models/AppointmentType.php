<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use App\Http\Helper;
use DB;
class AppointmentType extends Model
{
	use Userstamps;

    protected $table ="appointment_types";
    protected $guarded =['id'];

    public static function saveTypes($data='')
    {
    	$save=AppointmentType::create([
    		'type_name'=>$data['type_name'],
    		'amount'=>$data['amount'],
    		'color'=>$data['color'],
    		'max_person'=>$data['max_person'],
    		'vat_number'=>$data['vat_number'],
    		'has_variable_price'=>@$data['has_variable_price'],
    		'description'=>$data['description'],
    		'status'=>1,
    		'created_at'=>date('Y-m-d H:i:s'),
    	]);
    	if ($save) {

if (!empty($data['image'])) {

    		$fileName=Helper::imageUpload($save->id,$data['image'],"/image/appointmentType/");
    		DB::table('appointment_types')->where('id',$save->id)->update([
					'image'=>$fileName
				]);
 
}

if (isset($data['person_number'])) {
if (count($data['person_number'])>0) {
    		for ($i=0; $i <sizeof($data['person_number']) ; $i++) { 
    			DB::table('appointment_type_person')
    			->insert([
    				'appointment_type_id'=>$save->id,
    				'person_number'=>$data['person_number'][$i],
    				'amount'=>$data['person_amount'][$i],
    				'status'=>1,
    				'created_at'=>date('Y-m-d H:i:s'),

    			]);
    		}
            }
            }
    		return true;
    	}
    	return false;
    }


public static function editType($data='',$id)
{
	$save=AppointmentType::where('id',$id)->update([
    		'type_name'=>$data['type_name'],
    		'amount'=>$data['amount'],
    		'color'=>$data['color'],
    		'max_person'=>$data['max_person'],
    		'vat_number'=>$data['vat_number'],
    		'has_variable_price'=>@$data['has_variable_price'],
    		'description'=>$data['description'],
    		'status'=>1,
    		'updated_at'=>date('Y-m-d H:i:s'),
    	]);
    	if ($save) {

if (!empty($data['image'])) {

    		$fileName=Helper::imageUpload($id,$data['image'],"/image/appointmentType/");
    		DB::table('appointment_types')->where('id',$id)->update([
					'image'=>$fileName
				]);
 
}
if (isset($data['person_number'])) {
if (count($data['person_number'])>0) {
DB::table('appointment_type_person')->where('appointment_type_id',$id)->delete();

    		for ($i=0; $i <sizeof($data['person_number']) ; $i++) { 
    			DB::table('appointment_type_person')
    			->insert([
    				'appointment_type_id'=>$id,
    				'person_number'=>$data['person_number'][$i],
    				'amount'=>$data['person_amount'][$i],
    				'status'=>1,
    				'created_at'=>date('Y-m-d H:i:s'),

    			]);
    		}
            }
    		}

    		return true;
    	}
    	return false;
}

public static function deleteType($id='')
{
   $data=AppointmentType::where('id',$id)->delete();
   if ($data) {
       DB::table('appointment_type_person')->where('appointment_type_id',$id)->delete();
       return true;
   }
   return false;
}


}
