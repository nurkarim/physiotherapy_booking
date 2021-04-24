<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Models\AppointmentType;
use App\Http\Models\Availability;
use App\Http\Models\Appointment;
use DB;
class HomeController extends Controller
{

    public function index()
    {

      $saleClender=DB::table('appointments')
            ->leftjoin('users','appointments.user_id','=','users.id')
            ->select("appointments.time_and_appointmnet_name as title","appointments.appdateTime as start","appointments.enddateTime as end","appointments.id as className","appointments.color as backgroundColor")
            ->where("appointments.active_status", '1')
            ->get();

             $monthBooking=DB::table('appointments')
              ->leftjoin('users','appointments.user_id','=','users.id')
             ->select("appointments.*")
             ->where(DB::raw("left(date,7)"),date('Y-m'))
             ->get();

          $calender=$saleClender;

        foreach ($calender as &$cal){
            unset($cal->allDay);
        }

        $calender = json_encode($calender);


        $appointment_type=AppointmentType::all();
        return view('backend.dashboard',compact('monthBooking','calender','appointment_type'));
    }
    public function seacrhAppointment(Request $request)
    {

            $saleClender=DB::table('appointments')
            ->leftjoin('users','appointments.user_id','=','users.id')
            ->select("appointments.time_and_appointmnet_name as title","appointments.appdateTime as start","appointments.enddateTime as end","appointments.id as className")
            ->orWhere('time_and_appointmnet_name', 'like', '%' . $request->search . '%')
            ->get();

             $monthBooking=DB::table('appointments')
              ->leftjoin('users','appointments.user_id','=','users.id')
             ->select("appointments.*")
             ->where(DB::raw("left(date,7)"),date('Y-m'))
             ->Where('time_and_appointmnet_name', 'like', '%' . $request->search . '%')
             ->get();

          $calender=json_encode($saleClender);



$appointment_type=AppointmentType::all();
        return view('backend.dashboard',compact('monthBooking','calender','appointment_type'));
    }

    public function appFind($id,$month)
    {


$da=date('Y-m', strtotime($month));
      $saleClender=DB::table('appointments')
              ->leftjoin('users','appointments.user_id','=','users.id')
             ->select("appointments.time_and_appointmnet_name as title","appointments.date as start","appointments.date as end","appointments.id as className")
              ->where('appointments.appointment_type_id',$id)
             ->get();

             $monthBooking=DB::table('appointments')
              ->leftjoin('users','appointments.user_id','=','users.id')
             ->select("appointments.*")
             ->where(DB::raw("left(date,7)"),$da)
             ->where('appointments.appointment_type_id',$id)
             ->get();

          $calender=json_encode($saleClender);



      $appointment_type=AppointmentType::all();
        return view('backend.dashboard2',compact('monthBooking','calender','appointment_type','id'));
    }





public function monthlyBooking($month='')
{

 $da=date('Y-m', strtotime($month));
 $monthBooking=Appointment::where(DB::raw("left(date,7)"),$da)->count();
 return response()->json(["success"=>true,"count"=>$monthBooking]);

}

    public function home()
    {
      $specialist=User::where('is_specialist',1)->get();
      $select_time=User::selectTime();
      $appointment_types=User::appointmentTypes();
        return view('layouts.body',compact('specialist','select_time','appointment_types'));
    }

    public function bodyFront()
     {

      return view('layouts.home');
     }

public function contact()
     {

      return view('layouts.contact');
     }


     public function appointmentTypes()
    {

    	$appointment_types=User::appointmentTypes();
        return view('layouts.appointment_type',compact('appointment_types'));
    }



    public function selectType($id='')
    {
      $data= AppointmentType::find($id);
      if ($data) {
        return response()->json(['amount'=>$data->amount,'type_name'=>$data->type_name,'vat_number'=>$data->vat_number,'color'=>$data->color]);
      }else{
        return response()->json(['amount'=>0.00]);
      }

    }

     public function appointmentsAvailable(Request $request)
    {
      $data= Availability::selectUnavailable($request->days);
      if (count($data)>0) {
        return response()->json(['success'=>true]);
      }else{
        return response()->json(['success'=>false]);
      }

    }

    public function selectUser($id)
    {
      $data= User::find($id);
      if (count($data)>0) {
        return response()->json(['success'=>true,'name'=>$data->first_name,'image'=>$data->image,'email'=>$data->email,'phone'=>$data->phone_number]);
      }else{
        return response()->json(['success'=>false,'name'=>"specialist"]);
      }

    }


}
