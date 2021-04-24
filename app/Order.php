<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Http\Models\Invoice;
class Order extends Model
{
     protected $guarded =['id'];


     public static function oderList()
{
   $data=DB::table('orders')
        ->leftjoin('appointments','orders.appoitment_id','=','appointments.id')
        ->join('users','orders.user_id','=','users.id')
         ->leftjoin('invoices','orders.id','=','invoices.order_id')
        ->select('orders.*','appointments.appointment_type','appointments.start_time','appointments.end_time','users.first_name','users.email','appointments.date as bookingDate','invoices.id as invoiceId')
        ->orderBy('orders.id','DESC')
        ->get();
        return $data;
}     

public static function creditNotList()
{
   $data=DB::table('credit_note')
        ->join('orders','credit_note.order_id','=','orders.id')
        ->leftjoin('appointments','orders.appoitment_id','=','appointments.id')
        ->join('users','orders.user_id','=','users.id')
        ->join('invoices','orders.id','=','invoices.order_id')
        ->select('orders.*','appointments.appointment_type','appointments.start_time','appointments.end_time','users.first_name','users.email','appointments.date as bookingDate','invoices.id as invoiceId','credit_note.id as cId')
        ->orderBy('credit_note.id','DESC')
        ->get();
        return $data;
}



public static function invoiceList()
{
   $data=DB::table('invoices')
        ->join('orders','invoices.order_id','=','orders.id')
        ->leftjoin('appointments','invoices.appointment_id','=','appointments.id')
        ->join('users','orders.user_id','=','users.id')
        ->select('orders.*','appointments.appointment_type','appointments.start_time','appointments.end_time','users.first_name','users.email','appointments.date as bookingDate','invoices.id as invoiceId')
        ->orderBy('orders.id','DESC')
        ->get();
        return $data;
}

public static function orderCartProduct2($id='')
{
   $data=DB::table('order_product_cart')
   ->where('order_id',$id)
   ->get();
   return $data;
}
 
 public static function OrderupdateMoreApp($data='')
 {
   $order=Order::find($data['order_id']);
   if ($order) {
     
     $order->order_note=$data['order_note'];
     $order->shippment_cost=$data['shippment_cost'];
     $order->is_paid=$data['is_paid'];
     $order->save();
 return true;
   }
    return false;
   
 } 

 public static function updateInvoice($data='')
 {
   $invoice=Invoice::find($data['invoice_id']);
   if ($invoice) {
     
     $invoice->note=$data['order_note'];
     $invoice->save();
 return true;
   }
    return false;
   
 }

}
