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
      <h4>Current balance</h4>
     
      <div class="row leftbody">
        <ul class="col-md-12">
        
          <li style="margin-top: 10px;">My wallet: <span style="color: #52d862">€ @if(@Auth::user()->wallet->price>0)
                {{Auth::user()->wallet->price}}
<input type="hidden" name="request_price" id="request_price" value="{{Auth::user()->wallet->price}}">
                @else
0.00
                @endif  <i class="fa fa-credit-card" aria-hidden="true"></i></span></li>
          <li style="margin-top: 10px;"><button type="button" style="cursor: pointer;" class="btn btn-success btn-sm" onclick="requestRefund()">Request Refund.</button> <b>Request status:</b> <span style="color: #52d862" class="sms_text"> @if(count($checkRequ)>0) @else net yet requested @endif </span></li>
        </ul>
        <li style="list-style: none;margin-left: 10px;">Wallet History</li>
        <ul style="border: 1px solid #000;" class="col-md-12">
          <table>
            <?php $i=1;$total=0; ?>
            @foreach($data as $dataValue)
            <?php
$total=$total+$dataValue->total;
            ?>
            <tr>
              <td>Appointment {{$i++}}:</td>
              <td>{{$dataValue->appointment_type}} - <?php echo date("F d, Y", strtotime($dataValue->date)); ?></td>
              <td style="color: red;">-CANCELED</td>
              <td>+ {{$dataValue->total}}</td>
            </tr>

            @endforeach
          </table>

          <ul style="margin-top: 30px;">
       <table class="" width="100%">
         <tr>
           <td align="right">
             Total: <?php echo number_format($total,2); ?>
           </td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
         </tr>
       </table>
          </ul>
        </ul>


      </div>
    </div>
  </div>
</div>

<script>
  function requestRefund(){

var price=$("#request_price").val();
if (price<0) {
alert("Sorry!! have  insufficient wallet");

return false;
} 

  if (confirm('Are you sure you want to Request Refund?')) {
    $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    $.ajax({
    url:"{{url('request-refund')}}",
    type     : "GET",
    cache    : false,
    dataType : 'json',
    data     : {'price': price},
    
    success  : function(data){
    if(data.success==true){
       alert("wel done!Request Refund successfully.");
       $(".sms_text").html(" ");
       $(".sms_text").html("Yes requested");
    }else if (data.error==true) {
      alert("Sorry!! have  insufficient wallet");  
    }
    },
    error: function(data){
    
    
    }
    });
    return false;
}else{
    return false;

  }
}


</script>
@endsection