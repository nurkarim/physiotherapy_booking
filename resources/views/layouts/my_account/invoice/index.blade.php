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
<ul class="row col-md-10" style="margin-left: 10px;border-bottom: 1px solid #000">
      
      	<li><b>invoice {{$i++}} #{{$dataValue->InvId}}: </b> <span>- {{$dataValue->InvDate}}.</span><br>
	<b style="font-weight: 400;font-size: 15px;color: #52d862"><a style="color: #52d862;text-decoration: none;" href="" title="">View invoice</a></b> | <b style="font-weight: 400;font-size: 15px;color: #52d862"><a style="color: #52d862;text-decoration: none;" href="" title="">View  order</a></b>

      	</li>

      </ul>
      @endforeach

      @else
<h3 style="padding-left: 10px;">Sorry!!Not Found</h3>
      @endif
     </div>

  </div>  
</div>
  </div>

@endsection