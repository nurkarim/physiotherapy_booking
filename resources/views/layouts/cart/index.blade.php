@extends('layouts.app')
@section('content')
<style type="text/css">
img.wp-smiley,
img.emoji {
display: inline !important;
border: none !important;
box-shadow: none !important;
height: 1em !important;
width: 1em !important;
margin: 0 .07em !important;
vertical-align: -0.1em !important;
background: none !important;
padding: 0 !important;
}
</style>
<style type="text/css" media="screen">
.cart div li{list-style: none;padding: 10px;}
.cart-ul {border: 1px solid #000}
.cart{
float: none;
margin: 0 auto;
}
</style>
<body><div class="site-container"><style>
  .openForm .appointment_form{height:250px;}
  .openForm .appointment_form.large{height:270px;}
  p.appointment-info{margin:15px 0;}
  .appointment_form .left{
  }
  .appointment_form a.btn{margin-top:10px;}
  #newclients_wrap .close{
  display: none;
  }
  #newclients_links{
  margin: 15px 0;
  }
  #newclients_links a{
  display:block;
  color: white;
  margin: 5px 10px 5px 0;
  }
  @media (max-width: 40em){
  .openForm .appointment_form {
  height: 300px;
  }
  .openForm .appointment_form.large{
  height: 330px;
  }
  .appointment_form .wrap .part.right{
  margin-top:15px;
  }
  }
  </style>
  <script>
  </script>
  <div class="col-md-12" style="height: 20px"></div>
  <div class='bg-img' data-bglg='{{url("public/images/Spartanova-post-LI-copy.jpg")}}' data-bgmd='{{url("public/images/Spartanova-post-LI-copy.jpg")}}'  data-bgsm='{{url("public/images/Spartanova-post-LI-copy-480x320.jpg")}}'>
  </div>
  <div class='header-wrap'>
    <div class='header-container'>
      <div class="content-container">
        <div class="content">
          <header class='site-title-block'>
            <h1><span class="red">Jenkiné Basket</span><br /></h1>
          </header>

        </div>
      </div>

    </div>
  </div>
  <div class="site-inner"><div class="content-sidebar-wrap"><main class="content">
    <article class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry" >
      <div class='entry-content' style="height: 500px;">
        @include('layouts.ajaxMsg')
        {!! Form::open(['url'=>URL::to('checkout/complete/auth'),'id'=>'myForm','files'=>true]) !!}
        <div class="row">
          <div class="cart row col-md-12 ">
            <div class="row col-md-12 cart-ul">
              <li class="col-md-6" style="color: #101010;font-weight: bold;font-size: 16px;">Products</li>
              <li class="col-md-2 " style="color: #101010;font-weight: bold;font-size: 16px;">Price</li>
              <li class="col-md-2 " style="color: #101010;font-weight: bold;font-size: 16px;">Amount</li>
              <li class="col-md-2 " style="color: #101010;font-weight: bold;font-size: 16px;">Total price</li>
              <?php
              $vatApp=0;
              $vatPDT=0;
              $appTotal=0;
              $PdtTotal=0;
              $vatNumber=0;
              $totalPriceProduct=0;
              $theVatAdded=0;
              $getVatNumber=0;
              $priceforUser=0;
              $subTotals=0;
              $PdtsubTotals=0;
              ?>
              @if(Session::has('appoinmentCart'))
              <?php
              $dataRec=array_reverse(Session::get('appoinmentCart'));

              $appointvat=0;
              ?>
              <?php
              $i=0;
                    function count_digit($number) {
                        return strlen($number);
                    }
              ?>
              @foreach($dataRec as $dataRecValue)
              <?php

