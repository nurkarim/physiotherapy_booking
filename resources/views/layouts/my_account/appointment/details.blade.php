@extends('layouts.app')
@section('content')
<style type="text/css" media="screen">
    .cart ul li{list-style: none;padding: 10px;}
    .cart-ul {border: 1px solid #000}
    .cart{
    float: none;
    margin: 0 auto;
}
.sub-menu li {list-style: none;}

.leftbody ul li{list-style: none}
a{text-decoration: none;}
.table th{font-weight: 400;font-size: 15px}
.table tr td{font-weight: 400;font-size: 14px}
.tableAddress tr td{  font-weight: 400;font-size: 14px}
</style>

    <header id="bg-image">
<div class="mrg-div"></div>
@include('layouts.my_account.head_title')
      <div class="mrg-div"></div>
    </header>

    <!-- Page Content -->
    <div class="container">
<div class="mrg-div"></div>
<div class="row">
  <div class="col-md-3">
  @include('layouts.my_account.nav')
  </div> 
    <div class="col-md-9" style="border-left: 1px solid #000">
     <style type="text/css">
	
	li{list-style: none;}
</style>
<div class="row col-md-12"">


<div class="col-md-12">
	<ul class="col-md-12 "><h4 style="letter-spacing: 1px;font-weight: 400;font-size: 24px;">Appointment <a href="" style="color: #52d862;">#{{$appointment->id}}</a> Details</h4></ul>
</div>

<div class="col-md-12">
	<table class="tableAddress " style="border-style: hidden;" >
		<tr>
			<td colspan="3">
						<b>Client:</b>
		<p style="font-weight:400;font-size:22px;color:#52d862">{{$users->first_name}}</p>
		<address style="margin-top: -20px;">{{$users->email}}</address>
			</td>
		</tr>
		<tr style="border-style: hidden;">

			<td>
		
			<span style="font-weight: bold;">Invoice address</span>
			<p style="">{{$users_address->invoice_address}}</p>
			<p style="margin-top: -10px">{{$users_address->post_code}} {{$users_address->city}}</p>
			<p style="margin-top: -10px">{{$users_address->iCName}}</p>
		
			</td>
			<td style="border-right:  1px solid #000">
				
			
			<span style="font-weight: bold;">Shipping address</span>
			<p style="">{{$users_address->shipping_address}}</p>
			<p style="margin-top: -10px">{{$users_address->shipping_post_code}} {{$users_address->shopping_city}}</p>
			<p style="margin-top: -10px">{{$users_address->ScName}}</p>
		</td>
			<td style="width: 30%" valign="top">
				
				<b style="font-size: 20px;">Invoice:</b><br>
					<a class="" style="padding-left: 10px;" target="_blank" href="{{url('invoices')}}/{{$appointment->id}}/download"><i class="fa fa-file-pdf-o" style="color: red"></i> invoice.pdf</a>
			</td>
		</tr>
	</table>
<table class="" cellspacing="0" cellpadding="0" border="0" style="border-style: hidden;">
	<tr>
		<td colspan="2">Specialist: {{$specialist->title}}. {{$specialist->first_name}} {{$specialist->last_name}}</td>
	</tr>
		<tr style="border-style: hidden;">
		<td colspan="2">Order status:  @if($appointment->is_paid==0) Unpaid @else Paid @endif   <a href="{{url('order/payment')}}/{{$appointment->id}}" title="" style="text-decoration: none;"> </td>
	</tr>
</table>




<table class="table" id="cart_table"  style="background-color: #f7f5f5;border: 1px solid #ccc;width: 100%">

 			<tr id="app_tr">
 				<td style="border-right: 1px solid #000"> 		<p style="margin-top: 10px;color: #54ea54;font-weight: 400;font-size: 20px;letter-spacing: 1px">{{$appointment->appointment_type}}</p>
 		<li class="col-md-6 row" >
 			<p style="margin-top: -10px;color: black;font-weight: 400;font-size: 13px;">start date: <?php echo date("d M ", strtotime($appointment->date)); ?>,{{$appointment->start_time}}</p>
 		<p style="margin-top: -10px;color: black;font-weight: 400;font-size: 13px;">end date : <?php echo date("d M ", strtotime($appointment->date)); ?>,{{$appointment->end_time}}</p>
 		</li></td>
 		<td><samp>{{$appointment->price + $appointment->vat_number*$appointment->price/100}} € ({{$appointment->price}}+{{$appointment->vat_number*$appointment->price/100}} vat)</samp></td>
 		<td>
 			
 		
 		</td>	
 			</tr>

<tbody id="body_cart">
	<?php
$cartGtotal=0;
	?>
	@if(count($products_cart)>0)
	@foreach($products_cart as $products_cartValue)
	<?php
$cartGtotal=$cartGtotal+$products_cartValue->total;
$tot=($products_cartValue->price+$products_cartValue->vat_price);
	?>
	<tr id="tr_{{$products_cartValue->id}}"><td style="border-right: 1px solid #000"><samp><p style="color: #54ea54;font-weight: 400;font-size: 18px;letter-spacing: 1px">{{$products_cartValue->product_name}}</p></samp> <input type="hidden" value="{{$products_cartValue->id}}" name="product_id_cart[]"> <input type="hidden" value="{{$products_cartValue->product_name}}" name="product_name_cart[]"><input type="hidden" value="1" name="cart_qty[]"><input type="hidden" value="{{$products_cartValue->product_vat}}" name="vat_cart[]"><input type="hidden" value="{{$products_cartValue->vat_price}}" name="cart_vat_price[]"><input type="hidden" value="{{$tot}}" name="cart_total[]"><input type="hidden" value="{{$products_cartValue->price}}" name="product_price[]"></td><td><samp>{{$products_cartValue->total}} € ( {{$products_cartValue->price}}+{{$products_cartValue->vat_price}} vat)</samp><input value="{{$tot}}" class="amt" type="hidden"></td><td></td></tr>
	@endforeach
	@endif
	
</tbody>

 	</table>
<table style="width: 100%" class="table" cellpadding="0" cellspacing="0">
	<tr>
		<td style="width: 60%">
			<h4>Notes</h4>
			<textarea class="form-control" name="order_note" rows="4" style="background-color:#f7f5f5">{{$appointment->note}}</textarea>
		</td>

		<td style="width: 40%">

			<li>Shipping cost : {{$appointment->shippment_cost}} <span>€</span></li>
			<li>Btw : {{$appointment->grand_vat}} <span>€</span></li>
			<li>Total : {{$appointment->grand_total}} <span>€</span></li>
			<li>Total with vat : {{$appointment->grand_total_with_vat}} <span>€</span></li>
			@if($appointment->is_wallet==1)
			<li>Wallet : {{$appointment->wallet_paid}} <span>€</span></li>
			@endif

		</td>
	</tr>
</table>

 	
<input type="hidden" name="order_id" id="order_id" value="{{$appointment->id}}">
	<button class="btn btn-primary btn-xs" type="submit">save appointment</button>
<div class="mrg-div"></div>

</div>

</div>

  </div>  
</div>
  </div>



@endsection