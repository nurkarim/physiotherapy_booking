<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Http\Models\Company;
use App\Http\Models\Appointment;
use App\Order;
use App\User;
use Mail;
use DB;
class PDFController extends Controller
{
    public function index($id)
    {

    	$invoic=DB::table('invoices')->where('id',$id)->first();
		$company=Company::where('id_number',123)->first();
		$order=Order::find($invoic->order_id);
		$users=User::find($invoic->client_id);
		$userAddress=User::userAddressSelect($invoic->client_id);
		$appointment=Appointment::where('id',$invoic->appointment_id)->get();
		$product=Appointment::orderCartProduct($invoic->appointment_id);
   if (@count($appointment)>0) {
	
		$product=Appointment::orderCartProduct($order->appoitment_id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));
     
	return $pdf->stream();
		}

		if(@count($order->json_app_id)>0){

        $appointment=Appointment::where('order_id',$order->id)->get();
		$product=Order::orderCartProduct2($order->id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));
    	return $pdf->stream();
	
		}

		$appointment=Appointment::where('order_id',$order->id)->get();
		$product=Order::orderCartProduct2($order->id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));	
		

		return $pdf->stream();
		
		// return $pdf->download('invoice.pdf');
  //   	return view("backend.pdf.invoice");
    }

    public function download($id)
    {

		
    	$invoic=DB::table('invoices')->where('id',$id)->first();
    	if ($invoic) {
		$company=Company::where('id_number',123)->first();
		$order=Order::find($invoic->order_id);
		$users=User::find($invoic->client_id);
		$userAddress=User::userAddressSelect($invoic->client_id);
		 $appointment=Appointment::where('id',$order->appoitment_id)->get();

		if (@count($appointment)>0) {
	
		$product=Appointment::orderCartProduct($order->appoitment_id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));
     
		return $pdf->download('invoice.pdf');
		}

		if(@count($order->json_app_id)>0){

        $appointment=Appointment::where('order_id',$order->id)->get();
		$product=Order::orderCartProduct2($order->id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));
    	return $pdf->stream();
		return $pdf->download('invoice.pdf');
		}

		$appointment=Appointment::where('order_id',$order->id)->get();
		$product=Order::orderCartProduct2($order->id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));	
		

		 // return $pdf->stream();
		return $pdf->download('invoice.pdf');
	}else{
		return $html="<h1>Sorry!invoice Not Found</h1>";
	}
  //   	return view("backend.pdf.invoice");
    }   
     public function Creditdownload($id)
    {

		
    	$invoic=DB::table('invoices')->where('appointment_id',$id)->first();
    	if ($invoic) {
    		# code...
    	
		$company=Company::where('id_number',123)->first();
		$order=Order::find($invoic->order_id);
		$users=User::find($invoic->client_id);
		$userAddress=User::userAddressSelect($invoic->client_id);
		$appointment=Appointment::where('id',$order->appoitment_id)->get();
		$product=Appointment::orderCartProduct($order->appoitment_id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));
		// return $pdf->stream();
		return $pdf->download('credit.pdf');
	}else{
		return $html="<h1>Sorry!invoice Not Found</h1>";
	}
  //   	return view("backend.pdf.invoice");
    }


    public function invoicesDownload($id)
    {

		
    $invoic=DB::table('invoices')->where('appointment_id',$id)->first();
    	
    	if ($invoic) {
    		# code...
    	
		$company=Company::where('id_number',123)->first();
		$order=Order::find($invoic->order_id);
		$users=User::find($invoic->client_id);
		$userAddress=User::userAddressSelect($invoic->client_id);
		$appointment=Appointment::where('id',$order->appoitment_id)->get();
		$product=Appointment::orderCartProduct($order->appoitment_id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));
		// return $pdf->stream();
		return $pdf->download('invoice.pdf');
	}else{
		return $html="<h1>Sorry!invoice Not Found</h1>";
	}
  //   	return view("backend.pdf.invoice");
    }







    public function sendPDF($id)
    {

		
    	$invoic=DB::table('invoices')->where('appointment_id',$id)->first();
    	
    	if ($invoic) {
    		# code...
    	
		$company=Company::where('id_number',123)->first();
		$order=Order::find($invoic->order_id);
		$users=User::find($invoic->client_id);
		$userAddress=User::userAddressSelect($invoic->client_id);
		$appointment=Appointment::where('id',$order->appoitment_id)->get();
		$product=Appointment::orderCartProduct($order->appoitment_id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));
		$pdf->download('invoice.pdf');
$email=$users->email;
$sends=Mail::send('email.email', compact('invoic','order','users'), function($message) use($pdf,$email)
{
    $message->from('info@jemkine.be', 'Jemkine');

    $message->to($email)->subject("Send Invoice");

    $message->attachData($pdf->output(), "invoice.pdf");
});

return response()->json(['success'=>true]);
	}else{
		return response()->json(['success'=>false]);
	}
  //   	return view("backend.pdf.invoice");
    }


public function sendPDFInvoice($id)
    {

		
    	$invoic=DB::table('invoices')->where('id',$id)->first();
    	
    	if ($invoic) {
    		# code...
    	
		$company=Company::where('id_number',123)->first();
		$order=Order::find($invoic->order_id);
		$users=User::find($invoic->client_id);
		$userAddress=User::userAddressSelect($invoic->client_id);
		$appointment=Appointment::where('id',$order->appoitment_id)->get();
		$product=Appointment::orderCartProduct($order->appoitment_id);
    	$pdf = PDF::loadView('backend.pdf.invoice', compact('company','invoic','users','userAddress','order','appointment','product'));
		$pdf->download('invoice.pdf');
$email=$users->email;
$sends=Mail::send('email.email', compact('invoic','order','users'), function($message) use($pdf,$email)
{
    $message->from('info@jemkine.be', 'Jemkine');

    $message->to($email)->subject("Send Invoice");

    $message->attachData($pdf->output(), "invoice.pdf");
});

return response()->json(['success'=>true]);
	}else{
		return response()->json(['success'=>false]);
	}
  //   	return view("backend.pdf.invoice");
    }

}
