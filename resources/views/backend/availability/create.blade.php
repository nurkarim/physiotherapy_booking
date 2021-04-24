@extends('backend.index')
@section('content')
<style type="text/css">
  .table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
</style>

    <style>
      @keyframes slideIn {
          0% {
              transform: translateY(200px);
          }
        60% {
              transform: translateY(200px);
          }
          100% {
              transform: translateY(0);
          }
      }

      #detect {
        position: fixed;
        bottom: 25px;
        left: calc(50% - 167px);
        background-color: #8E44AD;
        color: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.5);
        text-align: center;
        animation: 0.8s ease-out 0s 1 slideIn;
      }

      #detect,
      #detect:hover,
      #detect:visited,
      #detect:active {
        text-decoration: none;
      }

      #detect:hover {
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.8);
      }

      #detect img {
        width: 150px;
        margin-top: 15px;
      }
    </style>

<link rel="stylesheet" href="{{url('public')}}/css/bootstrap-year-calendar.min.css">

<link rel="stylesheet" href="{{url('public')}}/css/bootstrap-year-calendar.min.css">
<div class="available_page">
<div class="row">
  <div class="col-md-12 col-md-offset-1">
    <h3 style="color: black">Availability <span class="title_text">-Overrule Week Type</span ></h3>
  </div>
  <div class="col-md-12 col-md-offset-1">
    <button type="button" id="btn_day" style="background-color: green;color: white;border-style: hidden;padding: 10px;margin: 0px" onclick="day_availability()">Day</button>
    <button type="button" style="background-color: #52d862;color: white;border-style: hidden;padding: 10px;margin: 0px;margin-left: -3px" id="week_r" onclick="week_type()">Week</button>
    <button type="button" style="background-color: #52d862;color: white;border-style: hidden;padding: 10px;margin: 0px;margin-left: -3px" onclick="date_range()" id="date_r">Date range</button>
  </div>
  <div class="col-md-6 col-md-offset-1" id="date_range">
    <div class="form-group" style="margin-top: 10px;">

      <li style="list-style: none;padding: 4px;font-size: 16px;font-weight: 400;">Pick start date: <input type="text" name="start_date" id="datetimepicke3" style="height: 30px;background-color: #f1f1f1;width: 70%" placeholder="yyyy-mm-dd" class="form-control"></li>
      <li style="list-style: none;padding: 4px;font-size: 16px;font-weight: 400;">Pick end date: <input type="text" name="end_date" id="datetimepicker2" style="height: 30px;background-color: #f1f1f1;width: 70%" placeholder="yyyy-mm-dd" class="form-control"></li>
      <p style="color: black;font-weight: 400">Plan holiday from <b id="pik_start">  </b> till <b id="pik_end">  </b>.</p>
      <p style="color: red;font-weight: 400">Recurrent Appointments will be canceled for this period</p>
      <p id="smstext"></p>
    </div>
    <button type="button" onclick="holidayPlan()" class="btn btn-info btn-sm" style="background-color: #52d862;color: white;padding: 4px 10px;">Comfirm</button>

  </div>
  <div class="col-md-8 col-md-offset-1" id="day_availability">
    {!! Form::open(['url'=>URL::to('day-availability'),'id'=>'myForm','files'=>true]) !!}
    <div class="form-group">
      <div class="col-md-8" id="datetime">
        <input type="hidden" name="day_date" id="date_val" required="" value="">
        <div id="datetimepicker12"></div>
      </div>
      <div class="col-md-4">
        <?php
        $unarr=array();
        $appoint[]=array();
        ?>

        @foreach($app as $appValue)
        <?php
        $appoint[]=$appValue->start_time_id;
        ?>
        @endforeach
        @foreach($select_unavail as $select_unavailValue)
        <?php
        $unarr[]=$select_unavailValue->time;
        ?>
        @endforeach
        <ul style="height: 240px;overflow: auto;border:1px solid #000" id="time_list">
          @foreach($select_time as $select_timeValue)
          @if(in_array($select_timeValue->id, $appoint))
          <li style="list-style: none;font-weight: 400;font-size: 15px;" >
            <div class="checkbox   @if(in_array($select_timeValue->id, $unarr)) checkbox-success @endif">
              <input id="times_{{$select_timeValue->id}}" type="checkbox" name="day_time[]" onclick ="selectedTime('{{$select_timeValue->id}}')" value="{{$select_timeValue->id}}" disabled="" style="background-color: rgba(0, 255, 0, .8);" >
              <label for="times_{{$select_timeValue->id}}" id="times_html_{{$select_timeValue->id}}" title="has Booking">
                {{$select_timeValue->name}}
              </label>
            </div>
          </li>
          @elseif(in_array($select_timeValue->id, $unarr))
          <li style="list-style: none;font-weight: 400;font-size: 15px;" >
            <div class="checkbox   @if(in_array($select_timeValue->id, $unarr)) checkbox-success @endif">
              <input id="times_{{$select_timeValue->id}}" type="checkbox" name="day_time[]" onclick ="selectedTime('{{$select_timeValue->id}}')" value="{{$select_timeValue->id}}" @if(in_array($select_timeValue->id, $unarr)) checked="" @endif>
              <label for="times_{{$select_timeValue->id}}" id="times_html_{{$select_timeValue->id}}" title="unavailable hours ">
                {{$select_timeValue->name}}
              </label>
            </div>
          </li>
          @else
          <li style="list-style: none;font-weight: 400;font-size: 15px;" >
            <div class="checkbox checkbox-success">
              <input id="times_{{$select_timeValue->id}}" type="checkbox" name="day_time[]" onclick ="selectedTime('{{$select_timeValue->id}}')" value="{{$select_timeValue->id}}" class="timeer">
              <label for="times_{{$select_timeValue->id}}" id="times_html_{{$select_timeValue->id}}">
                {{$select_timeValue->name}}
              </label>
            </div>
          </li>
          @endif
          @endforeach
        </ul>
        {{--  <li style="list-style: none;"><b>Select all</b> - <b>Unselect all</b></li> --}}
      </div>
    </div>
    <div class="col-md-12" style="margin-top: 10px">
      <div class="col-md-12 ">
        <p style="font-size: 17px;">Date selected:</p>
        <li id="selected_date" style="list-style: none;font-size: 18px;color: #52d862;font-weight: bold;"><?php echo date('d M'); ?></li>
      </div>
      <div class="col-md-12 ">
        <p style="font-size: 17px;">Hours selected:</p>
        <ul id="selected_time"  style="padding: 0px;">
          @if(count($select_unavail)>0)
          @foreach($select_unavail as $select_unavailValues)
        <li id="time_{{$select_unavailValues->time}}"  style="list-style: none;font-size: 18px;color: #52d862;font-weight: bold;">{{$select_unavailValues->timename}}</li>
        @endforeach
        @endif
        </ul>
      </div>
      <input type="hidden" name="save_type" value="" id="save_type">
      <button type="submit" onclick="saveType('2')" class="btn" style="background-color: #52d862;color: white">Make selected hours unavailable</button>
      <button type="submit" onclick="saveType('1')" class="btn" style="background-color: #52d862;color: white">Make selected hours available</button>
    </div>
    {!! Form::close() !!}
  </div>
  <div class="row week-div col-md-12 " >


