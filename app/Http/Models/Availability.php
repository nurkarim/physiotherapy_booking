<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use DB;
class Availability extends Model
{
	use Userstamps;

    protected $table ="availabilitys";
    protected $guarded =['id'];

    public static function selectTime()
    {
    	$data=DB::table('times')
    		->get();
    		return $data;
    }

  public static function saveUnavailability($data='')
    {
    	for ($i=0; $i < sizeof($data['day_time']) ; $i++) { 
    	DB::table('days_unavailability')->insert([
    		'date'=>$data['day_date'],
    		'time'=>$data['day_time'][$i],
    	]);
    	}	
    		return true;
    }

public  static function selectUnavailable($date)
{
	$data=DB::table('days_unavailability')
    ->join('times','days_unavailability.time','=','times.id')
    ->select('days_unavailability.*','times.name as timename')
		->where('days_unavailability.date',$date)
		->get();

		return $data;
}


  public static function saveAvailability($data='')
    {
    	for ($i=0; $i < sizeof($data['day_time']) ; $i++) { 

        DB::table('days_unavailability')
        ->where('date',$data['day_date'])
        ->where('time',$data['day_time'][$i])
        ->delete();
    	}	
    		return true;
    }
public  static function selectAvailable($date)
{
	$data=DB::table('days_availability')
		->where('date',$date)
		->get();

		return $data;
}



public  static function saveDateRange($data='')
{
    $save=DB::table('date_range')
        ->insert([
            'start_date'=>$data['start_date'],
            'end_date'=>$data['end_date'],
        ]);
     if ($save) {
        return true;
     }
        return false;

       
}




public static function selectTypeWeek($type='')
{


    $data=DB::table('week_availavility')
        ->select('week_availavility.id','week_availavility.week_type_id as name','week_availavility.html_start_date as startDate','week_availavility.html_end_date as endDate')
        ->get();


        foreach ($data as &$sku){
            $test = $sku->name;
            if($test == 1){
                $sku->color= "String('#2ecc71')";

            }
            elseif($test == 2){
                $sku->color= "String('#9b59b6')";
            }

            $data2 =DB::table('week_types')->where('id',$test)->value('week_type_name');
            $sku->name = "String('".$data2."')";
        }

        return $data;
}


}
