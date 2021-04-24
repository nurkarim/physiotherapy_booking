<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AvailableRequest;
use App\Http\Requests\DateRangeRequest;
use App\Http\Models\Availability;
use App\Http\Models\Appointment;
use App\Http\Models\WeekType;
use App\Order;
use DB;
use Mail;
use DateTime;

class AvailabilityController extends Controller
{
    public function index()
    {
        $select_time=Availability::selectTime();
        $select_unavail=Availability::selectUnavailable($data=date('Y-m-d'));
        $app=Appointment::where('date', date('Y-m-d'))->get();
        $week_type=WeekType::all();
        $week=Availability::selectTypeWeek(2);
        $weekcalender=json_encode($week);

        return view('backend.availability.create', compact('select_time', 'select_unavail', 'app', 'weekcalender', 'week_type'));
    }

    public function storeAvailability(AvailableRequest $request)
    {
        if (count($request->day_time)>0) {
            if ($request->save_type==2) {
                $save=Availability::saveUnavailability($request->all());
                if ($save==true) {
                    $request->session()->flash('success', " create successfully");
                } else {
                    $request->session()->flash('error', "Sorry!! create Unsuccessfully");
                }
            } else {
                $save=Availability::saveAvailability($request->all());
                if ($save==true) {
                    $request->session()->flash('success', " create successfully");
                } else {
                    $request->session()->flash('error', "Sorry!! create Unsuccessfully");
                }
            }
        } else {
            $request->session()->flash('error', "Please select hours");
        }


        return back();
    }
    public function saveDateRange(Request $request)
    {
        $check=DB::table('date_range')->where('start_date', $request->start_date)->first();
        if ($check) {
            return response()->json(['success'=>false,'sms'=>"Sorry!! Strat date already taken"]);
        }
        $checkend=DB::table('date_range')->where('end_date', $request->end_date)->first();
        if ($checkend) {
            return response()->json(['success'=>false,'sms'=>"Sorry!! End date already taken"]);
        }

        $save=Availability::saveDateRange($request->all());
        if ($save==true) {
            $emails=array();
            $data=DB::table("appointments")
    ->leftjoin("users", "appointments.user_id", "=", "users.id")
    ->select("users.email", "appointments.*")
    ->whereBetween("date", [$request->start_date,$request->end_date])
    ->groupBy("appointments.user_id")
    ->get();
            if (count($data)>0) {
                foreach ($data as $key => $valueAN) {
                    $already=DB::table("cancel_aapointments")->where('appointment_id', $valueAN->id)->first();
                    if ($already) {
                    } else {
                        $updateApp=Appointment::where('id', $valueAN->id)->update(['is_cancel'=>2]);
                        if ($updateApp) {
                            $check=Appointment::find($valueAN->id);

                            $order=Order::find($valueAN->order_id);
                            if ($order->is_paid==1) {
                                DB::table("cancel_aapointments")
->insert([
"user_id"=>$valueAN->user_id,
"appointment_id"=>$valueAN->id,
"order_id"=>$valueAN->order_id,
"price"=>$order->total,
"status"=>1,
"created_at"=>date('Y-m-d H:i:s'),

]);

                                $cwalet=Wallet::where("user_id", $check->user_id)->first();
                                if ($cwalet) {
                                    $up=$cwalet->price+$check->total;
                                    Wallet::where('user_id', $check->user_id)->update([
"price"=>$up
  ]);
                                } else {
                                    Wallet::create([
"user_id"=>$check->user_id,
"price"=>$check->total
  ]);
                                }
                            }
                        }
                    }
                }




                foreach ($data as $key => $value) {
                    $emails[]=$value->email;
                }

                Mail::send('email.welcomes', [], function ($message) use ($emails) {
                    $message->to($emails)->subject('Appointment cancel');
                    $message->from('info@jemkin.be', 'Jemkine');
                });
            }
            // var_dump( Mail:: failures());



            return response()->json(["success"=>true]);
        } else {
            return response()->json(["success"=>false]);
        }
    }


