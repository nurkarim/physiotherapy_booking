<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Session;
class Cart extends Model
{
	use Userstamps;

    protected $guarded =['id'];

   public static function appointmentCart($data='')
    {
         $cartValue=array(
                    'id'=>$data['appointment_type'],
                    'name'=>$data['type_name'],
                    'price'=>$data['type_price'],
                    'qty'=>1,
                    'start_time_id'=>$data['start_time_id'],
                    'specialist'=>$data['specialist'],
                    'start_time'=>$data['start_time'],
                    'date'=>$data['date'],
                    'vat_number'=>$data['vat_number'],
                    'color'=>$data['color'],
                    
                );
              Session::put('appoinmentCart.time_id'.$data['start_time_id'].'_'.$data['date'],$cartValue);
              return true;

    }   

    public static function orderProcessSuccess($data='')
    {
    	 $arraY=array(
        'order_number'=>$data['order_number'],'first_name'=>$data['first_name'],
        'last_name'=>@$data['last_name'],
        'email'=>$data['email']
                );
        Session::put('successSMS.id_1',$arraY);
        return true;

    }

}
