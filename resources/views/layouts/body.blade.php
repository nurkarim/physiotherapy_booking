@extends('layouts.app')
@section('content')

<style type="text/css">
    .table-condensed tr td{color: black;}
    p{color: black;font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;font-size: 14px;}
 li{list-style: none; margin-left: 10px !important;}
    li:first-child{list-style: none; margin-left: 0px !important;}
</style>
<div class="col-md-12" style="height: 20px"></div>
<div class="col-md-12" style="background-color: white">

<div class="video-wrap" >
  <div class="video-overlay"></div>
  
</div>
<div class="header-wrap" style="height: auto;" >
  <div class="header-container"  style="transform: translate3d(0px, -13.5px, 0px);">
      <div class="content-container">
        <div class="content">
          <header class="site-title-block" >
            <div class="bg-image">
          <h2 class="titles"><span class="red">Reserve an appointment</span></h2>
       
      <p class="title-sub" style="color: green;font-weight: bold;">Chose a date for an appointment</p>
</div>
          <div class="intro">
{{-- d-none d-sm-block --}}
   <div class="row " id="specialist-row">
        <div class="col-lg-6 mb-6 col-sm-6 ">
            <div class="pull-right">
                <p style="font-size: 17px;color: black">Select your specialist </p>
                <select name="specialist_id" id="specialist-option"  class=" form-control chosen-select-deselect"  onchange="selectspecialist()">
                    <option value="">Select your specialist</option>
                    @foreach($specialist as $specialistValue)
                    <option selected value="{{$specialistValue->id}}">{{$specialistValue->first_name}}</option>
                    @endforeach
                </select>
                <div class="mrg-div"></div>
            </div>
        </div>
        <div class="col-lg-6 mb-6 col-sm-6" style="border-left: 1px solid #000">

            <table>

                <thead>
                    <tr>
                        <th colspan="2" style="font-size: 14px;color: black">Info about the selected specialist</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 30%"><img src="{{url('public/image/doctor-img.png')}}" alt="" style="height: 100px;max-width: 100px" class="img-responsive img-circle" id="img_specialist"></td>
                        <td>
                            
                            <p id="sp_name" style="color: black">Specialist</p>
                            <p style="margin-top: -10px;">

                                <a class="contact-button btn btn-sm contact-button-email" id="sp-email" href="javascript:void()" >Contact by mail <i class="fa  fa-envelope-open"></i></a>
                            </p>
                            <p style="margin-top: -10px;"> <a class="contact-button btn btn-sm contact-button-email" id="sp-email" href="javascript:void()">Contact by phone <i class="fa  fa-phone"></i></a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

          </div>
    </header>
    <div class="container">

 <div class="row" style="border-top: 1px solid #000">


        <div class="col-md-12">


                <table style="margin-top: 10px;margin-bottom: 10px;">




                    </table>

            </div>
            <div class="col-md-12 row">
                <div class="col-md-5">
                    <input type="hidden" name="appointment_date" id="date_value" value="{{date('Y-m-d')}}">
                    <div id="datetimepicker12"></div>
                </div>
                <div class="col-md-4">
                    <p  style="color: black;">Selected day:</p>
                    <p style="color: #52d862;font-weight: bold;" id="selected_date">{{date('M d,Y')}}</p>

                    <li style="font-weight: bold;font-size: 17px;color: black;list-style: none">Select a Appointment hour</li>
                    <ul style="height: 230px;overflow: auto;border:1px solid #000;margin: 0px;padding: 0px;width: 70%" class="hoursbox">
                        <li style="list-style: none;font-size: 15px;height: 26px;background-color: #f1f1f1;padding: 0px 5px;" class='select_available_hour' >Select Available hour</li>
                 <li class="putinhere" style="color:black;font-size: 15px;"></li>
                    </ul>

                    <p style="">Select an Appointment Type</p>
                    <p>
                        <select name="appointment_type" id="appointment_type_id" class="appointment_type" onchange="selectAppointmentType()">
                            <option>select appointment types</option>
                            @foreach($appointment_types as $appointment_typesValue)
                            <option value="{{$appointment_typesValue->id}}" >
                                {{$appointment_typesValue->type_name}}
                            </option>
                            @endforeach
                        </select>
                    </p>
                    <p>Price: € <b class="price">0.00</b> <input type="hidden" id="type_price"> <input type="hidden" id="type_name"><input type="hidden" id="vat_number"></p>
                    <p> <button class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862;cursor: pointer;"  onclick="appointment()"> <i class="" style="padding: 5px;background-color: white;color:black">Confirm booking</i><i class="fa  fa-check" style="padding: 4px 6px"></i></button ></p>
                </div>
            </div>


        </div>
        <div class="mrg-div"></div>
        <input type="hidden" name="" id="time_id">
        <input type="hidden" name="" id="strttime_hmtl">
        <input type="hidden" name="" id="color">

        @include('errors.ajaxMsg')

</div>
        </div>
      </div>

  </div>
</div>