<div data-provide="calendar" id="calendar"></div>
    <div class="col-md-12" style="margin-top: 10px; ">
      <ul>
        <li style="list-style: none;text-align: center;">For selected week <span class="strt" style="font-size: 14px;font-weight: bold;color: green"></span> <span class="endstr" style="font-size: 14px;font-weight: bold;color: green"></span> Apply :
          <select style="height: 25px;width: 200px;" id="week_types" onchange="">

              @foreach($week_type as $week_type)
                  <option value="{{$week_type->id}}"  selected="">{{$week_type->week_type_name}}</option>
              @endforeach

        </select> <button type="button" class="btn btn-info" onclick="saveWeekType()">Comfirm</button></li>
      </ul>
    </div>
  </div>
</div>
</div>

<style type="text/css" media="screen">
/*.month tr:hover {
    background-color: #808080;
}*/
#date_range{display: none;}
.week-div{display: none;margin-top: 10px;}
</style>

<script type="text/javascript">
//   var d = new Date();
// var month = d.getMonth();
// var day = d.getDate();
// var year = d.getFullYear();
// var ddd=dateFormat(d, "YYYY-MM-DD");
function saveType(id) {
$("#save_type").val(id);
}
function selectedTime(id) {

var ul =$("#selected_time");
if ($('#times_'+id).is(':checked')) {
var time=$("#times_html_"+id).html();
ul.append('<li id="time_'+id+'"  style="list-style: none;font-size: 18px;color: #52d862;font-weight: bold;">'+time+'</li>');
}else{
$("#time_"+id).remove();
}
}
function dateGet() {
var d = $('#datetimepicker12').data('DateTimePicker').date();
// var selectedDate = $("#datetimepicker12").find(".active").data("day");
var selectedDate = $("#datetimepicker12").find(".active").data("day");
alert(selectedDate);
}
$(function () {
$('#datetimepicker12').datetimepicker({
inline: true,
sideBySide: true,
format: 'YYYY-MM-DD',

}).bind('dp.change', function (e, selectedDate, $td) {
$('#date_val').val(moment(e.date._d).format("YYYY-MM-DD"));
$('#selected_date').html(moment(e.date._d).format("DD MMM"));

checkunavailability();
checkAvailAvil();
});
// var date=$("#datetimepicker12").data('datetimepicker').setLocalDate(new Date(year, month, day, 00, 01));
$('#datetimepicke3').datetimepicker({

format: 'YYYY-MM-DD',
}).bind('dp.change', function (e, selectedDate, $td) {

$('#pik_start').html(moment(e.date._d).format("DD MMM"));
});
$('#datetimepicker2').datetimepicker({

format: 'YYYY-MM-DD',
}).bind('dp.change', function (e, selectedDate, $td) {

$('#pik_end').html(moment(e.date._d).format("DD MMM"));
});
});
function day_availability() {
  $(".week-div").hide();
$("#day_availability").show();
$("#date_range").hide();
$("#btn_day").css('background-color','green');
$("#date_r").css('background-color','#52d862');
$(".title_text").html("-Overrule Week Type");
}
function date_range() {
  $(".week-div").hide();
$("#day_availability").hide();
$("#date_range").show();
$("#date_r").css('background-color','green');
$("#btn_day").css('background-color','#52d862');
$(".title_text").html("-Holidays");
}

