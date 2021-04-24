<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Availability;
use App\Http\Models\Appointment;
use App\Http\Models\AppointmentType;
use App\Http\Models\Product;
use App\Http\Models\Vat;
use App\Http\Models\Invoice;
use App\Http\Models\Email;
use App\User;
use App\Order;
use DB;

class OrderController extends Controller
{
    public function index()
    {

        $data=Order::oderList();
      
    	return view('backend.order.index',compact('data','appointments'));
    }

    
    public function updateInvoice(Request $request)
    {

       $save= Order::updateInvoice($request->all());
        if ($save) {
        $request->session()->flash('success', "Change Successfully");
    }else{
        $request->session()->flash('error', "Sorry!! Change UnSuccessfully");

    }
    return back();
    } 
       
    public function OrderupdateMoreApp(Request $request)
    {

       $save= Order::OrderupdateMoreApp($request->all());
        if ($save) {
        $request->session()->flash('success', "Change Successfully");
    }else{
        $request->session()->flash('error', "Sorry!! Change UnSuccessfully");

    }
    return back();
    }


    public function details($id)
    {
        $order=Order::find($id);
        $emailSendreminder=Email::where('type',2)->where('type_id',$id)->latest()->first();
        $emailInvoice=Email::where('type',3)->where('type_id',$id)->latest()->first();
        
        $appointment=Appointment::where('id',$order->appoitment_id)->first();
        $users=User::where('id',$order->user_id)->first();
        $users_address=User::userAddressSelect($order->user_id);
        $products=Product::all();
        $vat=Vat::where('country_id',$users_address->shipping_country_name)->first();
        if ($appointment) {
            # code...
        $products_cart=Appointment::orderCartProduct($order->appoitment_id);
      
        return view('backend.order.details',compact('order','appointment','users','users_address','products','products_cart','emailSendreminder','emailInvoice'));
        }
         if (@count($order->json_app_id)>0) {
         $products_cart=Order::orderCartProduct2($id);
         $appointments=Appointment::where('order_id',$order->id)->get();

         return view('backend.order.with_more_app_details',compact('order','users','users_address','products_cart','vat','appointments','emailSendreminder','emailInvoice'));  

        }
        $products_cart=Order::orderCartProduct2($id);
         return view('backend.order.without_appointment_orderDetails',compact('order','users','users_address','products_cart','vat','emailSendreminder','emailInvoice'));
  
    }  

    public function invoicesDetails($ind)
    {
        $invoice=Invoice::find($ind);
        $id=$invoice->id;
        $order=Order::where('id',$invoice->order_id)->first();
        $appointment=Appointment::where('id',$order->appoitment_id)->first();
        $users=User::where('id',$order->user_id)->first();
        $users_address=User::userAddressSelect($order->user_id);
        $products=Product::all();
        $vat=Vat::where('country_id',$users_address->shipping_country_name)->first();
        $lastEmail=Email::where('type',3)->where('type_id',$ind)->orderBy('id','DESC')->get();
      if ($appointment) {

        $products_cart=Appointment::orderCartProduct($order->appoitment_id);
        return view('backend.order.invoice',compact('order','appointment','users','users_address','products','products_cart','invoice','lastEmail'));
     }
     
     if (@count($order->json_app_id)>0) {

        $products_cart=Order::orderCartProduct2($order->id);
        $appointments=Appointment::where('order_id',$order->id)->get();
        return view('backend.invoice.more_app_details',compact('order','appointments','users','users_address','products','products_cart','invoice','lastEmail'));
     
       }
     
      $products_cart=Order::orderCartProduct2($order->id);
      return view('backend.invoice.more_product',compact('order','users','users_address','products','products_cart','invoice','lastEmail'));

  
    }  



    public function invoiceList()
    {
        $data=Order::invoiceList();
    	return view('backend.order.invoce_list',compact('data'));
    } 
    public function creditList()
    {
        $data=Order::creditNotList();

    	return view('backend.order.credit_note_list',compact('data'));
    }
    public function creditNoteDetails($credit)
    {

        $invoice=DB::table('credit_note')->where('id',$credit)->first();
        $id=$invoice->id;
        $order=Order::where('id',$invoice->order_id)->first();
        $appointment=Appointment::where('id',$order->appoitment_id)->first();
        $users=User::where('id',$order->user_id)->first();
        $users_address=User::userAddressSelect($order->user_id);
        $products=Product::all();
        $products_cart=Appointment::orderCartProduct($order->appoitment_id);
        $vat=Vat::where('country_id',$users_address->shipping_country_name)->first();
        return view('backend.order.credit_note_details',compact('order','appointment','users','users_address','products','products_cart','invoice'));
    	
    }

    public function createCreditNote(Request $request)
    {
        $check=DB::table('credit_note')->where('invoice_id',$request->invoiceId)->get();
        if (count( $check)>0) {
        return response()->json(["error"=>true]);
        }else{
        $save=DB::table('credit_note')->insert([
        "date"=>date('Y-m-d'),
        "user_id"=>$request->client_id,
        "order_id"=>$request->order_id,
        "invoice_id"=>$request->invoiceId,
       ]);
       if ($save) {
        return response()->json(["success"=>true]);
       }
        return response()->json(["success"=>false]); 
        }
     

    }


    public function conframinvoice(Request $request)
    {
       
       $app=Appointment::find($request->app_id);
       $app->is_paid=$request->is_paid;
       $app->save();

       $ord=Order::find($request->order_id);
       $ord->is_paid=$request->is_paid;
       $ord->save();

       $ord=Invoice::find($request->invoice_id);
       $ord->note=$request->order_note;
       $ord->save();
       if ($app &&  $ord) {
          $request->session()->flash('success', "invoices updated success");
       }

       return back();
    }
}