</div>
@section('js')

     <script type="text/javascript">
function selectTimes(id) {
    var time=$("#times_"+id).val();
    var timehtml=$("#time_html_"+id).html();
    $("#time_id").val(time);
    $("#strttime_hmtl").val(timehtml);

}

    function checkWeektype(){
        var date_val=$("#date_value").val();
        $.ajax({
        url: "{{url('availability/weekTypeTimes')}}/" + date_val,
        dataType: 'json',
        success: function (data) {
        console.log(data);
        $('ul.hoursbox .putinhere').html('');
        for($i = 0; $i < data[0].length; $i++){
        $('ul.hoursbox .putinhere').append('<li style="list-style: none;font-weight: 400;font-size: 15px;margin: 0px;padding: 0px;margin-top: 5px; padding-left: 15px;"><div class="radio radio-success radio-circle weektype_hours"><li><input id="times_'+$i+'" type="radio" name="start_time" class="start_time_id" value="'+$i+'" onclick="selectTimes('+$i+')"><label for="times_'+$i+'" id="time_html_'+$i+'" title="" class="timeLabel">'+data[0][$i]+'</label></li></div></li>');
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

    $(function() {
    $('#appointment_type_id').select2();
    $('.chosen-select-deselect').select2();
    // $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });
    </script>
    <script type="text/javascript">
    $(function () {

    $('#datetimepicker12').datetimepicker({
    inline: true,
    sideBySide: true,

    format: 'YYYY-MM-DD',
    }).bind('dp.change', function (e, selectedDate, $td) {
    $('#date_value').val(moment(e.date._d).format("YYYY-MM-DD"));
    $('#selected_date').html(moment(e.date._d).format(" MMM DD, YYYY"));
    $('.day_selecet').html(moment(e.date._d).format("DD"));
    
    var day=moment(e.date._d).format("DD");
    checkWeektype()
    updateVat(day);
    });
    });




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

    function selectspecialist() {

    var id=$("#specialist-option").val();
    if (id=='') {
        alert("please select specialist");
        return false
    }
    $.ajax({
    url: "{{url('select-user')}}/"+id+"/select",
    dataType:'json',
    success : function(data){
    if (data.success==true) {


    $('#sp_name').html(data.name);
        $('#sp-email').attr('href','mailto:'+data.email+'?subject=feedback');

     if (data.image!=null) {
        alert(data.image);
    var img="{{url('public/image/users')}}/"+data.image;
        $('#img_specialist').attr('src',img);

        }else{
    $('#img_specialist').attr('src','{{url("public/image/doctor-img.png")}}');

        }
    }else{
    $('#sp_name').html(data.name);
    $('#img_specialist').attr('src','{{url("public/image/doctor-img.png")}}');


    }
    }
    });
    return true;
    }


    function updateVat(day) {
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
    $(".unvailable_date").html(day);
    $(".available_date").html('00');
    $(".day_selecet").html(day);
    }else if(data.success==false){
    $(".unvailable_date").html('00');
    $(".available_date").html(day);
    $(".day_selecet").html(day);
    }
    },
    error: function(data){


    }
    });
    return false;
    }


     function appointment() {
    var days=$("#date_value").val();
    var specialist=$("#specialist-option").val();
    var select_time=$("#time_id").val();
    var type_price=$("#type_price").val();
    var type_name=$("#type_name").val();
    var vat_number=$("#vat_number").val();
    var appointment_type=$(".appointment_type").val();
    var time_html= $("#strttime_hmtl").val();
    var color= $("#color").val();

    if (days=="") {
    alert('Please select date');
    return false;
    }
     if (appointment_type=="") {
    alert('Please select appointment type');
    appointment_type.focus();
    return false;
    }
    if (specialist=="") {
    alert('Please select specialist');
    return false;
    }
    if (select_time=="") {
    alert('Please select time');
    return false;
    }
    if (type_price=="") {
    alert('Please select time');
    return false;
    }
    $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    $.ajax({
    url:"{{url('appointments-create')}}",
    type     : "GET",
    cache    : false,
    dataType : 'json',
    data     : {'date': days,'appointment_type':appointment_type,'specialist':specialist,'select_time':select_time,'type_price':type_price,'type_name':type_name,'time_html':time_html,'vat_number':vat_number,'color':color},

    success  : function(data){
    if (data.success==true) {
        info_update_dynamic.slideDown();
        info_update_dynamic.delay(6000).slideUp(300);
        $('.info-update-dynamic label').html(data.sms);
    }
    if(data.addsuccess==true){
        info_suc_dynamic.slideDown();
        info_suc_dynamic.delay(6000).slideUp(300);
        $('.info-suc-dynamic label').html(data.sms);
    }else{
        info_suc_dynamic.slideDown();
        info_suc_dynamic.delay(6000).slideUp(300);
         $('.info-update-dynamic label').html(data.sms);
    }
    },
    error: function(data){


    }
    });
    return false;
    }
    </script>
@endsection
@endsection
