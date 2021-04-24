<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class UserAddress extends Model
{
	use Userstamps;

    protected $table ="user_address";
    protected $guarded =['id'];

}
