@extends('layouts.app')
@section('content')
<style type="text/css">
	li{list-style: none;}
</style>
 <div class="container">>

<div class="container_paymentStatus">

    <h1>Payment status</h1>
    <h3>For order: <span>#{{$order->id}}</span></h3>


    @php
        switch ($payment->status){
            case 'paid':
            echo 'The amount of: '. $payment->amount . ' has been succesfully paid';
            break;

            case 'cancelled':
                echo 'Payment for order  "'.$order->id.'" is cancelled.';
            break;

            case 'pending':
                echo 'Payment for order  "'.$order->id.'" is pending.';
            break;

            case 'expired':
                echo 'Payment for order  "'.$order->id.'" is expired.';
            break;
        };
    @endphp


    <hr>


    Link to <a href="{{url('my-account')}}">My account</a>
</div>




</div>

@endsection