function week_type() {
$(".week-div").show();
$("#day_availability").hide();
$("#date_range").hide();
$("#week_r").css('background-color','green');
$("#date_r").css('background-color','52d862');
$("#btn_day").css('background-color','#52d862');
$(".title_text").html("-select week for week type ");
}

var weekId=<?php if (isset($weekId)) {
 echo $weekId;
}else{
 echo 0;
} ?>;
if (weekId>0) {
week_type();
}

   function checkAvailAvil() {

var date_val=$("#date_val").val();
    $.ajax({
    url: "{{url('unavailavail-check-date')}}/"+date_val+"/date",
    dataType:'json',
    success : function(data){

       $("input:checkbox").prop('disabled', false);

      jQuery.each(data, function(index, val) {
       $("#times_"+val).prop('checked', false);
       $("#times_"+val).prop('disabled', true);
        $("#times_html_"+val).prop('title', "This time has booked");
        $("#times_html_"+val).css('color', "green");
      });


    },
    error: function(data){

    $("input:checkbox").prop('disabled', false);
    }
    });
    return true;
    }


   function checkunavailability() {
var ul =$("#selected_time");
var date_val=$("#date_val").val();
    $.ajax({
    url: "{{url('unavailable-weekType')}}/"+date_val,
    dataType:'json',
    success : function(data){

       $("input:checkbox").prop('checked', false);
       ul.empty();
      jQuery.each(data, function(index, val) {
        $("#times_"+val['time']).prop('checked', true);

ul.append('<li id="time_'+val['time']+'"  style="list-style: none;font-size: 18px;color: #52d862;font-weight: bold;">'+val['name']+'</li>');

      });


    },
    error: function(data){
     ul.empty();
    $("input:checkbox").prop('checked', false);
    }
    });
    return true;
    }


 function holidayPlan() {
  var start_date=$('#datetimepicke3').val();
        var end_date=$('#datetimepicker2').val();
    if (confirm('Are you sure you want to plan your holiday from '+start_date+' till '+end_date+' ? \n Send email to the clients of their canceled appointments.')) {

        if (start_date==''||end_date=='') {
            alert("Sorry!! input was required");
            return false;
        }
    $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    $.ajax({
    url:"{{url('date-range')}}",
    type     : "GET",
    cache    : false,
    dataType : 'json',
    data     : {'start_date': start_date,'end_date':end_date},
     beforeSend: function() {
                   $('#smstext').html("Please wait some few time...");
                },
    success  : function(data){
    if (data.success==true) {
$('#smstext').html("");
alert("Wel Done! Your  holiday plan Make Successfully");


    }else if(data.success==false){
      alert(data.sms);
    }
    },
    error: function(data){

    alert("Sorry!!Have Network Problem");
    $('#smstext').html("");
    }
    });
  }
    return false;
    }
