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
use PDF;
use App\Http\Models\Company;
use App\Http\Models\Email;
use Mail;

class reminderController extends Controller
{
    public function index()
    {

        $dateToday = date('Y-m-d');
        $Appointments=Appointment::all();
        $dates = [];
        foreach($Appointments as $appointment){
            $dateAppointment = $appointment->date;
            $reminderDate = date('Y-m-d', strtotime($dateAppointment . ' -1 day'));

            if($dateToday == $reminderDate){
                $dates[] = ['date'=> $appointment->date, 'id' => $appointment->id];

                $app=Appointment::where('id',$appointment->id)->first();
                $applist=Appointment::where('id',$app->id)->get();
                $user=User::where('id',$app->user_id)->first();
                $cmp=Company::where('id_number',123)->first();

                $email=$user->email;
                $name=$user->first_name;
                $data=array('email'=>$email,'name'=>$name);
                $res=Mail::send('email.reminder_daybefore',compact('user','specialist','cmp','applist'), function($message)use ($data) {
                    $message->to($data['email'], $data['name'])->subject
                    ('Payment Reminder');
                    $message->from('info@jemkin.be','Jemkine');
                });

            }
        }

        return  $dates;
    }
}
