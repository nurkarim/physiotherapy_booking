<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class Wallet extends Model
{
	use Userstamps;

    protected $table ="my_wallet";
    protected $guarded =['id'];

}