//                      if ($i==1) {
//              break;
//              }


             $amountOfNumbersVat =   count_digit($dataRecValue['vat_number']);
             if($amountOfNumbersVat == 1){
                 $getVatNumber = '1.0' . $dataRecValue['vat_number'];

             }
             else{
                 $getVatNumber = '1.' . $dataRecValue['vat_number'];

             }
              $totalPriceProduct = $dataRecValue['price'];
              $theVatAdded = round($totalPriceProduct - ($totalPriceProduct/(($getVatNumber/100)+1)),2);
              $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));
              // $appointvat=$dataRecValue["price"];
              // $vatPrice=($dataRecValue["price"]*$dataRecValue["vat_number"])/100;
              // $vatNumber=$vatNumber+$dataRecValue["vat_number"];
              $vatApp+=$theVatAdded;
              $subTotals+=$priceforUser;
              $appTotal+=$totalPriceProduct;
              ?>
              <div class="row col-md-12 " style="margin-top: -10px;">

                <li class="col-md-6"><span style="color: #52d862;font-weight: bold;font-size: 15px;">{{$dataRecValue['name']}}</span>
                <p style="font-weight: 400;font-size: 13px">start date:      <?php echo date("F d, Y", strtotime($dataRecValue['date'])); ?>, {{$dataRecValue['start_time']}}</p>
                <p style="margin-top: -12px;font-weight: 400;font-size: 13px">end date: <?php echo date("F d, Y", strtotime($dataRecValue['date'])); ?>,
                  <?php

                $datea=Carbon\Carbon::parse($dataRecValue['start_time'])->addHour(1);
                  echo $endtime=substr($datea,10, 6);

                  ?>
                </p>
              </li>
              <li class="col-md-2 text-center" style="color: #000;font-size: 16px;margin-left: -35px;">{{number_format($totalPriceProduct,2)}} €</li>
              <li class="col-md-2 text-center" style="color: #000;font-size: 16px;margin-left: -0px;">{{$dataRecValue['qty']}}</li>
              <li class="col-md-2 text-center" style="color: #000;font-size: 16px;margin-left: -0px;">{{number_format($totalPriceProduct,2)}} € <a href="{{url('app-cart-delete')}}/{{$dataRecValue["start_time_id"]}}/{{$dataRecValue["date"]}}" title="delete from cart"><i class="fa fa-trash" style="padding-left: 5px;color: red;cursor: pointer;"></i></a>
              </li>
            </div>
