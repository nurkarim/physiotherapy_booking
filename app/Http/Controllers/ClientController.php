<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;

use App\Http\Models\Client;
use App\Http\Models\MyAccount;
use App\Http\Models\Country;
use App\Http\Models\Appointment;
use App\Http\Models\Vat;
use App\Http\Models\WalletRequest;
use App\Http\Models\Wallet;
use App\User;
use App\Order;
use Auth;
use DB;
use Illuminate\Validation\Validator;
use Mollie;
use Socialite;

class ClientController extends Controller
{
    public function index()
    {
        $client=Client::where('user_type', 2)->get();
        return view('backend.client.index', compact('client'));
    }

    public function import()
    {
        return view('backend.client.import-user');
    }
    public function handleImport(request $request)
    {
        $file = $request->file('file');
        $cvsData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $cvsData));
        $header = array_shift($rows);
        foreach ($rows as $row) {
            $row = array_combine($header, $row);

            User::Create([
                'first_name' => $row['first_name'],
                "last_name"=> $row['last_name'],
                "title"=> $row['title'],
                "email"=> $row['email'],
                "password"=> 'test',
                "vat_number"=> $row['vat_number'],
                "role_id"=> $row['role_id'],
                "user_type"=> $row['user_type'],
                "is_specialist"=> $row['is_specialist'],
                "phone_number"=> $row['phone_number'],
                "another_phone_number"=> $row['another_phone_number'],
                "image"=> $row['image'],
                "status"=> $row['status'],
                "created_by"=> $row['created_by'],
                "updated_by"=> $row['updated_by'],
                "remember_token"=> $row['remember_token'],
                "created_at"=> date('Y'),
                "updated_at"=> date('Y'),
            ]);
        }
    }
    public function create()
    {
        $country=Country::all();
        return view('backend.client.create', compact('country'));
    }

    public function checkEmail(Request $request)
    {
        $check=User::where("email", $request->email)->first();
        if ($check) {
            return 1;
        } else {
            return 2;
        }
    }

    public function details($id)
    {
        $users=User::where('id', $id)->first();
        $users_address=User::userAddressSelect($id);
        $appointment=Appointment::select("appointments.*")
        ->where('appointments.user_id', $id)
        ->get();
        return view('backend.client.details', compact('appointment', 'users', 'users_address'));
    }
    public function walletRequests()
    {
        $data=WalletRequest::join('users', 'wallet_request.client_id', '=', 'users.id')
        ->select('users.first_name', 'users.id as userId', 'users.last_name', 'users.email', 'users.phone_number', 'wallet_request.*')
        ->orderBy('id', 'DESC')
        ->get();
        return view('backend.client.wallet_requests', compact('data'));
    }

    public function store(ClientRequest $request)
    {
        $save=Client::saveClient($request->all());
        if ($save==true) {
            $request->session()->flash('success', " create successfully");
        } else {
            $request->session()->flash('error', "Sorry!! create Unsuccessfully");
        }

        return back();
    }
    public function update(Request $request, $id)
    {
        $save=Client::updateClient($request->all(), $id);
        if ($save==true) {
            $request->session()->flash('success', " edit successfully");
        } else {
            $request->session()->flash('error', "Sorry!! edit Unsuccessfully");
        }

        return redirect('clients');
    }



    public function edit($id)
    {
        $client=Client::find($id);
        $address=Client::clientAddress($id);
        $country=Country::all();
        return view('backend.client.edit', compact('address', 'client', 'country'));
    }

    public function destory($id='')
    {
        $result=Client::deleteclient($id);
        if ($result==true) {
            return response()->json(['success'=>true]);
        } else {
            return response()->json(['success'=>false]);
        }
    }
    // ==========================Start Frontend panel==========================

    public function myAccount()
    {
        $address=User::userAddressSelect(Auth::user()->id);
        return view('layouts.my_account.index', compact('address'));
    }

    public function myAppointments()
    {
        $data=MyAccount::selectAppointment();
        $select_time=User::selectTime();
        $appointment_types=User::appointmentTypes();
        return view('layouts.my_account.appointment.index', compact('data', 'select_time', 'appointment_types'));
    }

    public function history()
    {
        $data=MyAccount::selectAppointment();
        return view('layouts.my_account.history', compact('data'));
    }
    public function loadAppointment($id)
    {
        $select_time=User::selectTime();
        $appointment_types=User::appointmentTypes();
        $appointment=MyAccount::selectWhereAppointment($id);
        $address=User::userAddressSelect(Auth::user()->id);
        return view('layouts.my_account.appointment.load', compact('select_time', 'appointment_types', 'appointment', 'address'));
    }


    public function unPaidAppointment()
    {
        $data=DB::table('appointments')
        ->leftjoin('orders', 'orders.appoitment_id', '=', 'appointments.id')
        ->select('appointments.*', 'orders.id as orderId')
        ->where('orders.is_paid', 0)
        ->where('appointments.user_id', Auth::user()->id)
        ->get();
        return view('layouts.my_account.appointment.unpaid_appointment', compact('data'));
    }
    public function myInvoice()
    {
        $data=DB::table('invoices')
        ->join('orders', 'invoices.order_id', '=', 'orders.id')
        ->select('invoices.id as InvId', 'invoices.date as InvDate', 'orders.*')
        ->where('invoices.client_id', Auth::user()->id)
        ->get();
        return view('layouts.my_account.invoice.index', compact('data'));
    }

    public function myOrder()
    {
        $orders=DB::table('orders')
        ->leftjoin('invoices', 'orders.id', '=', 'invoices.order_id')
        ->select('orders.*', 'invoices.id as InvID')
        ->where('orders.user_id', Auth::user()->id)
        ->orderBy('orders.id', 'DESC')
        ->paginate(10);
        return view('layouts.my_account.order.index', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order=Order::find($id);
        $appointment=Appointment::where('id', $order->appoitment_id)->first();
        $users=User::where('id', $order->user_id)->first();
        $users_address=User::userAddressSelect($order->user_id);
        $vat=Vat::where('country_id', $users_address->shipping_country_name)->first();
        if ($appointment) {
            $products_cart=Appointment::orderCartProduct($order->appoitment_id);
            $specialist=User::where('id', $appointment->specialist_id)->first();
            return view('layouts.my_account.order.details', compact('order', 'appointment', 'users', 'users_address', 'products_cart', 'vat', 'specialist'));
        }
        if (count($order->json_app_id)>0) {
            $products_cart=Order::orderCartProduct2($id);
            $appointments=Appointment::where('order_id', $order->id)->get();
            return view('layouts.my_account.order.with_more_app_details', compact('order', 'users', 'users_address', 'products_cart', 'vat', 'appointments'));
        }
        $products_cart=Order::orderCartProduct2($id);
        return view('layouts.my_account.order.without_appointment_orderDetails', compact('order', 'users', 'users_address', 'products_cart', 'vat'));
    }

    public function appDetails($id)
    {
        $appointment=Appointment::where('id', $id)->first();
        $users=User::where('id', $appointment->user_id)->first();
        $specialist=User::where('id', $appointment->specialist_id)->first();
        $users_address=User::userAddressSelect($appointment->user_id);
        $products_cart=Appointment::orderCartProduct($id);
        $vat=Vat::where('country_id', $users_address->shipping_country_name)->first();
        return view('layouts.my_account.appointment.details', compact('appointment', 'users', 'users_address', 'products_cart', 'vat', 'specialist'));
    }



    public function editMyInfo()
    {
        $users=User::where('id', Auth::user()->id)->first();
        $address=User::userAddressSelect(Auth::user()->id);
        $country=Country::all();
        return view('layouts.my_account.edit', compact('users', 'address', 'country'));
    }


    public function editMyAccount(Request $request)
    {
        $save=User::editMyAccount($request->all());
        if ($save) {
            $request->session()->flash('success', "edit successfully");
        } else {
            $request->session()->flash('error', "Sorry!! edit unsuccessfully");
        }

        return redirect('my-account');
    }


    public function passwordChange()
    {
        return view('layouts.my_account.passwordChange');
    }


    public function savepasswordChange(Request $request)
    {
        $obj=User::find(Auth::user()->id);
        $obj->password=bcrypt($request->password);
        $obj->save();

        if ($obj) {
            $request->session()->flash('success', "Password Change  successfully");
        } else {
            $request->session()->flash('error', "Sorry!! Password Change  unsuccessfully");
        }

        return redirect('my-account');
    }


    public function requestFund()
    {
        $data=DB::table("cancel_aapointments")
    ->join("appointments", "cancel_aapointments.appointment_id", "=", "appointments.id")
    ->select("appointments.*")
    ->where("cancel_aapointments.user_id", Auth::user()->id)
    ->get();
        $checkRequ=WalletRequest::where("client_id", Auth::user()->id)->orderBy("id", "DESC")->get();
        return view("layouts.my_account.request_fund", compact('data', 'checkRequ'));
    }

    public function requestreFund(Request $request)
    {
        if ($request->price>0) {
            $save= WalletRequest::create([
        "client_id"=>Auth::user()->id,
        "price"=>$request->price,
        "date"=>date("Y-m-d"),
        "method"=>0,
        "status"=>1,
   ]);
            if ($save) {
                return response()->json(["success"=>true,"status"=>1]);
            } else {
                return response()->json(["success"=>false,"status"=>1]);
            }
        } else {
            return response()->json(["error"=>true,"status"=>1]);
        }
    }

    public function orderPayment($id='', Request $request)
    {
        $orders=Order::find($id);
        if ($orders->is_paid==0) {
            $paynow=0;
            if ($orders->paid>0) {
                $paynow= $orders->total-$orders->paid ;
            } else {
                $paynow= $orders->total;
            }
            $customer = Mollie::api()->customers()->create([
    "name"  => Auth::user()->first_name,
    "email" => Auth::user()->eamil,
    ]);
            $payment = mollie::api()->payments()->create([
    'amount'        =>  $paynow,
    'customerId'    =>  $customer->id,
    'recurringType' => 'first',
    'description'   => 'My Order Payment',
    'redirectUrl'   => url("my-account/my-orders").'/'.$id.'/details',
]);

            $payment = Mollie::api()->payments()->get($payment->id);

            if ($payment) {
                $orders->is_paid=1;
                $orders->paid=$paynow;
                $orders->payment_method=2;
                $orders->customer_payment_reference=$customer->id;
                $orders->payment_id=$payment->id;
                $orders->save();

                $app=Appointment::find($order->appointment_id);
                $app->is_paid=1;
                $app->save();
                $da=Order::find($order->id);
                $jsvalues=json_decode($da->json_app_id);
                if ($jsvalues) {
                    foreach ($jsvalues as $key => $value) {
                        $app=Appointment::find($value);
                        if ($app) {
                            $app->is_paid=1;
                            $app->save();
                        }
                    }
                }
                $request->session()->flash('success', "Payment successfully");
            } else {
                $request->session()->flash('error', "Payment Unsuccessfully");
            }

            return back();
        }
    }

    public function walletRequestsComplete($id='', $status)
    {
        $obj=WalletRequest::find($id);
        $obj->status=$status;
        $obj->save();

        if ($obj) {
            if ($status==2) {
                $chekwallet=Wallet::where("user_id", $obj->client_id)->first();
                if ($chekwallet) {
                    Wallet::where("user_id", $obj->client_id)->update([
            "price"=>0.00,
           ]);
                }
            }
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }

    public function appointmentDelete($id, Request $request)
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
                        } else {
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
                    if ($app->is_paid==1) {
                        $cwalet=Wallet::where("user_id", Auth::user()->id)->first();
                        if ($cwalet) {
                            $up=$cwalet->price+$app->total;
                            Wallet::where('user_id', Auth::user()->id)->update([
        "price"=>$up
          ]);
                        } else {
                            Wallet::create([
        "user_id"=>Auth::user()->id,
        "price"=>$app->total
          ]);
                        }
                    }

                    $deleteSucc=Appointment::where('id', $app->id)->delete();
                    if ($deleteSucc) {
                        $request->session()->flash('success', "Appointment Cancel successfully");
                    } else {
                        $request->session()->flash('error', "Sorry!!Appointment Cancel Unsuccessfully");
                    }
                } else {
                    $order=Order::find($app->order_id);
                    $vat=($order->vat_amount-$app->vat_price);
                    $sub=($order->sub_total-$app->price);
                    $total=($order->total-$app->total);
                    $order->json_app_id=json_encode($arr);
                    $order->vat_amount=$vat;
                    $order->sub_total=$sub;
                    $order->total=$total;
                    $order->save();


                    if ($app->is_paid==1) {
                        $cwalet=Wallet::where("user_id", Auth::user()->id)->first();
                        if ($cwalet) {
                            $up=$cwalet->price+$app->total;
                            Wallet::where('user_id', Auth::user()->id)->update([
        "price"=>$up
          ]);
                        } else {
                            Wallet::create([
        "user_id"=>Auth::user()->id,
        "price"=>$app->total
          ]);
                        }
                    }
                    $cart=Order::orderCartProduct2($order->id);
                    if ($cart) {
                    } else {
                        Order::where('id', $order->id)->delete();
                    }
                    $deleteSucc=Appointment::where('id', $app->id)->delete();
                    if ($deleteSucc) {
                        $request->session()->flash('success', "Appointment Cancel successfully");
                    } else {
                        $request->session()->flash('error', "Sorry!!Appointment Cancel Unsuccessfully");
                    }
                }
            } else {
                if ($app->is_paid==1) {
                    $cwalet=Wallet::where("user_id", Auth::user()->id)->first();
                    if ($cwalet) {
                        $up=$cwalet->price+$app->grand_total_with_vat;
                        Wallet::where('user_id', Auth::user()->id)->update([
        "price"=>$up
          ]);
                    } else {
                        Wallet::create([
        "user_id"=>Auth::user()->id,
        "price"=>$app->grand_total_with_vat
          ]);
                    }
                }

                if ($app->is_order==1) {
                    $order=Order::find($app->order_id);

                    Order::where('id', $order->id)->delete();
                }
                $deleteSucc=Appointment::where('id', $app->id)->delete();
                if ($deleteSucc) {
                    $request->session()->flash('success', "Appointment Cancel successfully");
                } else {
                    $request->session()->flash('error', "Sorry!!Appointment Cancel Unsuccessfully");
                }
            }
        }
        return back();
    }
}
