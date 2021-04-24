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
      <div class="row leftbody">
        <ul class="col-md-12">
          <li><form role="search" class="navbar-left " style="margin-top: 6px;">
            <input type="text" placeholder="Search..." class="form-control" style="" id="search-input">
            
          </form></li>
        </ul>
        <?php $i=1; ?>
        @if(count($data)>0)
        @foreach($data as $dataValue)
        <ul class="row col-md-8" style="margin-left: 10px;border-bottom: 1px solid #000">
          
          <li><b>Appointment {{$i++}}:</b> <span>{{$dataValue->appointment_type}} - <?php echo date("F d, Y", strtotime($dataValue->date)); ?> </span><br>
          <b style="font-weight: 400;font-size: 15px;color: #52d862"><a style="color: #52d862" href="{{url('my-account/appointments')}}/{{$dataValue->id}}/details" title="">View</a></b>
        </li>
        <li class="pull-right" style="padding-left: 4px;">
          <b style="color: red;margin-left: 5px;"><a  style="color: red;margin-left: 5px;font-size: 14px;color: #52d862" href="" title=""><i class=""></i> € {{$dataValue->grand_total_with_vat}}</a></b><br>
@if($dataValue->is_order==1)

<b style="color: blue;margin-left: 5px;"><a style="color: blue;margin-left: 5px;font-size: 14px;text-decoration: none;" href="#" title="" class="pay" data-id="{{$dataValue->orderId}}"><i class="fa fa-credit-card"></i> PAY</a></b>
@else
 <b style="color: blue;margin-left: 5px;"><a style="color: blue;margin-left: 5px;font-size: 14px;text-decoration: none;" href="{{url('my-account/my-orders')}}/{{$dataValue->order_id}}/details" title="" ><i class="fa fa-credit-card"></i> PAY</a></b>
@endif
        </li>
      </ul>
      @endforeach
      @else
<h3 style="padding-left: 10px;">Sorry!!Not Found </h3>
      @endif
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
  $('a.pay').click(function(){
    var orderId = $(this).data("id"); // will return the number 123;
      checkMollie(orderId);

  });

  function checkMollie(a){
      var id= a;
      $.ajax({
          url: "{{url('payment/apicall/')}}/" + id,
          type: 'GET',
          dataType: 'json',
          success: function (data) {

              console.log(data);
              var redirectLink = data['mollie']['links']['paymentUrl'];

              window.location = redirectLink;
          }
      });
  }
</script>
@endsection