@if(isset($dataRec))
            @if(count($dataRec)>1)
            <input type="hidden" name="appointment_type_id[]" value="{{$dataRecValue['id']}}">
            <input type="hidden" name="appointment_type[]" value="{{$dataRecValue['name']}}">
            <input type="hidden" name="appointment_price[]" value="{{$dataRecValue['price']}}">
            <input type="hidden" name="start_time[]" value="{{$dataRecValue['start_time']}}">
            <input type="hidden" name="end_time[]" value="{{$endtime}}">
            <input type="hidden" name="date[]" value="{{$dataRecValue['date']}}">
            <input type="hidden" name="start_time_id[]" value="{{$dataRecValue['start_time_id']}}">
            <input type="hidden" name="specialist_id[]" value="{{$dataRecValue['specialist']}}">
            <input type="hidden" name="vat_number[]" value="{{$dataRecValue["vat_number"]}}">
            <input type="hidden" name="color[]" value="{{$dataRecValue["color"]}}">
          @else
            <input type="hidden" name="appointment_type_id" value="{{$dataRecValue['id']}}">
            <input type="hidden" name="appointment_type" value="{{$dataRecValue['name']}}">
            <input type="hidden" name="appointment_price" value="{{$dataRecValue['price']}}">
            <input type="hidden" name="start_time" value="{{$dataRecValue['start_time']}}">
            <input type="hidden" name="end_time" value="{{$endtime}}">
            <input type="hidden" name="date" value="{{$dataRecValue['date']}}">
            <input type="hidden" name="start_time_id" value="{{$dataRecValue['start_time_id']}}">
            <input type="hidden" name="specialist_id" value="{{$dataRecValue['specialist']}}">
            <input type="hidden" name="vat_number" value="{{$dataRecValue["vat_number"]}}">
            <input type="hidden" name="color" value="{{$dataRecValue["color"]}}">
          @endif
          @endif
          <?php $i++; ?>
            @endforeach
            @endif
           
            @if(@count(Session::get('appoinmentCart'))>0 && count(Session::get('shopcart'))>0)
            <div class="mrg-div col-md-12" style="border-top: 1px solid #000"></div>
            @endif
            
            {{-- //========================Product cart================================== --}}
            @if(Session::has('shopcart'))
            <?php
            $dataPdt=array_reverse(Session::get('shopcart'));
            $withVat=0;
            ?>
            @foreach($dataPdt as $dataPdtValue)
            <?php
            $percent            =$dataPdtValue['vat'];
            $totalPriceProduct1 = $dataPdtValue['product_price'];
            $theVatAdded1       = round($totalPriceProduct1 - ($totalPriceProduct1/(($percent/100)+1)),2);
            $priceforUser1      = (floatval($totalPriceProduct1) - floatval($theVatAdded1));
            $PdtTotal+=$totalPriceProduct1*$dataPdtValue["qty"];
            $vatPDT+=$theVatAdded1;
            $PdtsubTotals+=$priceforUser1;
            // $amount =60;
            // $percent =21;
            // echo $vat = round($amount - ($amount/(($percent/100)+1)),2);
            ?>
            <div class="row col-md-12 ">
              <li class="col-md-6">
                <div class="row">
                  <div class="col-md-3">
                    <img src="{{url('public/image/products/display')}}/{{@$dataPdtValue['image']}}"  style="height: 70px;width: 100px;">
                  </div>
                  <div class="col-md-9">
                    <span style="color: #52d862;font-weight: bold;font-size: 15px;">{{$dataPdtValue['name']}}</span>
                    <p style="font-size: 14px;">{{@$dataPdtValue['option_products_html']}}</p>
                  </div>
                </div>

              </li>
              <li class="col-md-2 text-center" style="color: #000;font-size: 16px;margin-left: -35px;">{{$dataPdtValue["product_price"]}} €</li>
              <li class="col-md-2 text-center" style="color: #000;font-size: 16px;">
                <select name="qty" id="qty_{{$dataPdtValue["id"]}}" style="height: 30px;width: 50px" onchange="updateQty('{{$dataPdtValue['id']}}')">
                  <option value="1" @if($dataPdtValue["qty"]==1) selected="" @endif>1</option>
                  <option value="2" @if($dataPdtValue["qty"]==2) selected="" @endif>2</option>
                  <option value="3" @if($dataPdtValue["qty"]==3) selected="" @endif>3</option>
                  <option value="4" @if($dataPdtValue["qty"]==4) selected=""  @endif>4</option>
                  <option value="5" @if($dataPdtValue["qty"]==5) selected="" @endif>5</option>

                </select>
              </li>
              <li class="col-md-2 text-center" style="color: #000;font-size: 16px;"><b id="sub_cart_total">{{number_format($totalPriceProduct1*$dataPdtValue["qty"],2)}} </b> € <a href="{{url('cart-delete')}}/{{$dataPdtValue["id"]}}/item" title="delete from cart"><i class="fa fa-trash" style="padding-left: 5px;color: red;cursor: pointer;"></i></a></li>
            </div>
            <input type="hidden" name="product_id[]" value="{{$dataPdtValue['id']}}">
            <input type="hidden" name="product_name[]" value="{{$dataPdtValue['name']}}">
            <input type="hidden" name="product_option_id[]" value="{{$dataPdtValue['option_products']}}">
            <input type="hidden" name="product_option[]" value="{{@$dataPdtValue['option_products_html']}}">
            <input type="hidden" name="product_price[]" value="{{@$dataPdtValue['product_price']}}">
            <input type="hidden" name="product_vat[]" value="{{@$dataPdtValue['vat']}}">
            <input type="hidden" name="image[]" value="{{@$dataPdtValue['image']}}">
            @endforeach
            @endif
            <div class="row col-md-12 ">

              <li class="col-md-8">
                @if(Auth::check())
                @if(Auth::user()->user_type==2)
                <p > My wallet: € <span class="walet_amount_html">
                   @if(@Auth::user()->wallet->price>0)
                  {{Auth::user()->wallet->price}}
                  @else
                  0.00
                  @endif

                </span>

                </p>
                <input type="hidden" name="my_wallet_amount" value="@if(@Auth::user()->wallet->price>0) {{Auth::user()->wallet->price}}@else 0 @endif" id="my_wallet_amount" >

                <input type="hidden" name="my_wallet_amount_old" value="@if(@Auth::user()->wallet->price>0) {{Auth::user()->wallet->price}}@else 0 @endif" id="my_wallet_amount_old">


                <p style="margin-top: -10px;"><input type="checkbox" id="my_wallet" name="my_wallet" value="1" onclick=" return my_wallest()"><label for="my_wallet" style="cursor: pointer;font-size: 14px;" >Use credits from my wallet</label></p>
                @endif
                @endif
              </li>
              <div class="col-md-4" style="border-left: 1px solid #000">
                <div class="pull-right">
                  <li style="margin-top: -16px;font-weight: bold;font-size: 22px;color: #000">Totals</li>

                  <li style="margin-top: -16px;">Vat: <span class="sub_total">
                    <?php  $GrandVat=$vatPDT+$vatApp; ?>
                  {{number_format($GrandVat,2)}}</span> €
<input type="hidden" name="grand_vat_price" value="{{number_format($GrandVat,2)}}">
                </li>
                  <li style="margin-top: -16px;">Subtotal: <span class="sub_total">
                    <?php  $subt=$PdtsubTotals+$subTotals; ?>
                    {{number_format($subt,2)}}</span><input type="hidden" name="sub_total" value="{{number_format($subt,2)}}"> €</li>
                    {{-- <li style="margin-top: -16px;">Wallet: <span class="wallet">-60,00</span> €</li> --}}
                    <li style="margin-top: -16px;" id="total_li">Total: <span class="total">
                      <?php  $tot=$PdtTotal+$appTotal; ?>
                      {{number_format($tot,2)}}</span>
                      <input type="hidden" name="total_with_vat" id="total_with_vat"  value="{{number_format($tot,2)}}">
                      <input type="hidden"  id="total_amount"  value="{{number_format($tot,2)}}">
                    €</li>

                    @if(Auth::check())
                    @if(Auth::user()->user_type==2)

                      <li style="margin-top: -16px;"><a class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862" href="{{url('checkout')}}/{{Auth::user()->id}}"> <i class="" style="padding: 4px;background-color: white;color:black">Proceed to checkout</i><i class="fa  fa-check" style="padding: 2px 6px"></i></a></li>

                    @else

                    @endif

                    @else
                    <li style="margin-top: -16px;"><a class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862" href="{{url('checkout')}}"> <i class="" style="padding: 4px;background-color: white;color:black">Proceed to checkout</i><i class="fa  fa-check" style="padding: 2px 6px"></i></a></li>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      </article><!-- /article -->
    </main></div></div>
  </div>
  @section('js')
  <script>
  function my_wallest() {

  var wallet_amount=$("#my_wallet_amount_old").val();
  var total_amount=$("#total_amount").val();
  if ($('#my_wallet').is(':checked')) {

  if (Number(wallet_amount)>=Number(total_amount)) {

        var subst =(parseFloat(wallet_amount)-parseFloat(total_amount));
        var sub1=parseFloat(wallet_amount)-parseFloat(subst);
        var sub2=sub1;
        var sub3=parseFloat(sub1)-parseFloat(total_amount);
        var sub4=parseFloat(wallet_amount)-parseFloat(sub1);
        $(".total").html(" ");
        $(".total").html(parseFloat(sub3));
        $(".walet_amount_html").html(parseFloat(sub4));
        $("#my_wallet_amount").val(sub4);
  }else{
    var subst =(parseFloat(total_amount)-parseFloat(wallet_amount));
    var sub2=0;
    var sub1=wallet_amount;
     $(".total").html(" ");
      $(".total").html(parseFloat(subst));
      $(".walet_amount_html").html(parseFloat(sub2));
      $("#my_wallet_amount").val(sub2);
  }

  $("<li id='my_wallet_li' style='margin-top: -16px;'>Wallet: <span class='mywallet'>-"+sub1+"</span> € <input type='hidden' name='wallet_price' id='wallet_price' value='"+sub1+"'> </li>").insertAfter("#total_li");
  }else{

  $(".total").html(" ");
  $(".walet_amount_html").html(parseFloat(wallet_amount));
  $(".total").html(total_amount);
  $("#my_wallet_li").remove();

  }
  }

  var update_succ = $('.update-suc');
  function updateQty(id) {
  var product_id=id;
  var qty=$("#qty_"+id).val();
  if (product_id==null) {
  alert('Warning!Please select a option product');
  return false;
  }
  $.ajaxSetup({
  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  $.ajax({
  url:"{{url('update-cart')}}",
  type     : "GET",
  cache    : false,
  dataType : 'json',
  data     : {'product_id': product_id,'qty':qty},

  success  : function(data){
  if (data.success==true) {
  update_succ.slideDown();
  update_succ.delay(6000).slideUp(300);
  location.reload();
  }else if(data.success==false){

  }
  },
  error: function(data){


  }
  });
  return false;
  }
  </script>
  <script type='text/javascript' src='{{url("public/js/main.min.js")}}'></script>
  @endsection
  @endsection
