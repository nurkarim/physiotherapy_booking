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
</style>
<header id="bg-image">
  <div class="mrg-div"></div>
  @include('layouts.my_account.head_title')
  <div class="mrg-div"></div>
</header>
<!-- Page Content -->
<div class="container">
   @include('errors.messages')
  <div class="mrg-div"></div>
  <div class="row">
    <div class="col-md-4">
      @include('layouts.my_account.nav')
    </div>
    <div class="col-md-8" style="border-left: 1px solid #000">
      <div class="row leftbody">
        <ul class="col-md-12">
          <li>Firstname: <span style="color: #52d862">{{Auth::user()->first_name}}</span><span class="fa fa-edit pull-right"> <a href="{{url('my-account/edit')}}" title="">edit my info</a></span></li>
          <li>Lastname: <span style="color: #52d862"> {{Auth::user()->last_name}}</span></li>
          <li>Email: <span style="color: #52d862">{{Auth::user()->email}}</span></li>
          <li>VAT: <span style="color: #52d862">{{Auth::user()->vat_number}}</span></li>
        </ul>
        <ul class="col-md-6">
          <li style="font-weight: bold;color:#000">Invoice adress</li>
          <li>{{$address->invoice_address}}</li>
          <li>{{$address->post_code}} {{$address->city}}</li>
          <li>{{$address->iCName}}</li>
        </ul>
        <ul class="col-md-6">
          <li style="font-weight: bold;color:#000">Shipping adress</li>
          <li>{{$address->shipping_address}}</li>
          <li>{{$address->shipping_post_code}} {{$address->shopping_city}}</li>
          <li>{{$address->ScName}}</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@section('js')

@endsection
@endsection