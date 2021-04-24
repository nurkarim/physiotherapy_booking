<style type="text/css" media="screen">
.top-head{
	height: 150px;
	background-color: #17CC75;
	width: 100%;

}
body{
	padding: 0px;margin: 0px;

}
.left-head{width: 60%;float: left;clear: right;}
.right-head{width: 50%;float: right;clear: left;}
li{list-style: none;font-weight: 400}
</style>


<div class="top-head">
	<div  class="left-head">
		<ul>
			@if($company->logo!="")
			<img src="{{url('public/image')}}/{{$company->logo}}" style="height: 100px;width: 120px;padding-top: 20px;">
			@else
			<img src="{{url('public/image/loader.png')}}" style="height: 100px;width: 120px;padding-top: 20px;">

			@endif
		</ul>
	</div>

	<div  class="right-head">
		<p style="font-size: 24px;font-weight: bold;color: white;padding-top: 10px;">{{$company->name}}</p>
		<address style="color: white">
			{{$company->address}}
		</address>
		<address style="color: white">
			{{$company->post_code}},{{$company->city}}
		</address>
		<address style="color: white">
			{{$company->country}}
		</address>
	</div>
</div>
<div style="">
	<h4 style="color:#17CC75;font-weight: bold;font-size: 25px ">INVOICE #{{$invoic->id}}</h4>
	
</div>
<div style="height: 80px;padding-top: -50px;">
	<ul style="height: 80px;padding-left: -3px;width: 60%;float: left;clear: right;">
		<li style="padding-top: 2px;">{{$users->first_name}} {{$users->last_name}}</li>
		<li style="padding-top: 2px;">{{$users->vat_number}}</li>
		<li style="padding-top: 2px;">{{$userAddress->invoice_address}}</li>
		<li style="padding-top: 2px;">{{$userAddress->post_code}} {{$userAddress->city}}</li>
		<li style="padding-top: 2px;">{{$userAddress->iCName}}</li>
		<li style="padding-top: 2px;">{{$users->email}}</li>
		<li style="padding-top: 2px;">{{$users->phone_number}}</li>
	</ul>
		<ul style="height: 80px;width: 40%;float: right;clear: left;">
		<li style="padding-top: 2px;">Invoice Date:  <span style="padding-left: 35px;">{{$invoic->date}}</span></li>
		<li style="padding-top: 2px;">Order No:  <span style="padding-left: 54px;">{{$invoic->order_id}}</span></li>
		<li style="padding-top: 2px;">Order Date: <span style="padding-left: 45px;">{{$order->date}}</span></li>
		<li style="padding-top: 2px;">Payment Method: @if($order->payment_method==1) Bank Transfer @elseif($order->payment_method==2)  Molie Payment @endif</li>
		<li style="padding-top: 2px;">Payment Status: <span style="padding-left: 10px;">@if($order->is_paid==0) UNPAID @else PAID @endif</span></li>

	</ul>
</div>
<div style="padding-top: 50px;">
	<table style="width: 100%;border-style: hidden;" border="0" cellpadding="0" cellspacing="0">
		<thead>
			<tr style="background-color:#17CC75;padding: 10px 0px;color: white;">
				<th style="width: 60%;border-style: hidden;height: 30px">Product</th>
				<th style="border-style: hidden;">Amount</th>
				<th style="border-style: hidden;">Price with vat</th>
			</tr>
		</thead>
		<tbody>
			@if(count($appointment)>0)
			@foreach($appointment as $appointmentValue)
			<tr>
				<td>
					{{$appointmentValue->appointment_type}}
					<p style="padding-top: -10px"><?php echo date("F d,", strtotime($appointmentValue->date)); ?> {{$appointmentValue->start_time}}-{{$appointmentValue->end_time}}</p>
				</td>
				<td>1</td>
				<td>€ {{$appointmentValue->total}}</td>
			</tr>
			@endforeach
			@endif

			@if(count($product)>0)
			@foreach($product as $productValue)
			<tr >
				<td style="border-top: 1px solid #ccc;border-bottom: 1px solid #ccc">
					{{$productValue->product_name}}

				</td>
				<td style="border-top: 1px solid #ccc;border-bottom: 1px solid #ccc">{{$productValue->quantity}}</td>
				<td style="border-top: 1px solid #ccc;border-bottom: 1px solid #ccc">€ {{$productValue->total}}</td>
			</tr>
			@endforeach
			@endif
		</tbody>
	</table>

	<div style="width: 60%;float: left;clear: right;margin-top: 20px;height: 250px;">

	</div>
	<div style="width: 40%;float: right;clear: left;height: 250px;">
		<hr>
		@if(count($product)>0)
		<li style="padding-top: 5px;">Shippment Cost : <span style="padding-left: 35px">€ {{$order->shippment_cost}}</span></li>
		@endif
		<li style="padding-top: 5px;">Vat : <span style="padding-left: 116px">€ {{$order->vat_amount}}</span></li>
		<li style="padding-top: 5px;">Subtotal : <span style="padding-left: 85px">€ {{$order->sub_total}}</span></li>
		<li style="padding-top: 5px;">Total with vat : <span style="padding-left: 50px">€ {{$order->total}}</span></li>
	</div>

<div style="width: 100%;height: 50px;color: #000;font-size: 14px;">
	<ul>{{$company->name}}|{{$company->address}} | {{$company->post_code}},{{$company->city}},{{$company->country}} | {{$company->email}} | {{$company->contact}}</ul>
	<ul style="text-align: center;">BTW: {{$company->vat_number}} |BIC: {{$company->bank_account_number}}</ul>
</div>
</div>
