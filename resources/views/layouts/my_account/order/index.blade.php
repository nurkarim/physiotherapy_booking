@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/style.css')}}">
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
.table tr{height: 20px;}
.table th{font-weight: 400;font-size: 15px}
.table tr td{font-weight: 400;font-size: 14px}
li{list-style: none;}
</style>
<header id="bg-image">
  <div class="mrg-div"></div>
  @include('layouts.my_account.head_title')
  <div class="mrg-div"></div>
</header>
<!-- Page Content -->
<div class="container">
    @include('layouts.ajaxMsg')
  <div class="mrg-div"></div>
  <div class="row">
    <div class="col-md-3">
      @include('layouts.my_account.nav')
    </div>
    <div class="col-md-9" style="border-left: 1px solid #000">
      <div class="row leftbody">
      <div class="col-md-12">
      <table class="table table-bordered" id="myTable" style="margin-top: 10px;">
        <thead>
        <tr style="background-color: black;color: white;">
        
        <th>Order</th>
        <th>Invoice</th>
        <th>Order date</th>
        
        <th>Products</th>
        <th>Total</th>
        <th>Order Status</th>
        <th>Pay</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    @if(count($orders)>0)
    @foreach($orders as $orderValue)

    <?php
$app=DB::table('appointments')->where('id',$orderValue->appoitment_id)->get();
$appointments=DB::table('appointments')->where('order_id',$orderValue->id)->get();
$product=DB::table('order_product_cart')
->select('product_name')
->where('order_id',$orderValue->id)
->get();
$arry=array();
    ?>
      <tr>
        
        <td><a href="{{url('my-account/my-orders')}}/{{$orderValue->id}}/details">#{{$orderValue->id}}</a></td>
        <td>#{{$orderValue->InvID}}</td>
      
        <td>{{$orderValue->date}}</td>
        <td>
          @if(count($app)>0)
          @foreach($app as $appValue)

    <span>{{$appValue->appointment_type}},</span>

@endforeach
@endif
<?php
$j=0;
$i=0;
foreach ($appointments as $key => $values) {
  if ($i==2) {
    break;
  }
  echo $values->appointment_type.',';

  $i++;
}
?>

<?php
$j=0;
foreach ($product as $key => $value) {
  if ($j==3) {
    break;
  }
  echo $value->product_name.',';

  $j++;
}
?>
    </td>
        <td>{{$orderValue->total}} €</td>
        <td>
          @if($orderValue->is_paid==1)

Paid
@else
Unpiad
          @endif

        </td>
        <td>
          @if($orderValue->is_paid==0)
        <a href="" title="" style="text-decoration: none;"><i class="fa fa-credit-card"></i> PAY</a>
        @else
 <a href="" title="" style="text-decoration: none;"><i class="fa fa-file-pdf-o"></i> Invoice</a>
        @endif
        </td>
      </tr>
      @endforeach

      @else
<tr>
  <td colspan="7" align="center">Sorry!! Not Found</td>
</tr>

      @endif
    </tbody>
  </table>
  <div class="pull-right">
    {{ $orders->links() }}
  </div>
    </div>
    </div>
  </div>
</div>
</div>



@endsection
