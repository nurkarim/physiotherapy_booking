<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class WalletRequest extends Model
{
	use Userstamps;

    protected $table ="wallet_request";
    protected $guarded =['id'];

}
