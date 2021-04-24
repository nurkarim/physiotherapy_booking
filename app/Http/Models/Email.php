<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class Email extends Model
{
	use Userstamps;

    protected $guarded =['id'];
    protected $table ="send_email_history";

 }