    public function checkUnavail($date='')
    {
        $data=DB::table("appointments")->where("date", $date)->where("active_status", '1')->get();
        if (count($data)>0) {
            $timeId=array();
            foreach ($data as $key => $value) {
                $timeId[]=$value->start_time_id;
            }

            return response()->json($timeId);
        }
    }
    public function getCurrentTimetable($date='')
    {
        // Get the selected date
        $data = $date;
        $dc=date_create($data);
        $formated_date=date_format($dc, "Y-m-d");
        // Find out what weektype the date is
        $week_availavility_weekid =
            DB::table('week_availavility')
                ->where('start_date', '<=', $formated_date)
                ->where('end_date', '>=', $formated_date)
                ->get();

        $lengthAvailweek = count($week_availavility_weekid);

        if ($lengthAvailweek > 0) {
            $week_availavility_weekid = $week_availavility_weekid[0]->week_type_id;
        } else {
            $week_availavility_weekid = 1;
        }
        //Check what type of day it is and set to correct week_type_id;
        $typeday = date("D", strtotime($data));
        $day_id = '';
        switch ($typeday) {
            case 'Mon':
                $day_id = 1;
            break;
            case 'Tue':
                $day_id = 2;
            break;
            case 'Wed':
                $day_id = 3;
            break;
            case 'Thu':
                $day_id = 4;
            break;
            case 'Fri':
                $day_id = 5;
            break;
            case 'Sat':
                $day_id = 6;
            break;
            case 'Sun':
                $day_id = 7;
            break;
        }

        //check the hours of each day for the correct weektype'
        $week_types_day_hours =
            DB::table('week_types_day')
                ->where('day_id', $day_id)
                ->where('week_type_id', $week_availavility_weekid)
                ->get();
        // loop through the result to make the final times object
        $arrayOfMyNumbers = array();
        foreach ($week_types_day_hours as &$week) {
            $end =  substr($week->end_time, 0, 2);
            $start =  substr($week->start_time, 0, 2);
            $amount = intval($end) - intval($start);

            for ($i = 0; $i <= $amount; $i++) {
                $hours = intval($start) + $i;
                $formatted_hours = $hours.':00';
                $arrayOfMyNumbers[] = $formatted_hours;
            }
        }
        // Data should return the hours of that day based on weektype.
        return response()->json(["success"=>true, $arrayOfMyNumbers, $week_availavility_weekid]);
    }
    public function checkUnavailTime($date='')
    {
        $data=DB::table("days_unavailability")
    ->join('times', 'days_unavailability.time', '=', 'times.id')
    ->where("date", $date)
    ->get();
        if (count($data)>0) {
            $timeId=array();
            foreach ($data as $key => $value) {
                $timeId[]=$value->time;
            }

            return response()->json($data);
        }
    }

    public function saveWeekTypes(Request $request)
    {
        $stdate=substr($request->firsDate, 0, 10);
        $endstdate=substr($request->endDate, 0, 10);
        $expl=explode('-', $stdate);
        $impl=implode(',', $expl);
        $endexpl=explode('-', $endstdate);
        $endimpl=implode(',', $endexpl);
        $data=DB::table('week_availavility')
   ->insert([
    "week_type_id"=>$request->week_types,
    "start_date"=>substr($request->firsDate, 0, 10),
    "end_date"=>substr($request->endDate, 0, 10),
    "html_start_date"=>"new Date('".$impl."')",
    "html_end_date"=>"new Date('".$endimpl."')",
   ]);

        if ($data) {
            return response()->json(["success"=>true,"id"=>1,"name"=>$request->week_types,"startDate"=>$impl,"endDate"=>$endimpl]);
        } else {
            return response()->json(["success"=>false]);
        }
    }

    public function availabilityWeekType($id='')
    {
        $select_time=Availability::selectTime();

        $select_unavail=Availability::selectUnavailable($data=date('Y-m-d'));
        $app=Appointment::where('date', date('Y-m-d'))->get();
        $week=Availability::selectTypeWeek($id);
        $weekcalender=json_encode($week);
        $week_type=WeekType::all();

        $weekId=$id;

        return view('backend.availability.create', compact('select_time', 'select_unavail', 'app', 'weekcalender', 'weekId', 'week_type'));
    }
}
