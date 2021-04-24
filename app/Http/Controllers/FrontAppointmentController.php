<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Appointment;
use App\Order;
use Carbon\Carbon;
use Auth;
class FrontAppointmentController extends Controller
{
    public function updateAppointment(Request $request)
    {
    	
    	$datea=Carbon::parse($request->strat_time)->addHour(1);
        $endtime=substr($datea,10, 6);
        $sourch_list=Auth::user()->first_name.': '.$request->strat_time.'-'.$endtime;
        $appdate=$request->appointment_date.' '.$request->strat_time;
        $enddate=$request->appointment_date.' '.$endtime;

        $getVatNumber = '1.' . $request->vat_number;
    //total
       $totalPriceProduct = $request->type_price;
    // price
       $theVatAdded = (floatval($totalPriceProduct)/floatval($getVatNumber));
    //vat price
        $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));
    	$app=Appointment::find($request->appointment_id);
    	$app->specialist_id=$request->specialist_id;
    	$app->start_time_id=$request->start_time_id_old;
    	$app->appointment_type_id=$request->appointment_type;
    	$app->date=$request->appointment_date;
    	$app->start_time=$request->strat_time;
    	$app->end_time=$endtime;
    	$app->appointment_type=$request->type_name;
    	$app->time_and_appointmnet_name=$sourch_list;
    	$app->price=$theVatAdded;
    	$app->total=$totalPriceProduct;
    	$app->vat_price=$priceforUser;
    	$app->vat_number=$request->vat_number;
    	$app->appdateTime=$appdate;
    	$app->enddateTime=$enddate;
    	$app->color=$request->color;
    	if ($app->is_order==1) {
    		
    		$gtotal=$app->grand_total_with_vat;
    		if ($gtotal<=$totalPriceProduct) {
    		  $gtotal1=$totalPriceProduct-$gtotal;
    		}else{
    		  $gtotal1=$gtotal-$totalPriceProduct;	
    		}
    		$gtotalGrand=($gtotal1+$totalPriceProduct);
    		
    		$grandVat=$app->grand_vat;
    		if ($grandVat<=$priceforUser) {
    		  $grandVat1=$priceforUser-$grandVat;
    		}else{
    		  $grandVat1=$grandVat-$priceforUser;	
    		}	

    		$grandTotals=$app->grand_total;
    		if ($grandTotals<=$theVatAdded) {
    		  $grandTotals1=$theVatAdded-$grandTotals;
    		}else{
    		  $grandTotals1=$grandTotals-$theVatAdded;	
    		}

    		$gtotalGrand=($gtotal1+$totalPriceProduct);
    		$GrandTVat=($grandVat1+$priceforUser);
    		$Grandsubtotal=($grandTotals1+$theVatAdded);

    	   $app->grand_vat=$GrandTVat;
    	   $app->grand_total=$Grandsubtotal;
    	   $app->grand_total_with_vat=$gtotalGrand;
    	}
    	$app->save();
    	$order=Order::where('appoitment_id',$request->appointment_id)->first();
    	if ($order) {
    		$gtotal=$app->grand_total_with_vat;
    		if ($gtotal<=$totalPriceProduct) {
    		  $gtotal1=$totalPriceProduct-$gtotal;
    		}else{
    		  $gtotal1=$gtotal-$totalPriceProduct;	
    		}
    		$gtotalGrand=($gtotal1+$totalPriceProduct);
    		
    		$grandVat=$app->grand_vat;
    		if ($grandVat<=$priceforUser) {
    		  $grandVat1=$priceforUser-$grandVat;
    		}else{
    		  $grandVat1=$grandVat-$priceforUser;	
    		}	

    		$grandTotals=$app->grand_total;
    		if ($grandTotals<=$theVatAdded) {
    		  $grandTotals1=$theVatAdded-$grandTotals;
    		}else{
    		  $grandTotals1=$grandTotals-$theVatAdded;	
    		}

    		$obj=Order::find($order->id);

    		$gtotalGrand=($gtotal1+$totalPriceProduct);
    		$GrandTVat=($grandVat1+$priceforUser);
    		$Grandsubtotal=($grandTotals1+$theVatAdded);

    	    $obj->vat_amount=$GrandTVat;
    	    $obj->sub_total=$Grandsubtotal;
    	    $obj->total=$gtotalGrand;
            $obj->save();
    	}
     return redirect("my-account/appointments/".$request->appointment_id."/details");

    }
}
