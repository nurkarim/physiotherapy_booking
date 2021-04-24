<?php

namespace App\Http\Models;

use App\Models\WeekTypeDay;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use DB;
class WeekType extends Model
{
	use Userstamps;

   
    protected $guarded =['id'];
    public function weekTypeDay(){
        return $this->hasMany(WeekTypeDay::class,'week_type_id');
    }

    public static function saveWeekTypes($data='')
    {
        $save=WeekType::create([
            'week_type_name'=>$data['type_name'],
            'status'=>1,
        ]);
        if ($save) {
            for ($i=0; $i <sizeof($data['week_day']) ; $i++) { 
            DB::table('week_types_day')->insert([
                'week_type_id'=>$save->id,
                'day_id'=>$data['week_day'][$i],
                'start_time'=>$data['start_time'][$i],
                'end_time'=>$data['end_time'][$i],
                'status'=>1,
            ]);
        }
            return true;

        }
        return false;
    }   

     public static function weekTypesDayTimesUpdate($data='')
    {
    	WeekTypeDay::where("week_type_id",$data['weekType_id'])->where("day_id",$data['days_id'])->delete();
    		for ($i=0; $i <sizeof($data['start_time']) ; $i++) { 
    		DB::table('week_types_day')->insert([
    			'week_type_id'=>$data['weekType_id'],
    			'day_id'=>$data['days_id'],
    			'start_time'=>$data['start_time'][$i],
    			'end_time'=>$data['end_time'][$i],
    			'status'=>1,
    		]);
    	}
    		return true;

    }
    public static function selectWeekType(){
        //$data=DB::table('week_typed');
}

    public static function selectWeekDay()
    {
       $data=DB::table('week_types_day')
            ->join('days','week_types_day.day_id','=','days.id')
            ->select('days.name','week_types_day.*')
            ->get();

            return $data;
    }   

     public static function deleteWeekType($id)
    {
       $data=WeekType::where('id',$id)->delete();
if ($data) {
    DB::table('week_types_day')->where('week_type_id',$id)->delete();
    return true;
}
return false;
    }

public static function weekTypesDaysEdit($dayId,$weekTypeId)
{
   $data=WeekTypeDay::where('day_id',$dayId)->where('week_type_id',$weekTypeId)->get();
   return $data;
}


}