</script>
<script src="{{url('public')}}/js/bootstrap-year-calendar.min.js" type="text/javascript"></script>
<input type="hidden" name="" id="start_date">
<input type="hidden" name="" id="end_date">
<script type="text/javascript">

function convertDatePickerTimeToMySQLTime(str) {
        var month, day, year, hours, minutes, seconds;
        var date = new Date(str),
            month = ("0" + (date.getMonth() + 1)).slice(-2),
            day = ("0" + date.getDate()).slice(-2);
        hours = ("0" + date.getHours()).slice(-2);
        minutes = ("0" + date.getMinutes()).slice(-2);
        seconds = ("0" + date.getSeconds()).slice(-2);

        var mySQLDate = [date.getFullYear(), month, day].join("-");
        var mySQLTime = [hours, minutes, seconds].join(":");
        return [mySQLDate, mySQLTime].join(" ");
    }

$(function() {
    var currentYear = new Date().getFullYear();

    $('#calendar').calendar({
        enableContextMenu: true,
        enableRangeSelection: true,
        displayWeekNumber: true,
        style:'background',
         selectRange: function(e) {

var startDate=convertDatePickerTimeToMySQLTime(e.startDate);
var endDate=convertDatePickerTimeToMySQLTime(e.endDate);
// $('.month tr').css("background-color","#808080");
$("#start_date").val(startDate);
$("#end_date").val(endDate);
$(".strt").html(startDate.substr(0,10)+" To ");
$(".endstr").html(endDate.substr(0,10));
           // alert(e.startDate+"end date"+e.endDate);
            // editEvent({ startDate: e.startDate, endDate: e.endDate });
        },mouseOnDay: function(e) {
            if(e.events.length > 0) {
                var content = '';

                for(var i in e.events) {
                    content += '<div class="event-tooltip-content">'
                        + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                        + '</div>';
                }

                $(e.element).popover({
                    trigger: 'manual',
                    container: 'body',
                    html:true,
                    content: content
                });

                $(e.element).popover('show');
            }
        },
        mouseOutDay: function(e) {
            if(e.events.length > 0) {
                $(e.element).popover('hide');
            }
        },
        dataSource: <?php if(isset($weekcalender)){  $exp=explode('"', $weekcalender); echo $imp=implode(' ', $exp); } ?>
    });

});

function deleteEvent(event) {
    var dataSource = $('#calendar').data('calendar').getDataSource();

    for(var i in dataSource) {
        if(dataSource[i].id == event.id) {
            dataSource.splice(i, 1);
            break;
        }
    }

    $('#calendar').data('calendar').setDataSource(dataSource);
}


function saveWeekType() {

var firsDate= $("#start_date").val();
var endDate= $("#end_date").val();
var week_types= $("#week_types").val();
if (Number(week_types)<0) {
  alert("Please select week Type");
return false;
}
if (firsDate=='' || endDate=='') {
  alert("Please select week date");
return false;
}
 if (confirm('Are you sure you want to submit?')) {
$.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

$.ajax({
    url: "{{url('available-weekType')}}",
    type     : "GET",
    cache    : false,
    dataType : 'json',
    data     : {'firsDate': firsDate,'endDate':endDate,'week_types':week_types},
    success : function(data){
if (data.success==true) {
alert("Week Create Successfully");

 var dataSource = $('#calendar').data('calendar').getDataSource();

    if(data.id) {
        for(var i in dataSource) {
            if(dataSource[i].id == data.id) {
                dataSource[i].name = data.name;
                dataSource[i].startDate = new Date(data.startDate);
                dataSource[i].endDate = new Date(data.endDate);
            }
        }
    }
 $('#calendar').data('calendar').setDataSource(dataSource);

} else {
alert("Sorry!! Week Create Successfully");
}
    }
    });
    return true;

}
}

function changeType() {

var id=$("#week_types").val();
var name=$('#week_types :selected').text();
window.location.href = '{{url('availability/weekType')}}/'+id+'/'+name;
}
</script>


@endsection
