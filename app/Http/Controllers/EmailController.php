<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Http\Models\Company;
use App\Http\Models\Appointment;
use App\Order;
use App\User;
use App\Http\Models\Invoice;
use App\Http\Models\Email;
use Mail;
use DB;
class EmailController extends Controller
{
    public function reminder($id='')
    {

     $app=Appointment::find($id);
		 $applist=Appointment::where('id',$id)->get();
     $user=User::where('id',$app->user_id)->first();
     $specialist=User::where('id',$app->specialist_id)->first();
     $order=Order::where('appoitment_id',$app->id)->first();
   $cmp=Company::where('id_number',123)->first();
   $email=$user->email;
$name=$user->first_name;
$data=array('email'=>$email,'name'=>$name);
 Mail::send('email.reminder',compact('user','specialist','cmp','applist','order','app'), function($message)use ($data) {
         $message->to('glenn@jemproductions.be', $data['name'])->subject
            ('Appointment Reminder');
         $message->from('info@jemkin.be','Jemkine');
      });
     
$save=Appointment::where('id',$id)->update(['status'=>2]);

Email::create([
"date"=>date('Y-m-d'),
"type"=>1,
"type_id"=>$id,

  ]);

	return response()->json(["success"=>true, $data]);

    }

    public function sendReminderOrder($id='')
    {
      $check=Order::find($id);
      if ($check) {
     $app=Appointment::where('id',$check->appoitment_id)->first();
     $applist=Appointment::where('id',$app->id)->get();
     $user=User::where('id',$app->user_id)->first();
     $specialist=User::where('id',$app->specialist_id)->first();
    $order=Order::where('id',$check->id)->first();
   $cmp=Company::where('id_number',123)->first();

 $email=$user->email;
$name=$user->first_name;
$data=array('email'=>$email,'name'=>$name);
 $res=Mail::send('email.orderPayment',compact('user','specialist','cmp','applist','order'), function($message)use ($data) {
         $message->to($data['email'], $data['name'])->subject
            ('Payment Reminder');
         $message->from('info@jemkin.be','Jemkine');
      });

$save=Order::where('id',$id)->update(['is_send'=>2]);

Email::create([
"date"=>date('Y-m-d'),
"type"=>2,
"type_id"=>$id,

  ]);

return response()->json(['success'=>true]);
  }else{
    return response()->json(['success'=>false]);
  }
 
    
    }

public function sendReminderInvoice($id='')
    {
      $check=Invoice::find($id);
      if ($check) {
     $app=Appointment::where('id',$check->appointment_id)->first();
     $applist=Appointment::where('id',$app->id)->get();
     $user=User::where('id',$app->user_id)->first();
     $specialist=User::where('id',$app->specialist_id)->first();
       $order=Order::where('appoitment_id',$app->id)->first();
   $cmp=Company::where('id_number',123)->first();

 $email=$user->email;
$name=$user->first_name;
$data=array('email'=>$email,'name'=>$name);
 $res=Mail::send('email.payment',compact('user','specialist','cmp','applist','order'), function($message)use ($data) {
         $message->to($data['email'], $data['name'])->subject
            ('Payment Reminder');
         $message->from('info@jemkin.be','Jemkine');
      });
 


$save=Order::where('id',$id)->update(['is_send'=>2]);
 
Email::create([
"date"=>date('Y-m-d'),
"type"=>3,
"type_id"=>$id,

  ]);

return response()->json(['success'=>true]);
  }else{
    return response()->json(['success'=>false]);
  }
 
    
    }

}
