<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Http\Models\Client;
use App\Order;
use App\User;
use App\Http\Models\Vat;
use App\Http\Models\Cart;
use App\Http\Models\Wallet;
use App\Http\Models\Invoice;
use DB;
use DateTime;
use DateInterval;
use Auth;
use Carbon\Carbon;
use Mollie;
use Socialite;

class Appointment extends Model
{
    protected $guarded = ['id'];
    protected $table = "appointments";


    public static function compelteCheckOut($data = '')
    {
        $is_account = $data['user_loggedin'];
        if ($is_account == 1) {
            $save = 1;
        } else {
            $save = Client::create([
                'first_name' => $data['first_name'],
                'last_name' => @$data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt('12345'),
                'vat_number' => $data['user_vat_number'],
                'role_id' => 0,
                'user_type' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $user_id = $save->id;

        }

        if ($save) {


            if ($is_account == 1) {
                $save = 1;
                $user_id = $data['user_id'];
            } else {
                if (!empty($data['is_acc'])) {
                    if (!empty($data['password'])) {
                        Client::where('id', $save->id)->update([
                            'password' => bcrypt($data['password']),

                        ]);
                    }
                }
                DB::table('user_address')->insert([
                    'user_id' => $user_id,
                    'invoice_address' => $data['address'],
                    'post_code' => $data['post_code'],
                    'city' => $data['city'],
                    'country_name' => $data['country'],
                    'shipping_address' => $data['s_address'],
                    'shipping_post_code' => $data['s_post'],
                    'shopping_city' => $data['s_city'],
                    'shipping_country_name' => $data['s_country'],
                    'status' => 1,
                ]);
            }

            $getAppId = 0;
            if (!empty($data['appointment_type_id'])) {
                if (count($data['appointment_type_id']) > 0) {
                    $client = User::find($user_id);

                    $datea = Carbon::parse($data['start_time'])->addHour(1);
                    $endtime = substr($datea, 10, 6);


                    $sourch_list = $data['first_name'] . ': ' . $data['start_time'] . '-' . $endtime;
                    $appdate = $data['date'] . ' ' . $data['start_time'];
                    $enddate = $data['date'] . ' ' . $endtime;

                    $getVatNumber = $data['vat_number'];
                    //total
                    $totalPriceProduct = $data['appointment_price'];
                    // price
                    $theVatAdded = round($totalPriceProduct - ($totalPriceProduct / (($getVatNumber / 100) + 1)), 2);
                    //vat price
                    $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));

                    $getAppId = DB::table('appointments')->insertGetId([
                        'date' => $data['date'],
                        'user_id' => $user_id,
                        'start_time_id' => $data['start_time_id'],
                        'specialist_id' => $data['specialist_id'],
                        'appointment_type_id' => $data['appointment_type_id'],
                        'appointment_type' => $data['appointment_type'],
                        'color' => $data['color'],
                        'start_time' => $data['start_time'],
                        'end_time' => $endtime,
                        'price' => $priceforUser,
                        'vat_number' => 0,
                        'total' => $totalPriceProduct,
                        'vat_price' => $theVatAdded,
                        'time_and_appointmnet_name' => $sourch_list,
                        'appdateTime' => $appdate,
                        'enddateTime' => $enddate,
                        'status' => 1,
                        'recurring' => 0,
                        'interval' => 0,
                        'week_note' => 0,
                        'week_time' => 0,
                        'sourch' => 'FrontEnd',
                        'is_cancel' => '0',
                        'is_order' => '0',
                        'active_status' => '1',
                        'is_paid' => '0',
                        'is_wallet' => '0',
                        'is_parsonal' => '0',
                        'grand_vat' => $data['grand_vat'],
                        'grand_total' => $data['sub_total'],
                        'grand_total_with_vat' => $data['total_with_vat'],
                        'shippment_cost' => '0',

                    ]);
                }
            }
            $getAppId = $getAppId;
            $orderNo = $getAppId;
            $paymentMethod = 0;
            if (isset($data['payment_method'])) {
                $paymentMethod = $data['payment_method'];
            } else {
                $paymentMethod = 0;
            }

            $orderNo = self::makeId('', 4);
            $order = Order::create([
                'date' => date('Y-m-d'),
                'user_id' => $user_id,
                'order_no' => $orderNo,
                'appoitment_id' => $getAppId,
                'vat_number' => 0,
                'vat_amount' => $data['grand_vat'],
                'sub_total' => $data['sub_total'],
                'wallet_paid' => 0,
                'total' => $data['total_with_vat'],
                'is_wallet' => 0,
                'is_paid' => 0,
                'paid' => 0,
                'payment_method' => $paymentMethod,
                'status' => 1,
                'order_note' => $data['order_note'],
                'order_sourch' => "Frontend",
                'shippment_cost' => 0,
            ]);
            $app = Appointment::find($getAppId);
            if ($app) {
                $app->is_order = 1;
                $app->order_id = $order->id;
                $app->save();
            }
            Invoice::create([
                'order_id' => $order->id,
                'appointment_id' => $getAppId,
                'client_id' => $user_id,
                'note' => "",
                'date' => date('Y-m-d'),
            ]);

            if (!empty($data['product_id'])) {
                if (count($data['product_id']) > 0) {


                    if ($order) {

                        for ($j = 0; $j < sizeof($data['product_id']); $j++) {

                            $totalPriceProducta = $data['product_price'][$j];

                            $getVatNumbera = $data['product_vat'][$j];

                            $theVatAdd = round($totalPriceProducta - ($totalPriceProducta / (($getVatNumbera / 100) + 1)), 2);

                            $pricefor = (floatval($totalPriceProducta) - floatval($theVatAdd));
                            DB::table('order_product_cart')->insert([
                                'order_id' => $order->id,
                                'appointment_id' => $getAppId,
                                'product_id' => $data['product_id'][$j],
                                'product_name' => $data['product_name'][$j],
                                'product_option_id' => $data['product_option_id'][$j],
                                'product_option' => $data['product_option'][$j],
                                'price' => $pricefor,
                                'product_vat' => $data['product_vat'][$j],
                                'vat_price' => $theVatAdd,
                                'quantity' => $data['qty'][$j],
                                'total' => $data['product_price'][$j],
                                'image' => $data['image'][$j],
                                'status' => 1,
                            ]);
                        }
                    }

                }
            }
            if (isset($data['payment_method'])) {

                if ($data['payment_method'] == 2) {

                    $customer = Mollie::api()->customers()->create([
                        "name" => $data['first_name'],
                        "email" => $data['email'],
                    ]);


                    $payment = mollie::api()->payments()->create([
                        'amount' => $data['total_with_vat'],
                        'customerId' => $customer->id,
                        'recurringType' => 'first',
                        'description' => 'My Order Payment',
                        'redirectUrl' => url('payment/paymentcheck/' . $order->id),
                    ]);
                    $customer_payment_reference = $payment->customerId;
                    $payment_id = $payment->id;
                    // $orderNo=self::makeId('',4);

                    Order::where('id', $order->id)->update(array(
                        'payment_id' => $payment_id,
                        'customer_payment_reference' => $customer_payment_reference

                    ));

                }

            }

            Session::forget('appoinmentCart');
            Session::forget('shopcart');
            $success = array(
                'order_number' => $orderNo,
                'first_name' => $data['first_name'],
                'last_name' => @$data['last_name'],
                'email' => $data['email']);
            Cart::orderProcessSuccess($success);

            $sendTrueAndMollie = [true, $payment];
            return $sendTrueAndMollie;
        }

        return false;
    }

