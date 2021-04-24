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
</style>
<style type="text/css">
  .pagination li {
  padding: 5px;
}


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
    <div class="col-md-4">
      @include('layouts.my_account.nav')
    </div>
    <div class="col-md-8" style="border-left: 1px solid #000">
      <div class="row leftbody">
        <ul class="col-md-12">
          <li><form role="search" class="navbar-left " style="margin-top: 6px;">
            <input type="text" placeholder="Search..." class="form-control" style="" id="search-input">

          </form></li>
         {{--  <li><a href="{{url('my-account/my-appointments')}}" title=""><span style="font-weight: 400;padding: 10px;">List view</span></a>|<span style="font-weight: 400;padding: 10px;">Calendar view</span></li> --}}
        </ul>
        <?php $i=1; ?>
        @if(count($data)>0)
        @foreach($data as $dataValue)
        <ul class="row col-md-9" style="margin-left: 10px;border-bottom: 1px solid #000">
          <li><b>Appointment {{$i++}}:</b> <span>{{$dataValue->appointment_type}} - <?php echo date("F d, Y", strtotime($dataValue->date)); ?>. </span><br>
          <b style="font-weight: 400;font-size: 15px;color: #52d862"><a style="color: #52d862" href="{{url('my-account/appointments')}}/{{$dataValue->id}}/details" title="">View Appointment</a></b>
          <b class="pull-right" style="font-weight: bold;font-size: 15px">{{$dataValue->start_time}} - {{$dataValue->end_time}}  </b>
        </li>
        <li class="pull-right" style="border-left: 1px solid red;padding-left: 4px;">
          <b style="color: red;margin-left: 5px;"><a  style="color: red;margin-left: 5px;font-size: 14px;" href="{{url('my-account/appointments')}}/{{$dataValue->id}}/delete" title=""><i class="fa fa-close"></i> Cancel</b></a><br>
          <b style="color: blue;margin-left: 5px;"><a style="color: blue;margin-left: 5px;font-size: 14px;" href="{{url('my-account/appointments')}}/{{$dataValue->id}}/edit" title=""><i class="fa fa-edit"></i> Change</b></a>
        </li>
      </ul>
      @endforeach
        @else
<h3 style="padding-left: 10px;">Sorry!!Not Create Appointment</h3>
      @endif
    </div>
    <div class="pull-right">
      {{ $data->links() }}
    </div>
  </div>
</div>
</div>



@endsection
@javascript

@endjavascript
