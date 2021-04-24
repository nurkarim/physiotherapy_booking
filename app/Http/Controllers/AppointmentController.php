<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Availability;
use App\Http\Models\Appointment;
use App\Http\Models\AppointmentType;
use App\Http\Models\Product;
use App\Http\Models\Vat;
use App\Http\Models\Invoice;
use App\Http\Models\Wallet;
use App\User;
use App\Order;
use DB;
use Carbon\Carbon;
use DateTime;
use DateInterval;
class AppointmentController extends Controller
{
    public function index()
    {

        $data=Appointment::appointmentList();

    	return view('backend.appointment.list',compact('data'));
    }



    public function details($id)
    {

        
        $appointment=Appointment::where('id',$id)->first();
        $users=User::where('id',$appointment->user_id)->first();
        $users_address=User::userAddressSelect($appointment->user_id);
        $products=Product::all();
        $products_cart=Appointment::orderCartProduct($id);
        $vat=Vat::where('country_id',$users_address->shipping_country_name)->first();
    	return view('backend.appointment.details',compact('appointment','users','users_address','products','products_cart'));
    	
    }

 
    public function create()
    {
  


        $saleClender=DB::table('appointments')
              ->join('users','appointments.user_id','=','users.id')
             ->select("users.first_name as title","appointments.date as start","appointments.date as end")
           
             ->get(); 

              $calender=json_encode($saleClender);
    $select_time=Availability::selectTime();
    $appointment_type=AppointmentType::all();
    $user=User::where('user_type',2)->get()->pluck('first_name','id')->prepend('Type to search a client', '');
        return view('backend.appointment.create',compact('select_time','appointment_type','user','calender'));
    }
    


public function updateAppointment(Request $request)
{

    
$save=Appointment::UpdateAppointment($request->all());
if ($save) {
    $request->session()->flash('success', "Change Successfully");
}else{
    $request->session()->flash('error', "Sorry!! Change UnSuccessfully");

}
return back();

}

public function checkAppointment(Request $request)
{

    $save=Appointment::checkAppointment($request->all());
    if ($save) {
        return response()->json(['success'=>true]);
    }else{
        return response()->json(['success'=>false]);
    }
}

public function store(Request $request)
{

$save=Appointment::saveAppointment($request->all());
if ($save) {
    $request->session()->flash('success', "Appointment Make Successfully");
}else{
    $request->session()->flash('error', "Sorry!! Appointment Make UnSuccessfully");
}

return redirect('appointments');

}

public function update($id,Request $request)
{

    $save=Appointment::updatedAppointment($id,$request->all());
    if ($save) {
    $request->session()->flash('success', "Change Successfully");
}else{
    $request->session()->flash('error', "Sorry!! Change UnSuccessfully");

}
return redirect('appointments');
}



public function productCheckForAddCart($id='')
{
    $data=Product::find($id);
    if ($data) {
        return response()->json(['success'=>true,'price'=>$data->amount,'vat_number'=>$data->vat_number,'product_name'=>$data->product_name]);
    }else{
         return response()->json(['success'=>false,'price'=>0,'vat_number'=>0]);
    }
}

public function conframOrder(Request $request)
{

 
   $save= Appointment::conframOrder($request->all());
    if ($save) {
    $request->session()->flash('success', "Change Successfully");
}else{
    $request->session()->flash('error', "Sorry!! Change UnSuccessfully");

}
return redirect('appointments');


}

public function conframOrderandAppointment(Request $request)
{



   $save= Appointment::conframOrderandAppointment($request->all());

    if ($save) {
    $request->session()->flash('success', "Change Successfully");
}else{
    $request->session()->flash('error', "Sorry!! Change UnSuccessfully");

}
return back();
}
public function Orderupdated(Request $request)
{


   $save= Appointment::Orderupdated($request->all());

    if ($save) {
    $request->session()->flash('success', "Change Successfully");
}else{
    $request->session()->flash('error', "Sorry!! Change UnSuccessfully");

}



return back();


}




public function OrderUpdatedNew(Request $request)
{


   $save= Appointment::OrderupdatednNew($request->all());

    if ($save) {
    $request->session()->flash('success', "Change Successfully");
}else{
    $request->session()->flash('error', "Sorry!! Change UnSuccessfully");

}


return back();


}




public function makeInvoice(Request $request)
{
    $check=Invoice::where('appointment_id',$request->appointment_id)->first();
    if ($check) {
        return response()->json(['errors'=>true,'status'=>"Invoice have Made"]);
        
    }else{
      $order=Order::where('appoitment_id',$request->appointment_id)->first();
      if ($order) {
    
        $save= Invoice::makeInvoice($request->all(),$order->id);
           if ($save) {
        return response()->json(['success'=>true,'status'=>"Invoice make Successfully"]);
    }else{
        return response()->json(['success'=>false,'status'=>"Invoice make UnSuccessfully"]);
    }

      }else{
 return response()->json(['notyet'=>true,'status'=>"Order not create yet"]);
      }
 
    }

}

public function makeOrder(Request $request)
{
    $check=Order::where('appoitment_id',$request->appointment_id)->first();
    if ($check) {
        return response()->json(['error'=>true,'status'=>"Order have made"]);
        
    }else{
        $save= Appointment::makeOrder($request->all());
  if ($save) {
        return response()->json(['success'=>true,'status'=>"Order create Successfully"]);
    }else{
        return response()->json(['success'=>false,'status'=>"Order create UnSuccessfully"]);
    }  
    }

}


public function checkSelectAppointment(Request $request)
{
 $type="";
 $orderId="0";

$id=$request->id;
$app=Appointment::find($id);


$date=date("l d, F", strtotime($app->date));

if ($app) {
  if ($app->is_paid==0 || $app->is_paid=='') {
    $type="UNPAID";
}else{
    $type="PAID";

}  
$is_order=$app->is_order;
$order_id=$app->order_id;
}

$users=User::find($app->user_id);
if ($users) {
    $name=$users->first_name;
}else{
    $name=$app->name;
}

$time=$app->start_time.'-'.$app->end_time;
if ($app->appointment_type=='null') {
    $appType=$app->location;
}else{
    $appType=$app->appointment_type;

}

return response()->json(['user_name'=>$name,'type'=>$appType,'date'=>$date,'is_paid'=>$type,'times'=>$time,'success'=>true,'is_order'=>$is_order,'order_id'=>$order_id,'app_id'=>$app->id,'is_parsonal'=>$app->is_parsonal]);


}


public function edit($id='')
{
   $saleClender=DB::table('appointments')
              ->join('users','appointments.user_id','=','users.id')
             ->select("users.first_name as title","appointments.date as start","appointments.date as end")
           
             ->get(); 

              $calender=json_encode($saleClender);
    $select_time=Availability::selectTime();
    $appointment_type=AppointmentType::all();
    $user=User::where('user_type',2)->get()->pluck('first_name','id')->prepend('Type to search a client', '');
    $app=Appointment::find($id);
        return view('backend.appointment.edit',compact('select_time','appointment_type','user','calender','app'));
}

public function appCencelNew(Request $request,$id='')
{

 
  $arr=array();
   $app=Appointment::find($id);
   if ($app) {
      if ($app->order_id>0) {
     
          $order=Order::find($app->order_id);
        if (count(json_decode($order->json_app_id))>1) {
            $jsonAppId=json_decode($order->json_app_id);
            foreach ($jsonAppId as $key => $value) {
                if ($app->id== $value) {
                    # code...
                }else{
              $arr[]=$value;
                }
            }
          $vat=($order->vat_amount-$app->vat_price);
          $sub=($order->sub_total-$app->price);
          $total=($order->total-$app->total);
          $order->json_app_id=json_encode($arr);
          $order->vat_amount=$vat;
          $order->sub_total=$sub;
          $order->total=$total;
          $order->save();
          if ($app->is_paid==1) 
       {
        $cwalet=Wallet::where("user_id",$app->user_id)->first();
        if ($cwalet) {
          $up=$cwalet->price+$app->total;
        Wallet::where('user_id',$app->user_id)->update([
        "price"=>$up
          ]);

        }else{

        Wallet::create([
        "user_id"=>$app->user_id,
        "price"=>$app->total
          ]);
        }
       }

       $deleteSucc=Appointment::where('id',$app->id)->delete();
      if ($deleteSucc) {
              $request->session()->flash('success', "Appointment Cancel successfully");
          }else{
              $request->session()->flash('error', "Sorry!!Appointment Cancel Unsuccessfully"); 
          }

        }else{

          $order=Order::find($app->order_id);
          $vat=($order->vat_amount-$app->vat_price);
          $sub=($order->sub_total-$app->price);
          $total=($order->total-$app->total);
          $order->json_app_id=json_encode($arr);
          $order->vat_amount=$vat;
          $order->sub_total=$sub;
          $order->total=$total;
          $order->save();
           

     if ($app->is_paid==1) 
       {
        $cwalet=Wallet::where("user_id",$app->user_id)->first();
        if ($cwalet) {
          $up=$cwalet->price+$app->total;
        Wallet::where('user_id',$app->user_id)->update([
        "price"=>$up
          ]);

        }else{

        Wallet::create([
        "user_id"=>$app->user_id,
        "price"=>$app->total
          ]);
        }
       }
        $cart=Order::orderCartProduct2($order->id);
            if ($cart) {
               
            }else{
              Order::where('id',$order->id)->delete();  
            }
       $deleteSucc=Appointment::where('id',$app->id)->delete();
      if ($deleteSucc) {
              $request->session()->flash('success', "Appointment Cancel successfully");
          }else{
              $request->session()->flash('error', "Sorry!!Appointment Cancel Unsuccessfully"); 
          }
        }
      }else{

  
       
       if ($app->is_paid==1) 
       {
        $cwalet=Wallet::where("user_id",$app->user_id)->first();
        if ($cwalet) {
          $up=$cwalet->price+$app->grand_total_with_vat;
        Wallet::where('user_id',$app->user_id)->update([
        "price"=>$up
          ]);

        }else{

        Wallet::create([
        "user_id"=>$app->user_id,
        "price"=>$app->grand_total_with_vat
          ]);
        }


       }

        if ($app->is_order==1) {
            $order=Order::find($app->order_id);

            Order::where('id',$order->id)->delete();
        }
        $deleteSucc=Appointment::where('id',$app->id)->delete();
         if ($deleteSucc) {
          $request->session()->flash('success', "Appointment Cancel successfully");
      }else{
          $request->session()->flash('error', "Sorry!!Appointment Cancel Unsuccessfully"); 
      }
      }

     
   }

   return back();
}


public function personalAppointment(Request $request)
{

    $save=Appointment::makePersonalAppointment($request->all());
   if ($save) {
       return response()->json(["success"=>true,"appId"=>$save]);
   }else{

       return response()->json(["success"=>false]);

   }



}

public function personalAppointmentRemove($id)
{

    $save=Appointment::where('id',$id)->delete();
   if ($save==true) {
       return response()->json(["success"=>true]);
   }else{

       return response()->json(["success"=>false]);

   }



}

public function personalAppointmentSelect($id='')
{
  $data=Appointment::where('id',$id)->first();
  return response()->json(["name"=>$data->name,'location'=>$data->location,'start_time'=>$data->start_time,'end_time'=>$data->end_time,'appointment_id'=>$data->id,'date'=>$data->date]);
}

public function editPersonalAppointment(Request $request)
{

//return $request->all();
      $save=Appointment::editPersonalAppointment($request->all());
   if ($save) {
       return response()->json(["success"=>true,"appId"=>$request->edit_id]);
   }else{

       return response()->json(["success"=>false]);

   }

}
    public function appCancel(Request $request, $id='')
    {

        if ($request->isMethod('post')){


            $data = $request->all();
            $errors = [];
            $success = [];
            $data = $data['id'];

            foreach ($data as $id){
             $already=DB::table("cancel_aapointments")->where('appointment_id',$id)->first();
                if ($already) {
                    $errors[] = 'Appointment '.$id.' is already canceled.';
                }else{
                    $save=Appointment::where('id',$id)->update(['is_cancel'=>2]);
                    if ($save) {
                        $check=Appointment::find($id);

                        if ($check->is_paid==1) {

                            DB::table("cancel_aapointments")
                                ->insert([
                                    "user_id"=>$check->user_id,
                                    "appointment_id"=>$check->id,
                                    "order_id"=>0,
                                    "price"=>$check->total,
                                    "status"=>1,
                                    "created_at"=>date('Y-m-d H:i:s'),

                                ]);

                            $cwalet=Wallet::where("user_id",$check->user_id)->first();
                            if ($cwalet) {
                                $up=$cwalet->price+$check->total;
                                Wallet::where('user_id',$check->user_id)->update([
                                    "price"=>$up
                                ]);

                            }else{

                                Wallet::create([
                                    "user_id"=>$check->user_id,
                                    "price"=>$check->total
                                ]);
                            }




                        }
                        Appointment::where("id",$id)->delete();
                        Order::where("appoitment_id",$id)->delete();
                        $success[] = 'Appointment '.$id.' is successfully canceled.';

                    }else{
                        $errors[] = 'Appointment '.$id.' was unsuccessfully canceled.';


                    }
                }

            }

            return response()->json(['response' => $data, 'success'=> $success]);
        }

    }

}
