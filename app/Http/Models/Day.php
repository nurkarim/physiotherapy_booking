<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class Day extends Model
{
	use Userstamps;

   
    protected $guarded =['id'];
    public function weekType(){
        return $this->belongsToMany(WeekType::class,'week_types_day','day_id','week_type_id');
    }

}
