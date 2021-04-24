@extends('layouts.app')
@section('content')
<style type="text/css">
	li{list-style: none;}
</style>
 <div class="container">
 <div class="col-md-12" style="height: 20px"></div>
<div class="row" style="height: 400px;text-align: center;">
<div class="col-md-12" style="height: 400px;text-align: center;">
<h1 style="margin-top: 40px;color: black;text-align: center;">

Your booking is done.

</h1>
<p>
	<?php
$sms=array_reverse(Session::get('successSMS'));

	?>
	@foreach($sms as $smsValues)
Thank you <b>{{$smsValues['first_name']}} {{$smsValues['last_name']}}</b> for new order .Your order id is <b>{{$smsValues['order_number']}}</b>. all details will be sent {{$smsValues['email']}}. Ga naar link:
@endforeach
</p>
</div>
</div>
</div>

@endsection