<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Availability;
use App\Http\Models\Appointment;
use App\Http\Models\CreditNote;
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
use Auth;
use Mollie;
use Socialite;

class molliePaymentController extends Controller
{
    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function paymentCheck($id='')
    {
        global $message;
        $order=Order::find($id);
        $payment = Mollie::api()->payments()->get($order->payment_id);
        $appointment=Appointment::find($order->appoitment_id);


        Order::where('id', $id)->update(array(
            'payment_method' 	  =>  $payment->method,
            'mollie_status' 	  =>  $payment->status,
        ));
        if ($payment->isPaid()) {
            $message =  "Payment received.";

            Order::where('id', $id)->update(array(
                'is_paid' 	  =>  1,
                'paid' 	  =>  $payment->amount,
                'payment_method' 	  =>  $payment->method,
                'mollie_status' 	  =>  $payment->status,
            ));
            Appointment::where('id', $order->appoitment_id)->update(array(
                'is_paid' 	  =>  1,
                'name' 	  =>  'test',
            ));
        } else {
            $message = 'payment for order id: '.$id. ' Was not succesfull.';
        }



        return view('layouts.cart.payment-status', compact('message', 'payment', 'order', 'appointment'));
    }


    public function apiCallMollie($id='')
    {
        $orderId =  $id;

        $order=Order::find($orderId);
        $appointment=Appointment::where('id', $order->appoitment_id)->first();
        $users=User::where('id', $order->user_id)->first();
        $users_address=User::userAddressSelect($order->user_id);
        $vat=Vat::where('country_id', $users_address->shipping_country_name)->first();


        $customer       = Mollie::api()->customers()->create([
            "name"          =>  $users->first_name,
            "email"         => $users->email,
        ]);

        $payment = mollie::api()->payments()->create([
            'amount'        =>  $order->total,
            'customerId'    =>  $customer->id,
            'recurringType' => 'first',
            'description'   => 'My Order Payment',
            'redirectUrl'   => url('payment/paymentcheck/'.$orderId),
        ]);

        $test = Mollie::api()->payments()->get('tr_bgrzmNGTEW');

        $customer_payment_reference = $payment->customerId;
        $payment_id = $payment->id;
        // $orderNo=self::makeId('',4);

        Order::where('id', $orderId)->update(array(
            'payment_id' 	  =>  $payment_id,
            'customer_payment_reference' =>  $customer_payment_reference

        ));



        return response()->json(["success"=>true, 'mollie' =>$payment, $order, 'user' => $users, 'appointment' => $appointment, $test]);
    }


    public function webHookMollie(request $request)
    {
    }


    public function cancelOrder($id, Request $request)
    {
        $app=Appointment::find($id);
        $orderId = $app->order_id;
        $order=Order::find($orderId);
        $payment = Mollie::api()->payments()->get($order->payment_id);

        if ($payment->status == 'paid') {
            $amount = $payment->amount  + 0.25;

            $refund = Mollie::api()->payments()->refund($payment, $amount);

            Appointment::where('id', $id)->update(array(
            'active_status' 	  =>  0,
        ));

            Order::where('id', $orderId)->update(array(
            'mollie_status' 	  =>  $payment->status,
        ));



            $creditnote = new CreditNote;

            $creditnote->order_id = $orderId;

            $creditnote->save();

            $payment = Mollie::api()->payments()->get($order->payment_id);
              if($creditnote){
                $request->session()->flash('success', "Appointment has been succe canceled and refunded");

              }
        }


        return back();
    }
}