    public static function checkOutWithMoreAppointment($data = '')
    {

        $is_account = $data['user_loggedin'];
        if ($is_account == 1) {
            $save = 1;
        } else {
            $save = Client::create([
                'first_name' => $data['first_name'],
                'last_name' => @$data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt('12345'),
                'vat_number' => $data['user_vat_number'],
                'role_id' => 0,
                'user_type' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $user_id = $save->id;

        }

        if ($save) {
            if ($is_account == 1) {
                $save = 1;
                $user_id = $data['user_id'];
            } else {
                if (!empty($data['is_acc'])) {
                    if (!empty($data['password'])) {
                        Client::where('id', $save->id)->update([
                            'password' => bcrypt($data['password']),

                        ]);
                    }
                }
                DB::table('user_address')->insert([
                    'user_id' => $user_id,
                    'invoice_address' => $data['address'],
                    'post_code' => $data['post_code'],
                    'city' => $data['city'],
                    'country_name' => $data['country'],
                    'shipping_address' => $data['s_address'],
                    'shipping_post_code' => $data['s_post'],
                    'shopping_city' => $data['s_city'],
                    'shipping_country_name' => $data['s_country'],
                    'status' => 1,
                ]);
            }

            $getAppId = 0;
            $orderNo = self::makeId('', 4);
            $client = User::find($user_id);
            $order = Order::create([
                'date' => date('Y-m-d'),
                'user_id' => $user_id,
                'order_no' => $orderNo,
                'appoitment_id' => 0,
                'vat_number' => 0,
                'vat_amount' => $data['grand_vat'],
                'sub_total' => $data['sub_total'],
                'wallet_paid' => 0,
                'total' => $data['total_with_vat'],
                'is_wallet' => 0,
                'is_paid' => 0,
                'paid' => 0,
                'payment_method' => @$data['payment_method'],
                'status' => 1,
                'order_note' => $data['order_note'],
                'order_sourch' => "Frontend",
                'shippment_cost' => 0,
            ]);

            if (!empty($data['appointment_type_id'])) {
                if (count($data['appointment_type_id']) > 0) {

                    $appointmentId = array();
                    for ($i = 0; $i < sizeof($data['appointment_type_id']); $i++) {
                        $datea = Carbon::parse($data['start_time'][$i])->addHour(1);
                        $endtime = substr($datea, 10, 6);
                        $sourch_list = $data['first_name'] . ': ' . $data['start_time'][$i] . '-' . $endtime;
                        $appdate = $data['date'][$i] . ' ' . $data['start_time'][$i];
                        $enddate = $data['date'][$i] . ' ' . $endtime;

                        $getVatNumber = $data['vat_number'][$i];
                        //total
                        $totalPriceProduct = $data['appointment_price'][$i];
                        // price
                        $theVatAdded = round($totalPriceProduct - ($totalPriceProduct / (($getVatNumber / 100) + 1)), 2);
                        //vat price
                        $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));
                        $appId = DB::table('appointments')->insertGetId([
                            'date' => $data['date'][$i],
                            'user_id' => $user_id,
                            'start_time_id' => $data['start_time_id'][$i],
                            'specialist_id' => $data['specialist_id'][$i],
                            'appointment_type_id' => $data['appointment_type_id'][$i],
                            'appointment_type' => $data['appointment_type'][$i],
                            'color' => $data['color'][$i],
                            'start_time' => $data['start_time'][$i],
                            'end_time' => $endtime,
                            'price' => $priceforUser,
                            'vat_number' => 0,
                            'total' => $totalPriceProduct,
                            'vat_price' => $theVatAdded,
                            'time_and_appointmnet_name' => $sourch_list,
                            'appdateTime' => $appdate,
                            'enddateTime' => $enddate,
                            'status' => 1,
                            'active_status' => 1,
                            'recurring' => 0,
                            'interval' => 0,
                            'week_note' => 0,
                            'week_time' => 0,
                            'sourch' => 'FrontEnd',
                            'is_cancel' => '0',
                            'is_order' => '0',
                            'is_paid' => '0',
                            'is_wallet' => '0',
                            'is_parsonal' => '0',
                            'grand_vat' => $theVatAdded,
                            'grand_total' => $priceforUser,
                            'grand_total_with_vat' => $totalPriceProduct,
                            'shippment_cost' => '0',
                            'order_id' => $order->id,

                        ]);

                        $appointmentId[] = $appId;
                    }
                }

            }

// /======================save More Appointment Id In Order Table=============================
            $order = Order::find($order->id);
            $order->json_app_id = json_encode($appointmentId);
            $order->save();
// /======================end save More Appointment Id In Order Table=============================

            if (!empty($data['product_id'])) {
                if (count($data['product_id']) > 0) {
                    for ($j = 0; $j < sizeof($data['product_id']); $j++) {

                        $totalPriceProducta = $data['product_price'][$j];

                        $getVatNumbera = $data['product_vat'][$j];

                        $theVatAdd = round($totalPriceProducta - ($totalPriceProducta / (($getVatNumbera / 100) + 1)), 2);

                        $pricefor = (floatval($totalPriceProducta) - floatval($theVatAdd));
                        DB::table('order_product_cart')->insert([
                            'order_id' => $order->id,
                            'appointment_id' => $getAppId,
                            'product_id' => $data['product_id'][$j],
                            'product_name' => $data['product_name'][$j],
                            'product_option_id' => $data['product_option_id'][$j],
                            'product_option' => $data['product_option'][$j],
                            'price' => $pricefor,
                            'product_vat' => $data['product_vat'][$j],
                            'vat_price' => $theVatAdd,
                            'quantity' => $data['qty'][$j],
                            'total' => $data['product_price'][$j],
                            'image' => $data['image'][$j],
                            'status' => 1,
                        ]);
                    }


                }
            }

            Invoice::create([
                'order_id' => $order->id,
                'appointment_id' => $getAppId,
                'client_id' => $user_id,
                'note' => "",
                'date' => date('Y-m-d'),
            ]);
//================This Method for mollie==========================
            if (isset($data['payment_method'])) {
                if ($data['payment_method'] == 2) {

                    $customer = Mollie::api()->customers()->create([
                        "name" => $data['first_name'],
                        "email" => $data['email'],
                    ]);


                    $payment = mollie::api()->payments()->create([
                        'amount' => $data['total_with_vat'],
                        'customerId' => $customer->id,
                        'recurringType' => 'first',
                        'description' => 'My Order Payment',
                        'redirectUrl' => url('payment/paymentcheck/' . $order->id),
                    ]);
                    $customer_payment_reference = $payment->customerId;
                    $payment_id = $payment->id;
                    // $orderNo=self::makeId('',4);

                    Order::where('id', $order->id)->update(array(
                        'payment_id' => $payment_id,
                        'customer_payment_reference' => $customer_payment_reference
                    ));
                }
            }


            Session::forget('appoinmentCart');
            Session::forget('shopcart');
            $success = array(
                'order_number' => $orderNo,
                'first_name' => $data['first_name'],
                'last_name' => @$data['last_name'],
                'email' => $data['email'],

            );
            Cart::orderProcessSuccess($success);
            $sendTrueAndMollie = [true, $payment];
            return $sendTrueAndMollie;
        }

        return false;
    }

