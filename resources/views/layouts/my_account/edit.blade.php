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
  <div class="mrg-div"></div>
  <div class="row">
    <div class="col-md-4">
      @include('layouts.my_account.nav')
    </div>
    <div class="col-md-8" style="border-left: 1px solid #000">
       {!! Form::open(['url'=>URL::to('edit-my-account'),'id'=>'myForm','files'=>true]) !!}
      <div class="row leftbody">
        <div class="col-md-12"><button class="btn btn-success  pull-right">Save Info</button></div>
        <div class="row col-md-12">
<div class="col-md-4">
  <label>Firstname:</label> <span style="color: #52d862"><input type="text" required="" class="form-control" name="first_name" value="{{Auth::user()->first_name}}"></span>
</div>
<div class="col-md-4">
  <label>Lastname:</label> <span style="color: #52d862"><input type="text" required="" class="form-control" name="last_name" value="{{Auth::user()->last_name}}"></span>
</div>
<div class="col-md-4">
  <label>Contact:</label> <span style="color: #52d862"><input type="text" required="" class="form-control" name="phone_number" value="{{Auth::user()->phone_number}}"></span>
</div>
<div class="col-md-4">
  <label>VAT:</label> <span style="color: #52d862"><input style="" class="form-control" type="text" name="vat_number" value="{{Auth::user()->vat_number}}" required="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"></span>
</div>
<div class="col-md-4">
  <label>Email:</label> <input style="" type="text"  class="form-control" value="{{Auth::user()->email}}" readonly="">
</div>

        </div>
        <ul class="col-md-6">
          <li style="font-weight: bold;color:#000">Invoice address</li>
          <li>
<textarea name="invoice_address" rows="4" cols="40">{{$address->invoice_address}}</textarea>

          </li>
          <li style="font-weight: bold;color:#000">Post Code</li>
          <li style="margin-top: 10px;"><input type="text" value="{{$address->post_code}}" name="post_code" style=""> </li><li style="font-weight: bold;color:#000">City</li><li style="margin-top: 10px;">
            <input type="text" name="city" value="{{$address->city}}"></li>
          <li style="margin-top: 10px;">

<select style="height: 30px;width: 220px;background-color: #f1f1f1" name="country"  id="country" >
    @foreach($country as $countryValues)
    <option value="{{$countryValues->id}}"  @if($address->country_name==$countryValues->id) selected="" @endif>{{$countryValues->name}}</option>
    @endforeach
</select>

          </li>
        </ul>
        <ul class="col-md-6">
          <li style="font-weight: bold;color:#000">Shipping address</li>
          <li>
<textarea name="shipping_address" rows="4" cols="40">{{$address->shipping_address}}</textarea>
          </li>
          <li style="font-weight: bold;color:#000">Post Code</li>
          <li style="margin-top: 10px;"><input type="text" value="{{$address->shipping_post_code}}" name="shipping_post_code"></li>  <li style="font-weight: bold;color:#000">City</li><li style="margin-top: 10px;"> <input type="text" name="shopping_city" value="{{$address->shopping_city}}"></li>
          <li style="margin-top: 10px;">
            
<select style="height: 30px;width: 220px;background-color: #f1f1f1" name="s_country"  id="s_country" >
  @foreach($country as $countryValue)
    <option value="{{$countryValue->id}}" @if($address->country_name==$countryValue->id) selected="" @endif>{{$countryValue->name}}</option>
    @endforeach
    
</select>          </li>
        </ul>

          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection