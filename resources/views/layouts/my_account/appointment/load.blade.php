

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
 li{list-style: none; margin-left: 10px !important;}
    li:first-child{list-style: none; margin-left: 0px !important;}
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
    {!! Form::open(['url'=>URL::to('update_appointment'),'id'=>'myForm']) !!}

        <div class=" col-md-12" style="margin-top: 10px;margin-bottom: 5px;"><span style="font-weight: bold;font-size: 17px;color: #000">{{$appointment->appointment_type}} - <?php echo date("F d, Y", strtotime($appointment->date)); ?> : {{$appointment->start_time}} - {{$appointment->end_time}} </span></div>
<div class=" col-md-12" style="margin-top: 10px;margin-bottom: 5px;">
<select name="appointment_type" id="select-time" class="appointment_type" onchange="selectAppointmentType()" style="border: 1px solid #000;">
                            <option>select appointment types</option>
                            @foreach($appointment_types as $appointment_typesValue)
                            <option value="{{$appointment_typesValue->id}}" style="background-color: white" @if($appointment->appointment_type_id==$appointment_typesValue->id) selected=""  @endif>
                                {{$appointment_typesValue->type_name}}
                            </option>
                            @endforeach
</select>
</div>
  
<div class="row col-md-12">
  <div class="col-md-6">
     <li style="list-style: none;font-weight: bold;">Invoice address <a href="{{url('my-account/edit')}}" class="fa fa-edit"></a></li>
          <li style="list-style: none;">{{$address->invoice_address}}</li>
          <li style="list-style: none;">{{$address->post_code}} {{$address->city}}</li>
          <li style="list-style: none;">{{$address->iCName}}</li>
  </div>
    <div class="col-md-6">
    <li style="list-style: none;font-weight: bold;">Shipping address <a href="{{url('my-account/edit')}}" class="fa fa-edit"></a></li>
          <li style="list-style: none;">{{$address->shipping_address}}</li>
          <li style="list-style: none;">{{$address->shipping_post_code}} {{$address->shopping_city}}</li>
          <li style="list-style: none;">{{$address->ScName}}</li>
  </div>
</div> 

{{-- ====================end details======================== --}}
{{-- ====================start appointment details======================== --}}

<div class="row col-md-12" style="height: 20px;">

</div>
<div class="row col-md-12">
  <div class="col-md-6">
   <div id="datetimepicker12"></div>
  </div>
    <div class="col-md-6">
   <p style="color: #52d862;font-weight: bold;" id="selected_date"> <?php echo date("M d, Y", strtotime($appointment->date)); ?></p>

                    <ul style="height: 230px;overflow: auto;border:1px solid #000;margin: 0px;padding: 0px;width: 70%" class="hoursbox">
                        <li style="list-style: none;font-size: 15px;height: 26px;background-color: #f1f1f1;padding: 0px 5px;" class='select_available_hour' >Select Available hour</li>
                 <li class="putinhere" style="color:black;font-size: 15px;"></li>
                    </ul>
  </div>
<div class=" col-md-12" style="margin-top: 10px;margin-bottom: 10px;">
    <input type="hidden" id="type_price" name="type_price"> 
    <input type="hidden" id="type_name" name="type_name">
    <input type="hidden" id="vat_number" name="vat_number">
    <input type="hidden" id="time_id" name="start_time_id_old" value="{{$appointment->start_time_id}}">
    <input type="hidden" id="specialist_id" name="specialist_id" value="{{$appointment->specialist_id}}">
    <input type="hidden" name="appointment_date" id="date_value" value="{{$appointment->date}}">
    <input type="hidden" name="appointment_id" id="appointment_id" value="{{$appointment->id}}">
       
        <input type="hidden" name="strat_time" id="strttime_hmtl" value="{{$appointment->start_time}}">
        <input type="hidden" name="color" id="color" value="{{$appointment->color}}">

      <button class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862" type="submit"> <i class="" style="padding: 4px;background-color: white;color:black">Comfirm change</i><i class="fa  fa-check" style="padding: 2px 6px"></i></button>
</div>
</div> 
{!! Form::close() !!}
</div>   
</div>
</div>



    <script>
    	function selectTimes(id) {
    var time=$("#times_"+id).val();
    var timehtml=$("#time_html_"+id).html();
    $("#time_id").val(time);
    $("#strttime_hmtl").val(timehtml);

}

    $(function () {

$('#datetimepicker12').datetimepicker({
inline: true,
sideBySide: true,

format: 'YYYY-MM-DD',
defaultDate:moment("{{$appointment->date}}")
}).bind('dp.change', function (e, selectedDate, $td) {
    $('#date_value').val(moment(e.date._d).format("YYYY-MM-DD"));
     $('#selected_date').html(moment(e.date._d).format(" MMM DD, YYYY"));
    CheckBooking();
    });
});

 function checkWeektype(){
        var date_val=$("#date_value").val();
        $.ajax({
        url: "{{url('availability/weekTypeTimes')}}/" + date_val,
        dataType: 'json',
        success: function (data) {
        console.log(data);
        $('ul.hoursbox .putinhere').html('');
        for($i = 0; $i < data[0].length; $i++){
        $('ul.hoursbox .putinhere').append('<li style="list-style: none;font-weight: 400;font-size: 15px;margin: 0px;padding: 0px;margin-top: 5px; padding-left: 15px;"><div class="radio radio-success radio-circle weektype_hours"><li><input id="times_'+$i+'" type="radio" name="start_time" class="start_time_id" value="'+$i+'" onclick="selectTimes('+$i+')" required=""><label for="times_'+$i+'" id="time_html_'+$i+'" title="" class="timeLabel">'+data[0][$i]+'</label></li></div></li>');
        }
        if(data[0].length < 1){
        $('ul.hoursbox .putinhere').append('<li>Not  a bookable date</li>');
        }
        checkAvailavility();
        }
        });
        }
    checkWeektype();

     function checkAvailavility() {
        var date_val=$("#date_value").val();
        $.ajax({
        url: "{{url('unavailable-weekType')}}/"+date_val,
        dataType:'json',
        success : function(data){
        $("input.start_time_id").prop('disabled', false);
        $("input.start_time_id").prop('checked', false);
        $(".timeLabel").prop('title', "");
        $(".timeLabel").css('color', "black");
        jQuery.each(data, function(index, val) {
        val['time'] = val['time']- 1;
        $("#times_"+val['time']).prop('disabled', true);
        $("#time_html_"+val['time']).prop('title', "Unavailable time");
        $("#time_html_"+val['time']).css('color', "red");
        console.log(val);
        });
        checkAvailAviltimes();
        },
        error: function(data){
        $("input.start_time_id").prop('disabled', false);
        $("input.start_time_id").prop('checked', false);
        $(".timeLabel").css('color', "black");
        checkAvailAviltimes();
        }
        });
        return true;
        }
        function checkAvailAviltimes() {
        var date_val=$("#date_value").val();
        $.ajax({
        url: "{{url('unavailavail-check-date')}}/"+date_val+"/date",
        dataType:'json',
        success : function(data){
        jQuery.each(data, function(index, val) {
        $("#times_"+val).prop('disabled', true);
        $("#time_html_"+val).prop('title', "This time have booked");
        $("#time_html_"+val).css('color', "green");
        console.log(val);
        });
        },
        error: function(data){
        }
        });
        return true;
        }
        checkAvailavility();



function CheckBooking() {
    var days=$("#date_value").val();
    if (days==null) {
    alert('Warning!Blank Field must be required.');
    return false;
    }
    $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    $.ajax({
    url:"{{url('appointments-available-check')}}",
    type     : "GET",
    cache    : false,
    dataType : 'json',
    data     : {'days': days},
    
    success  : function(data){
    if (data.success==true) {
alert("Sorry!!Unavailable Date");
    }else if(data.success==false){

    }
    },
    error: function(data){
    
    
    }
    });
    return false;
    }



 function selectAppointmentType() {
    
    var id=$(".appointment_type").val();
    $.ajax({
    url: "{{url('appointment-types')}}/"+id+"/select",
    dataType:'json',
    success : function(data){
    
    $('.price').html(data.amount);
    $('#type_price').val(data.amount);
    $('#type_name').val(data.type_name);
    $('#vat_number').val(data.vat_number);
    $('#color').val(data.color);
    }
    });
    return true;
    }    
selectAppointmentType();
    </script>



@endsection


    