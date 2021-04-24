<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
class Invoice extends Model
{
	use Userstamps;

    protected $guarded =['id'];
    protected $table ="invoices";

    public static function makeInvoice($data='',$id)
    {

        
    	$save=Invoice::create([
    		'order_id'=>$id,
    		'client_id'=>$data['client_id'],
            'date'=>date('Y-m-d'),
    		'appointment_id'=>$data['appointment_id'],
    		'status'=>1,
    	]);

    	if ($save) {
    		return true;
    	}

    		return false;

    }



}