    public static function checkOutWithMoreAppointmentAuth($data = '')
    {

        $getAppId = 0;
        $client = User::find(Auth::user()->id);

        $orderNo = self::makeId('', 4);
        $client = User::find(Auth::user()->id);
        $order = Order::create([
            'date' => date('Y-m-d'),
            'user_id' => Auth::user()->id,
            'order_no' => $orderNo,
            'appoitment_id' => 0,
            'vat_number' => 0,
            'vat_amount' => $data['grand_vat_price'],
            'sub_total' => $data['sub_total'],
            'wallet_paid' => 0,
            'total' => $data['total_with_vat'],
            'is_wallet' => 0,
            'is_paid' => 0,
            'paid' => 0,
            'payment_method' => 0,
            'status' => 1,
            'order_note' => "",
            'order_sourch' => "Frontend",
            'shippment_cost' => 0,
        ]);

        if (!empty($data['appointment_type_id'])) {
            if (count($data['appointment_type_id']) > 0) {

                $appointmentId = array();
                for ($i = 0; $i < sizeof($data['appointment_type_id']); $i++) {
                    $datea = Carbon::parse($data['start_time'][$i])->addHour(1);
                    $endtime = substr($datea, 10, 6);
                    $sourch_list = Auth::user()->first_name . ': ' . $data['start_time'][$i] . '-' . $endtime;
                    $appdate = $data['date'][$i] . ' ' . $data['start_time'][$i];
                    $enddate = $data['date'][$i] . ' ' . $endtime;

                    $getVatNumber = $data['vat_number'][$i];
                    //total
                    $totalPriceProduct = $data['appointment_price'][$i];
                    // price
                    $theVatAdded = round($totalPriceProduct - ($totalPriceProduct / (($getVatNumber / 100) + 1)), 2);
                    //vat price
                    $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));
                    $appId = DB::table('appointments')->insertGetId([
                        'date' => $data['date'][$i],
                        'user_id' => Auth::user()->id,
                        'start_time_id' => $data['start_time_id'][$i],
                        'specialist_id' => $data['specialist_id'][$i],
                        'appointment_type_id' => $data['appointment_type_id'][$i],
                        'appointment_type' => $data['appointment_type'][$i],
                        'color' => $data['color'][$i],
                        'start_time' => $data['start_time'][$i],
                        'end_time' => $endtime,
                        'price' => $priceforUser,
                        'vat_number' => 0,
                        'total' => $totalPriceProduct,
                        'vat_price' => $theVatAdded,
                        'time_and_appointmnet_name' => $sourch_list,
                        'appdateTime' => $appdate,
                        'enddateTime' => $enddate,
                        'status' => 1,
                        'active_status' => 1,
                        'recurring' => 0,
                        'interval' => 0,
                        'week_note' => 0,
                        'week_time' => 0,
                        'sourch' => 'FrontEnd',
                        'is_cancel' => '0',
                        'is_order' => '0',
                        'is_paid' => '0',
                        'is_wallet' => '0',
                        'is_parsonal' => '0',
                        'grand_vat' => $theVatAdded,
                        'grand_total' => $priceforUser,
                        'grand_total_with_vat' => $totalPriceProduct,
                        'shippment_cost' => '0',
                        'order_id' => $order->id,

                    ]);

                    $appointmentId[] = $appId;
                }
            }

        }
