@extends('backend.index')
@section('content')
<style type="text/css">
	li{list-style: none;}

table tr th{font-weight: 400;font-size: 13px;letter-spacing: 1px;}
table tr td{font-weight: 400;font-size: 12px;letter-spacing: 1px;color: black}

</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
	<div class="col-md-12">
	<h3>{{$users->first_name}}</h3>
	<p>Client # {{$users->id}}</p>
	</div>
	<div class="col-md-12">
	<p><span style="font-weight: bold;font-size: 16px;">Email:</span>{{$users->email}}</p>
	<p><span style="font-weight: bold;font-size: 16px;">VAT-Number:</span> {{$users->vat_number}}</p>
	</div>
	<div class="col-md-12 row">
<div class="col-md-6 row">
		<ul class="col-md-6">
	<b style="font-size: 20px;">Invoice adress</b>
	<address>
		<li>{{$users_address->invoice_address}}</li>
		<li>{{$users_address->post_code}} {{$users_address->city}}</li>
		<li>{{$users_address->iCName}}</li>
	</address>
	</ul>
	<ul class="col-md-6">
	<b style="font-size: 20px;">Shipping adress</b>
		<address>
		<li>{{$users_address->shipping_address}}</li>
		<li>{{$users_address->shipping_post_code}} {{$users_address->shopping_city}}</li>
		<li>{{$users_address->ScName}}</li>
	</address>
	</ul>
</div>

	</div>
	<div class="col-md-12" style="border-top: 1px solid #000">
	<h3 style="font-weight: bold;font-size: 18px;">Bookings from: <span style="font-weight: 400;font-size: 17px;">Wouters Frans</span></h3>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Booked by</th>
					<th>Starting Date</th>
					<th>End Date</th>
					<th>Booked Appointment</th>
					<th>#<i class="fa fa-user"></i></th>
					<th>Order</th>
					<th>Order Status</th>
					<th>Payment Reminder status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$i=1;
			?>
			@foreach($appointment as $appointmentValue)
				<tr>
					<td><input id="checkbox8" type="checkbox" checked="">
                        <label for="checkbox8">
                         #{{$appointmentValue->id}}
                        </label></td>
					<td style="color: #52d862">{{$users->first_name}} {{$users->last_name}}</td>
					<td><?php echo date("d M ", strtotime($appointmentValue->date)); ?>, {{$appointmentValue->start_time}}</td>
					<td><?php echo date("d M ", strtotime($appointmentValue->date)); ?>, {{$appointmentValue->end_time}}</td>
					<td>{{$appointmentValue->appointment_type}}</td>
					<td>{{$appointmentValue->user_id}}</td>
					<td>#{{$appointmentValue->order_id}}</td>
					<td>@if($appointmentValue->is_paid==0) Unpaid @else Paid @endif </td>
					<td>@if($appointmentValue->status==1) unsent @else Sent @endif </td>
					<td>
						<!-- <a href="{{url('orders')}}/{{$appointmentValue->order_id}}/details" class="btn btn-xs"><i class="fa  fa-shopping-bag"></i></a> -->
						<a href="{{url('appointments')}}/{{$appointmentValue->id}}/details" class="btn btn-xs"><i class="fa  fa-search"></i></a>
						<a href="{{url('invoices/pdf')}}/{{$appointmentValue->id}}/download" class="btn btn-xs"><i class="fa   fa-file-pdf-o" style="color: red"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
