<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class Vat extends Model
{
	use Userstamps;

    protected $table ="vat_class";
    protected $guarded =['id'];

}
