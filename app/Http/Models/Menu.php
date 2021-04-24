<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use DB;
class Menu extends Model
{
	use Userstamps;

    protected $table ="menu";
    protected $guarded =['id'];

public static function subMenu()
{
	$result=DB::table('sub_menu')->get();
	return $result;
}


}