// /======================save More Appointment Id In Order Table=============================
        $order = Order::find($order->id);
        $order->json_app_id = json_encode($appointmentId);
        $order->save();


        $orderNumber = $orderNo;

        if (!empty($data['product_id'])) {
            if (count($data['product_id']) > 0) {

                for ($j = 0; $j < sizeof($data['product_id']); $j++) {
                    $totalPriceProducta = $data['product_price'][$j];
                    $percent = $data['product_vat'][$j];
                    $theVatAdd = round($totalPriceProducta - ($totalPriceProducta / (($percent / 100) + 1)), 2);
                    $pricefor = (floatval($totalPriceProducta) - floatval($theVatAdd));
                    DB::table('order_product_cart')->insert([
                        'order_id' => $order->id,
                        'appointment_id' => $getAppId,
                        'product_id' => $data['product_id'][$j],
                        'product_name' => $data['product_name'][$j],
                        'product_option_id' => $data['product_option_id'][$j],
                        'product_option' => $data['product_option'][$j],
                        'price' => $pricefor,
                        'product_vat' => $data['product_vat'][$j],
                        'vat_price' => $theVatAdd,
                        'quantity' => $data['qty'][$j],
                        'total' => $data['product_price'][$j],
                        'image' => $data['image'][$j],
                        'status' => 1,
                    ]);
                }


            }
        }


        if (!empty($data['my_wallet'])) {
            if ($data['total_with_vat'] > $data["my_wallet_amount"]) {
                $isPaid = 0;
                $paid = $data['wallet_price'];
            } else {
                $isPaid = 1;
                $paid = $data['wallet_price'];
            }
            Wallet::where('user_id', Auth::user()->id)
                ->update([
                    'price' => $data['my_wallet_amount'],
                ]);

            DB::table("user_previous_wallet_amount_records")->insert([
                'date' => date('Y-m-d'),
                'user_id' => Auth::user()->id,
                'appointment_id' => $getAppId,
                'amount' => $data['my_wallet_amount_old'],
                'created_by' => Auth::user()->id,
            ]);


            $obj = Order::find($order->id);
            $obj->is_paid = $isPaid;
            $obj->is_wallet = $data['my_wallet'];
            $obj->wallet_paid = $paid;
            $obj->paid = $paid;
            $obj->save();

            $da = Order::find($order->id);
            $jsvalues = json_decode($da->json_app_id);
            if ($jsvalues) {
                foreach ($jsvalues as $key => $value) {

                    $app = Appointment::find($value);
                    if ($app) {
                        $app->is_paid = $isPaid;
                        $app->save();
                    }
                }
            }


        }


        Invoice::create([
            'order_id' => $order->id,
            'appointment_id' => $getAppId,
            'client_id' => Auth::user()->id,
            'note' => "",
            'date' => date('Y-m-d'),
        ]);


        Session::forget('appoinmentCart');
        Session::forget('shopcart');
        $success = array(
            'order_number' => $orderNumber,
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'email' => Auth::user()->email);
        Cart::orderProcessSuccess($success);
        return true;

    }


    public static function compelteCheckOutAuth($data = '')
    {

        $getAppId = 0;
        $client = User::find(Auth::user()->id);

        if (!empty($data['appointment_type_id'])) {
            if (count($data['appointment_type_id']) > 0) {

                $datea = Carbon::parse($data['start_time'])->addHour(1);
                $endtime = substr($datea, 10, 6);

                $sourch_list = $client->first_name . ': ' . $data['start_time'] . '-' . $endtime;

                $appdate = $data['date'] . ' ' . $data['start_time'];
                $enddate = $data['date'] . ' ' . $endtime;

                $getVatNumber = $data['vat_number'];
                //total
                $totalPriceProduct = $data['appointment_price'];
                // price
                $theVatAdded = round($totalPriceProduct - ($totalPriceProduct / (($getVatNumber / 100) + 1)), 2);
                //vat price
                $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));

                $getAppId = DB::table('appointments')->insertGetId([
                    'date' => $data['date'],
                    'user_id' => Auth::user()->id,
                    'start_time_id' => $data['start_time_id'],
                    'specialist_id' => $data['specialist_id'],
                    'appointment_type_id' => $data['appointment_type_id'],
                    'appointment_type' => $data['appointment_type'],
                    'color' => $data['color'],
                    'start_time' => $data['start_time'],
                    'end_time' => $endtime,
                    'price' => $priceforUser,
                    'vat_number' => 0,
                    'total' => $totalPriceProduct,
                    'vat_price' => $theVatAdded,
                    'time_and_appointmnet_name' => $sourch_list,
                    'appdateTime' => $appdate,
                    'enddateTime' => $enddate,
                    'status' => 1,
                    'active_status' => 1,
                    'recurring' => 0,
                    'interval' => 0,
                    'week_note' => 0,
                    'week_time' => 0,
                    'sourch' => 'FrontEnd',
                    'is_cancel' => '0',
                    'is_order' => '0',
                    'is_paid' => '0',
                    'is_wallet' => '0',
                    'is_parsonal' => '0',
                    'grand_vat' => $data['grand_vat_price'],
                    'grand_total' => $data['sub_total'],
                    'grand_total_with_vat' => $data['total_with_vat'],
                    'shippment_cost' => '0',

                ]);
            }
        }


        $orderNumber = $getAppId;
        $orderNo = self::makeId('', 4);
        $orderNumber = $orderNo;
        $order = Order::create([
            'date' => date('Y-m-d'),
            'user_id' => Auth::user()->id,
            'order_no' => $orderNo,
            'appoitment_id' => $getAppId,
            'vat_number' => 0,
            'vat_amount' => $data['grand_vat_price'],
            'sub_total' => $data['sub_total'],
            'wallet_paid' => 0,
            'total' => $data['total_with_vat'],
            'is_wallet' => 0,
            'is_paid' => 0,
            'paid' => 0,
            'payment_method' => 0,
            'status' => 1,
            'order_note' => " ",
            'order_sourch' => "Frontend",
            'shippment_cost' => 0,
        ]);
        $app = Appointment::find($getAppId);
        if ($app) {
            $app->is_order = 1;
            $app->save();
        }

        if (!empty($data['product_id'])) {
            if (count($data['product_id']) > 0) {


                if ($order) {


                    for ($j = 0; $j < sizeof($data['product_id']); $j++) {
                        $totalPriceProducta = $data['product_price'][$j];
                        $percent = $data['product_vat'][$j];
                        $theVatAdd = round($totalPriceProducta - ($totalPriceProducta / (($percent / 100) + 1)), 2);
                        $pricefor = (floatval($totalPriceProducta) - floatval($theVatAdd));
                        DB::table('order_product_cart')->insert([
                            'order_id' => $order->id,
                            'appointment_id' => $getAppId,
                            'product_id' => $data['product_id'][$j],
                            'product_name' => $data['product_name'][$j],
                            'product_option_id' => $data['product_option_id'][$j],
                            'product_option' => $data['product_option'][$j],
                            'price' => $pricefor,
                            'product_vat' => $data['product_vat'][$j],
                            'vat_price' => $theVatAdd,
                            'quantity' => $data['qty'][$j],
                            'total' => $data['product_price'][$j],
                            'image' => $data['image'][$j],
                            'status' => 1,
                        ]);
                    }
                }

            }
        }


        if (!empty($data['my_wallet'])) {
            if ($data['total_with_vat'] > $data["my_wallet_amount"]) {
                $isPaid = 0;
                $paid = $data['wallet_price'];
            } else {
                $isPaid = 1;
                $paid = $data['wallet_price'];
            }
            Wallet::where('user_id', Auth::user()->id)
                ->update([
                    'price' => $data['my_wallet_amount'],
                ]);

            DB::table("user_previous_wallet_amount_records")->insert([
                'date' => date('Y-m-d'),
                'user_id' => Auth::user()->id,
                'appointment_id' => $getAppId,
                'amount' => $data['my_wallet_amount_old'],
                'created_by' => Auth::user()->id,
            ]);

            $app = Appointment::find($getAppId);
            if ($app) {
                $app->is_paid = $isPaid;
                $app->save();
            }

            $order = Order::where('appoitment_id', $getAppId)->first();
            if ($order) {

                $obj = Order::find($order->id);
                $obj->is_paid = $isPaid;
                $obj->is_wallet = $data['my_wallet'];
                $obj->wallet_paid = $paid;
                $obj->paid = $paid;
                $obj->save();

            } else {
                $orderNo = self::makeId('', 4);
                $orderNumber = $orderNo;
                $order = Order::create([
                    'date' => date('Y-m-d'),
                    'user_id' => Auth::user()->id,
                    'order_no' => $orderNo,
                    'appoitment_id' => $getAppId,
                    'vat_number' => 0,
                    'vat_amount' => $data['grand_vat_price'],
                    'sub_total' => $data['sub_total'],
                    'wallet_paid' => $paid,
                    'total' => $data['total_with_vat'],
                    'is_wallet' => $data['my_wallet'],
                    'is_paid' => $isPaid,
                    'paid' => $paid,
                    'payment_method' => 0,
                    'status' => 1,
                    'order_note' => " ",
                    'order_sourch' => "Frontend",
                    'shippment_cost' => 0,
                ]);

                $app = Appointment::find($getAppId);
                if ($app) {
                    $app->is_order = 1;
                    $app->save();
                }

            }
        }
        Invoice::create([
            'order_id' => $order->id,
            'appointment_id' => $getAppId,
            'client_id' => Auth::user()->id,
            'note' => "",
            'date' => date('Y-m-d'),
        ]);

        Session::forget('appoinmentCart');
        Session::forget('shopcart');
        $success = array(
            'order_number' => $orderNumber,
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'email' => Auth::user()->email);
        Cart::orderProcessSuccess($success);
        return true;

    }


    public static function  makeId($prefix, $id_length)
    {

        $result = DB::select('select MAX(order_no) as `id` from `orders`');
        $max_id = $result[0]->id;
        //print $max_id."<br/>";
        $prefix_length = strlen($prefix);
        //print $prefix_length."<br/>";
        $only_id = substr($max_id, $prefix_length);
        //print $only_id;
        $new = (int)($only_id);
        //print $new;
        $new++;
        //print $new;
        $number_of_zero = $id_length - $prefix_length - strlen($new);
        $zero = str_repeat("0", $number_of_zero);
        //print $zero;
        $made_id = $prefix . $zero . $new;
        //print $made_id;
        return $made_id;

    }


    public static function UpdateAppointment($data = '')
    {
        $exp = explode('_', $data['start_time']);
        $date = new DateTime($exp[1]);
        $endtime = $date->format('h:i');
        $date->add(new DateInterval('PT60M'));
        $sourch_list = Auth::user()->first_name . ': ' . $data['start_time'] . '-' . $endtime;
        $appdate = $data['appointment_date'] . ' ' . $data['start_time'];
        $enddate = $data['appointment_date'] . ' ' . $endtime;
        $db = DB::table('appointments')
            ->where('id', $data['appointment_id'])
            ->update([
                'start_time_id' => $exp[0],
                'start_time' => $exp[1],
                'end_time' => $endtime,
                'date' => $data['appointment_date'],
                'appdateTime' => $appdate,
                'enddateTime' => $enddate,
                'time_and_appointmnet_name' => $sourch_list,
            ]);
        if ($db) {
            return true;
        }
        return false;

    }


    public static function appointmentList()
    {
        $data = DB::table('appointments')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->leftjoin('invoices', 'appointments.id', '=', 'invoices.appointment_id')
            ->leftjoin('orders', 'appointments.id', '=', 'orders.appoitment_id')
            ->select('appointments.*', 'orders.id as orderId', 'appointments.appointment_type', 'appointments.start_time', 'appointments.end_time', 'appointments.status as appStatus', 'users.first_name', 'appointments.date as bookingDate', 'appointments.is_cancel', 'appointments.id as appointmentID', 'invoices.id as invoiceId')
            ->orderBy('appointments.id', 'DESC')
            ->get();
        return $data;
    }


    public static function checkAppointment($data = '')
    {
        $data = DB::table('appointments')
            ->where('date', $data['days'])
            ->where('start_time_id', $data['id'])
            ->first();
        if ($data) {
            return true;
        } else {
            return false;

        }
    }


    public static function saveAppointment($data = '')
    {

        $client = User::find($data['client_id']);

        $users = DB::table('user_address')->where('user_id', $data['client_id'])->first();
        $vat = Vat::where('country_id', $users->shipping_country_name)->first();
        $subTotal = $data['type_price'];


        $datea = Carbon::parse($data['start_times'])->addHour(1);
        $endtime = substr($datea, 10, 6);

        $sourch_list = $client->first_name . ': ' . $data['start_times'] . '-' . $endtime;

        $appdate = $data['date_value'] . ' ' . $data['start_times'];
        $enddate = $data['date_value'] . ' ' . $endtime;
        $requer = 0;
        if (isset($data['recurring'])) {
            $requer = $data['recurring'];
        } else {
            $requer = 0;
        }

        $getVatNumber = $data['vat_number'];
        //total
        $totalPriceProduct = $data['type_price'];
        // price
        $theVatAdded = round($totalPriceProduct - ($totalPriceProduct / (($getVatNumber / 100) + 1)), 2);
        //vat price
        $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));


        $app = DB::table('appointments')->insertGetId([
            'date' => $data['date_value'],
            'user_id' => $data['client_id'],
            'start_time_id' => $data['start_time'],
            'specialist_id' => Auth::user()->id,
            'appointment_type_id' => $data['appointment_type'],
            'appointment_type' => $data['type_name'],
            'start_time' => $data['start_times'],
            'end_time' => $endtime,
            'price' => $priceforUser,
            'vat_number' => $data['vat_number'],
            'total' => $totalPriceProduct,
            'vat_price' => $theVatAdded,
            'time_and_appointmnet_name' => $sourch_list,
            'status' => 1,
            'active_status' => 1,
            'recurring' => $requer,
            'interval' => $data['interval'],
            'week_note' => $data['week_note'],
            'week_time' => $data['week_time'],
            'appdateTime' => $appdate,
            'enddateTime' => $enddate,
            'sourch' => 'Backend',
            'is_order' => '0',
            'is_paid' => '0',
            'is_parsonal' => '0',
            'is_cancel' => '0',
            'is_wallet' => '0',
            'is_wallet' => '0',
            'grand_vat' => $theVatAdded,
            'grand_total' => $priceforUser,
            'grand_total_with_vat' => $totalPriceProduct,
            'shippment_cost' => '0',
            'color' => $data['color'],

        ]);

        if (isset($data['recurring'])) {
            if ($data['recurring'] == 1) {
                if ($data['interval'] == 1) {

                    $start_date = $data['date_value'];
// $datewe = strtotime($start_date);
// $datewe = strtotime("+".$data['week_note']." day", $datewe);
// $weekdate= date('Y-m-d', $datewe);
                    $k = 0;
                    for ($j = 0; $j < $data['week_time']; $j++) {

                        for ($i = 0; $i <= 6; $i++) {

                            if ($i == 6) {
                                $k = $k + $data['week_note'];
                                $datea = Carbon::parse($data['date_value'])->addDays($k);

                                $appdate = substr($datea, 0, 10) . ' ' . $data['start_times'];
                                $enddate = substr($datea, 0, 10) . ' ' . $endtime;
                                $app = DB::table('appointments')->insertGetId([
                                    'date' => $datea,
                                    'user_id' => $data['client_id'],
                                    'start_time_id' => $data['start_time'],
                                    'specialist_id' => Auth::user()->id,
                                    'appointment_type_id' => $data['appointment_type'],
                                    'appointment_type' => $data['type_name'],
                                    'start_time' => $data['start_times'],
                                    'end_time' => $endtime,
                                    'price' => $priceforUser,
                                    'vat_number' => $data['vat_number'],
                                    'total' => $totalPriceProduct,
                                    'vat_price' => $theVatAdded,
                                    'time_and_appointmnet_name' => $sourch_list,
                                    'status' => 1,
                                    'recurring' => 0,
                                    'interval' => 0,
                                    'week_note' => 0,
                                    'week_time' => 0,
                                    'appdateTime' => $appdate,
                                    'enddateTime' => $enddate,
                                    'sourch' => 'Backend',
                                    'is_order' => '0',
                                    'grand_vat' => $theVatAdded,
                                    'grand_total' => $priceforUser,
                                    'grand_total_with_vat' => $totalPriceProduct,
                                    'shippment_cost' => '0',
                                    'color' => $data['color'],
                                ]);

                            }

                        }
                    }

                } elseif ($data['interval'] == 2) {

                    $k = 0;
                    for ($j = 0; $j < $data['week_time']; $j++) {

                        for ($i = 0; $i <= 6; $i++) {

                            if ($i == 6) {
                                $k = $k + $data['week_note'];
                                $date = Carbon::parse($data['date_value'])->addWeeks($k);
                                $appdate = $date->addHours($data['start_times']);

                                $enddate = Carbon::parse($appdate)->addHours(1);
                                $app = DB::table('appointments')->insertGetId([
                                    'date' => $date,
                                    'user_id' => $data['client_id'],
                                    'start_time_id' => $data['start_time'],
                                    'specialist_id' => Auth::user()->id,
                                    'appointment_type_id' => $data['appointment_type'],
                                    'appointment_type' => $data['type_name'],
                                    'start_time' => $data['start_times'],
                                    'end_time' => $endtime,
                                    'price' => $priceforUser,
                                    'vat_number' => $data['vat_number'],
                                    'total' => $totalPriceProduct,
                                    'vat_price' => $theVatAdded,
                                    'time_and_appointmnet_name' => $sourch_list,
                                    'status' => 1,
                                    'active_status' => 1,
                                    'recurring' => 0,
                                    'interval' => 0,
                                    'week_note' => 0,
                                    'week_time' => 0,
                                    'appdateTime' => $appdate,
                                    'enddateTime' => $enddate,
                                    'sourch' => 'Backend',
                                    'is_order' => '0',
                                    'grand_vat' => $theVatAdded,
                                    'grand_total' => $priceforUser,
                                    'grand_total_with_vat' => $totalPriceProduct,
                                    'shippment_cost' => '0',
                                    'color' => $data['color'],
                                ]);

                            }
                        }
                    }

                } elseif ($data['interval'] == 3) {

                    $start_date = $data['date_value'];
                    $datewe = strtotime($start_date);
                    $datewe = strtotime("+" . $data['week_note'] . " month", $datewe);
                    $weekdate = date('Y-m-d', $datewe);
                    $k = 0;
                    for ($j = 0; $j < $data['week_time']; $j++) {

                        for ($i = 0; $i <= 6; $i++) {

                            if ($i == 6) {
                                $k = $k + $data['week_note'];
                                $monthDate = Carbon::parse($data['date_value'])->addMonths($k);

                                $appdate = substr($monthDate, 0, 10) . ' ' . $data['start_times'];
                                $enddate = substr($monthDate, 0, 10) . ' ' . $endtime;
                                // $getVatNumber = '1.' . $data['vat_number'];
                                // //total
                                // $totalPriceProduct = $data['type_price'];
                                // // price
                                // $theVatAdded = (floatval($totalPriceProduct)/floatval($getVatNumber));
                                // //vat price
                                // $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));
                                $app = DB::table('appointments')->insertGetId([
                                    'date' => $monthDate,
                                    'user_id' => $data['client_id'],
                                    'start_time_id' => $data['start_time'],
                                    'specialist_id' => Auth::user()->id,
                                    'appointment_type_id' => $data['appointment_type'],
                                    'appointment_type' => $data['type_name'],
                                    'start_time' => $data['start_times'],
                                    'end_time' => $endtime,
                                    'price' => $priceforUser,
                                    'vat_number' => $data['vat_number'],
                                    'total' => $totalPriceProduct,
                                    'vat_price' => $theVatAdded,
                                    'time_and_appointmnet_name' => $sourch_list,
                                    'status' => 1,
                                    'active_status' => 1,
                                    'recurring' => 0,
                                    'interval' => 0,
                                    'week_note' => 0,
                                    'week_time' => 0,
                                    'appdateTime' => $appdate,
                                    'enddateTime' => $enddate,
                                    'sourch' => 'Backend',
                                    'is_order' => '0',
                                    'grand_vat' => $theVatAdded,
                                    'grand_total' => $priceforUser,
                                    'grand_total_with_vat' => $totalPriceProduct,
                                    'shippment_cost' => '0',
                                    'color' => $data['color'],
                                ]);
                            }
                        }
                    }
                } elseif ($data['interval'] == 4) {

                    $start_date = $data['date_value'];
                    $datewe = strtotime($start_date);
                    $datewe = strtotime("+" . $data['week_note'] . " year", $datewe);
                    $weekdate = date('Y-m-d', $datewe);
                    $k = 0;
                    for ($j = 0; $j < $data['week_time']; $j++) {

                        for ($i = 0; $i <= 6; $i++) {

                            if ($i == 6) {
                                $k = $k + $data['week_note'];
                                $monthDate = Carbon::parse($data['date_value'])->addYears($k);

                                $appdate = substr($monthDate, 0, 10) . ' ' . $data['start_times'];
                                $enddate = substr($monthDate, 0, 10) . ' ' . $endtime;
                                // $getVatNumber = '1.' . $data['vat_number'];
                                // //total
                                // $totalPriceProduct = $data['type_price'];
                                // // price
                                // $theVatAdded = (floatval($totalPriceProduct)/floatval($getVatNumber));
                                // //vat price
                                // $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));
                                $app = DB::table('appointments')->insertGetId([
                                    'date' => $monthDate,
                                    'user_id' => $data['client_id'],
                                    'start_time_id' => $data['start_time'],
                                    'specialist_id' => Auth::user()->id,
                                    'appointment_type_id' => $data['appointment_type'],
                                    'appointment_type' => $data['type_name'],
                                    'start_time' => $data['start_times'],
                                    'end_time' => $endtime,
                                    'price' => $priceforUser,
                                    'vat_number' => $data['vat_number'],
                                    'total' => $totalPriceProduct,
                                    'vat_price' => $theVatAdded,
                                    'time_and_appointmnet_name' => $sourch_list,
                                    'status' => 1,
                                    'active_status' => 1,
                                    'recurring' => 0,
                                    'interval' => 0,
                                    'week_note' => 0,
                                    'week_time' => 0,
                                    'appdateTime' => $appdate,
                                    'enddateTime' => $enddate,
                                    'sourch' => 'Backend',
                                    'is_order' => '0',
                                    'grand_vat' => $theVatAdded,
                                    'grand_total' => $priceforUser,
                                    'grand_total_with_vat' => $totalPriceProduct,
                                    'shippment_cost' => '0',
                                    'color' => $data['color'],
                                ]);
                            }
                        }
                    }

                }

            }

        }

        if ($app) {
            return true;
        }
        return false;
    }


    public static function updatedAppointment($id, $data = '')
    {

        $client = User::find($data['client_id']);

        $users = DB::table('user_address')->where('user_id', $data['client_id'])->first();
        $vat = Vat::where('country_id', $users->shipping_country_name)->first();
        $subTotal = $data['type_price'];

        $datea = Carbon::parse($data['start_times'])->addHour(1);
        $endtime = substr($datea, 10, 6);

        $sourch_list = $client->first_name . ': ' . $data['start_times'] . '-' . $endtime;

        $appdate = $data['date_value'] . ' ' . $data['start_times'];
        $enddate = $data['date_value'] . ' ' . $endtime;
        $getVatNumber = '1.' . $data['vat_number'];
        //total
        $totalPriceProduct = $data['type_price'];
        // price
        $theVatAdded = round($totalPriceProduct - ($totalPriceProduct / (($getVatNumber / 100) + 1)), 2);
        //vat price
        $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));
        $app = DB::table('appointments')->where('id', $id)->update([
            'date' => $data['date_value'],
            'user_id' => $data['client_id'],
            'start_time_id' => $data['start_time_id'],
            'specialist_id' => $data['specialist_id'],
            'appointment_type_id' => $data['appointment_type'],
            'appointment_type' => $data['type_name'],
            'start_time' => $data['start_times'],
            'end_time' => $endtime,
            'price' => $priceforUser,
            'vat_number' => $data['vat_number'],
            'total' => $totalPriceProduct,
            'vat_price' => $theVatAdded,
            'time_and_appointmnet_name' => $sourch_list,
            'status' => 1,
            'active_status' => 1,
            'recurring' => $data['recurring'],
            'interval' => $data['interval'],
            'week_note' => $data['week_note'],
            'week_time' => $data['week_time'],
            'appdateTime' => $appdate,
            'enddateTime' => $enddate,
            'sourch' => 'Backend',
            'is_order' => 0,
            'is_paid' => 0,
            'is_parsonal' => 0,
            'is_cancel' => 0,
            'is_wallet' => 0,
            'grand_vat' => $theVatAdded,
            'grand_total' => $priceforUser,
            'grand_total_with_vat' => $totalPriceProduct,
            'shippment_cost' => '0',
            'color' => $data['color'],

        ]);
        if ($app) {
            return true;
        }
        return false;

    }

    public static function conframOrder($data = '')
    {

        $order = Order::where('id', $data['order_id'])->update([
            'vat_number' => $data['vat_number_order'],
            'vat_amount' => $data['vat_price'],
            'sub_total' => $data['sub_total_grand'],
            'shippment_cost' => $data['shippment_cost'],
            'wallet_paid' => 0,
            'total' => $data['grand_total_ammount'],
            'is_wallet' => 0,
            'is_paid' => @$data['is_paid'],
            'payment_method' => 0,
            'status' => 1,
            'order_note' => $data['order_note'],
            'order_sourch' => "Backend",

        ]);

        DB::table('order_product_cart')->where('order_id', $data['order_id'])->delete();

        if (!empty($data['product_id_cart'])) {
            if (count($data['product_id_cart']) > 0) {

                for ($j = 0; $j < sizeof($data['product_id_cart']); $j++) {
                    DB::table('order_product_cart')->insert([
                        'order_id' => $data['order_id'],
                        'product_id' => $data['product_id_cart'][$j],
                        'product_name' => $data['product_name_cart'][$j],
                        'product_option_id' => 0,
                        'product_option' => "null",
                        'price' => $data['product_price'][$j],
                        'product_vat' => $data['vat_cart'][$j],
                        'vat_price' => $data['cart_vat_price'][$j],
                        'quantity' => $data['cart_qty'][$j],
                        'total' => $data['cart_total'][$j],
                        'status' => 1,
                    ]);
                }
            }

        }

        return true;
    }

    public static function conframOrderandAppointment($data = '')
    {
        $app = Appointment::find($data['appointment_id']);
        $app->grand_vat = $data['vat_price'];
        $app->grand_total = $data['sub_total_grand'];
        $app->grand_total_with_vat = $data['grand_total_ammount'];
        $app->shippment_cost = $data['shippment_cost'];
        $app->note = $data['order_note'];
        $app->save();
        if ($app->order_id > 0) {
            # code...
        } else {

            $check = Order::where('appoitment_id', $data['appointment_id'])->first();
            $orderId = 0;
            if ($check) {

                $order = Order::where('appoitment_id', $data['appointment_id'])->update([
                    'vat_number' => 0,
                    'vat_amount' => $data['vat_price'],
                    'sub_total' => $data['sub_total_grand'],
                    'shippment_cost' => $data['shippment_cost'],
                    'total' => $data['grand_total_ammount'],
                    'status' => 1,
                ]);
            } else {

                $order = Order::insert([
                    'date' => date('Y-m-d'),
                    'user_id' => $app->user_id,
                    'appoitment_id' => $app->id,
                    'vat_number' => 0,
                    'vat_amount' => $data['vat_price'],
                    'sub_total' => $data['sub_total_grand'],
                    'shippment_cost' => $data['shippment_cost'],
                    'wallet_paid' => 0,
                    'total' => $data['grand_total_ammount'],
                    'is_wallet' => 0,
                    'is_paid' => 0,
                    'payment_method' => 0,
                    'status' => 1,
                    'order_note' => "",
                    'order_sourch' => "Backend",

                ]);
                $app = Appointment::find($app->id);
                $app->is_order = 1;
                $app->save();
            }

            $checkord = Order::where('appoitment_id', $data['appointment_id'])->first();
            if ($checkord) {
                DB::table('order_product_cart')
                    ->where('order_id', $checkord->id)
                    ->delete();
            } else {

                DB::table('order_product_cart')
                    ->where('appointment_id', $data['appointment_id'])
                    ->delete();
            }

            if (!empty($data['product_id_cart'])) {
                if (count($data['product_id_cart']) > 0) {

                    for ($j = 0; $j < sizeof($data['product_id_cart']); $j++) {
                        DB::table('order_product_cart')->insert([
                            'order_id' => $checkord->id,
                            'appointment_id' => $data['appointment_id'],
                            'product_id' => $data['product_id_cart'][$j],
                            'product_name' => $data['product_name_cart'][$j],
                            'product_option_id' => 0,
                            'product_option' => "null",
                            'price' => $data['product_price'][$j],
                            'product_vat' => $data['vat_cart'][$j],
                            'vat_price' => $data['cart_vat_price'][$j],
                            'quantity' => $data['cart_qty'][$j],
                            'total' => $data['cart_total'][$j],
                            'status' => 1,
                        ]);
                    }
                }

            }

        }
        return true;
    }

    public static function Orderupdated($data = '')
    {
        $app = Appointment::find($data['appointment_id']);
        $users = DB::table('user_address')->where('user_id', $app->user_id)->first();

        $vat = Vat::where('country_id', $users->shipping_country_name)->first();
        $app->grand_vat = $data['vat_price'];
        $app->grand_total = $data['sub_total_grand'];
        $app->grand_total_with_vat = $data['grand_total_ammount'];
        $app->shippment_cost = $data['shippment_cost'];
        $app->save();

        $check = Order::find($data['order_id']);
        $orderId = $check->id;
        $order = Order::where('id', $check->id)->update([
            'vat_number' => 0,
            'vat_amount' => $data['vat_price'],
            'sub_total' => $data['sub_total_grand'],
            'shippment_cost' => $data['shippment_cost'],
            'total' => $data['grand_total_ammount'],
            'order_note' => $data['order_note'],
            'status' => 1,
        ]);
        if (!empty($data['product_id_cart'])) {
            if (count($data['product_id_cart']) > 0) {

                $checkord = DB::table('order_product_cart')->where('order_id', $check->id)->first();

                if ($checkord) {

                    DB::table('order_product_cart')
                        ->where('order_id', $check->id)
                        ->delete();
                } else {

                    DB::table('order_product_cart')
                        ->where('appointment_id', $data['appointment_id'])
                        ->delete();
                }


                for ($j = 0; $j < sizeof($data['product_id_cart']); $j++) {
                    DB::table('order_product_cart')->insert([
                        'order_id' => $check->id,
                        'appointment_id' => $data['appointment_id'],
                        'product_id' => $data['product_id_cart'][$j],
                        'product_name' => $data['product_name_cart'][$j],
                        'product_option_id' => 0,
                        'product_option' => "null",
                        'price' => $data['product_price'][$j],
                        'product_vat' => $data['vat_cart'][$j],
                        'vat_price' => $data['cart_vat_price'][$j],
                        'quantity' => $data['cart_qty'][$j],
                        'total' => $data['cart_total'][$j],
                        'status' => 1,
                    ]);
                }
            }

        }

        return true;
    }

    public static function OrderupdatednNew($data = '')
    {
        $app = Appointment::find($data['appointment_id']);
        $users = DB::table('user_address')->where('user_id', $app->user_id)->first();
        $vat = Vat::where('country_id', $users->shipping_country_name)->first();
        $app->grand_vat = $data['vat_price'];
        $app->grand_total = $data['sub_total_grand'];
        $app->grand_total_with_vat = $data['grand_total_ammount'];
        $app->shippment_cost = $data['shippment_cost'];
        $app->is_paid = $data['is_paid'];
        $app->save();
        $check = Order::where('appoitment_id', $data['appointment_id'])->first();
        $orderId = 0;
        if ($check) {
            $orderId = $check->id;
            $order = Order::where('appoitment_id', $data['appointment_id'])->update([
                'vat_number' => $vat->vat_number,
                'vat_amount' => $data['vat_price'],
                'sub_total' => $data['sub_total_grand'],
                'shippment_cost' => $data['shippment_cost'],
                'total' => $data['grand_total_ammount'],
                'order_note' => $data['order_note'],
                'is_paid' => $data['is_paid'],
                'status' => 1,
            ]);
        } else {
            $order = Order::insert([
                'date' => date('Y-m-d'),
                'user_id' => $app->user_id,
                'appoitment_id' => $data['appointment_id'],
                'vat_number' => $vat->vat_number,
                'vat_amount' => $data['vat_price'],
                'sub_total' => $data['sub_total_grand'],
                'shippment_cost' => $data['shippment_cost'],
                'wallet_paid' => 0,
                'total' => $data['grand_total_ammount'],
                'is_wallet' => 0,
                'is_paid' => $data['is_paid'],
                'payment_method' => 0,
                'status' => 1,
                'order_note' => $data['order_note'],
                'order_sourch' => "Backend",

            ]);
            $orderId = $order->id;
        }

        $checkord = Order::where('appoitment_id', $data['appointment_id'])->first();

        if ($checkord) {

            DB::table('order_product_cart')
                ->where('order_id', $checkord->id)
                ->delete();
        } else {

            DB::table('order_product_cart')
                ->where('appointment_id', $data['appointment_id'])
                ->delete();
        }

        if (!empty($data['product_id_cart'])) {
            if (count($data['product_id_cart']) > 0) {

                for ($j = 0; $j < sizeof($data['product_id_cart']); $j++) {
                    DB::table('order_product_cart')->insert([
                        'order_id' => $orderId,
                        'appointment_id' => $data['appointment_id'],
                        'product_id' => $data['product_id_cart'][$j],
                        'product_name' => $data['product_name_cart'][$j],
                        'product_option_id' => 0,
                        'product_option' => "null",
                        'price' => $data['product_price'][$j],
                        'product_vat' => $data['vat_cart'][$j],
                        'vat_price' => $data['cart_vat_price'][$j],
                        'quantity' => $data['cart_qty'][$j],
                        'total' => $data['cart_total'][$j],
                        'status' => 1,
                    ]);
                }
            }

        }

        return true;
    }

    public static function orderCartProduct($id = '')
    {
        $data = DB::table('order_product_cart')
            ->where('appointment_id', $id)
            ->get();
        return $data;
    }


    public static function makePersonalAppointment($data = '')
    {

        $sourch_list = $data['name_in'] . ': ' . $data['start_time'] . '-' . $data['end_time'];
        $appdate = $data['app_date'] . ' ' . $data['start_time'];
        $enddate = $data['app_date'] . ' ' . $data['end_time'];
        $app = DB::table('appointments')->insertGetId([
            'date' => $data['app_date'],
            'user_id' => 0,
            'start_time_id' => 0,
            'specialist_id' => 0,
            'appointment_type_id' => 0,
            'appointment_type' => "null",
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'price' => 0,
            'vat_number' => 0,
            'total' => 0,
            'vat_price' => 0,
            'time_and_appointmnet_name' => $sourch_list,
            'status' => 1,
            'active_status' => 1,
            'name' => $data['name_in'],
            'location' => $data['location'],
            'appdateTime' => $appdate,
            'enddateTime' => $enddate,
            'is_parsonal' => 1,
        ]);
        if ($app) {
            return $app;
        }
        return false;


    }

    public static function editPersonalAppointment($data = '')
    {

        $sourch_list = $data['name_in'] . ': ' . $data['start_time'] . '-' . $data['end_time'];
        $appdate = $data['app_date'] . ' ' . $data['start_time'];
        $enddate = $data['app_date'] . ' ' . $data['end_time'];
        $app = DB::table('appointments')->where('id', $data["edit_id"])->update([
            'date' => $data['app_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'time_and_appointmnet_name' => $sourch_list,
            'status' => 1,
            'name' => $data['name_in'],
            'location' => $data['location'],
            'appdateTime' => $appdate,
            'enddateTime' => $enddate,
            'is_parsonal' => 1,
        ]);

        return true;


    }


    public static function makeOrder($data = '')
    {
        $app = Appointment::find($data["appointment_id"]);
        $order = Order::create([
            'date' => date('Y-m-d'),
            'user_id' => $data['client_id'],
            'appoitment_id' => $data['appointment_id'],
            'vat_number' => 0,
            'vat_amount' => $app->grand_vat,
            'sub_total' => $app->grand_total,
            'shippment_cost' => $app->shippment_cost,
            'wallet_paid' => 0,
            'total' => $app->grand_total_with_vat,
            'is_wallet' => 0,
            'is_paid' => 0,
            'payment_method' => 0,
            'status' => 1,
            'order_note' => "",
            'order_sourch' => "Backend",

        ]);
        if ($order) {

            $app->is_order = 1;
            $app->order_id = $order->id;
            $app->save();
            return true;
        } else {
            return false;

        }

    }

}
