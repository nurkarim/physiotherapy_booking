<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class Country extends Model
{
	use Userstamps;

    protected $table ="countryes";
    protected $guarded =['id'];

}
