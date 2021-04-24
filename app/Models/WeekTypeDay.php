<?php

namespace App\Models;

use App\Http\Models\Day;
use Illuminate\Database\Eloquent\Model;

class WeekTypeDay extends Model
{
    protected $table ='week_types_day';
    public function weekDay(){
        return $this->belongsTo(Day::class,'day_id');
    }
}
