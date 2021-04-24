<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class Categories extends Model
{
	use Userstamps;

    protected $guarded =['id'];

}
