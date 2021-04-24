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
       {!! Form::open(['url'=>URL::to('my-account/change-password'),'id'=>'myForm','files'=>true]) !!}
      <div class="row leftbody">
        <ul class="col-md-12">
          <li style="margin-top: 10px;"><label>New Password: </label><span style="color: #52d862"><input type="password" required="" name="password" value="" placeholder="******" class="form-control"></span></li>
          <li style="margin-top: 10px;"><span class=" "> <button type="submit" class="btn btn-sm btn-info pull-right" style="cursor: pointer;">Save Password</button></span></li>

     
        </ul>



          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection