@extends('backend.index')
@section('content')
    <style type="text/css">
        .picker-switch {
            background-color: black;
            color: white;
            border-radius: none;
            padding: 0px;
        }

        .prev {
            background-color: black;
            color: white;
            border-radius: none;
            padding: 0px;
        }

        .next {
            background-color: black;
            color: white;
            border-radius: none;
            padding: 0px;
        }

        .picker-switch:hover {
            color: black;
        }

        .prev:hover {
            color: black;
        }

        .next:hover {
            color: black;
        }

        li {
            list-style: none;
            margin-left: 10px !important;
        }

        li:first-child {
            list-style: none;
            margin-left: 0px !important;
        }
    </style>
    <link href="{{url('public')}}/css/app.css" rel="stylesheet">
    <div class="appointments_css">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h3>Make Appointment</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <form role="form" method="post" action="{{url('appointments')}}">
                                    {{csrf_field()}}
                                    <div class="form-group" style="margin-top: -10px;">
                                        <table class="table row">
                                            <tr>
                                                <td class="fixedwith-field">
                                                    {{ Form::select('client_id',$user, null,['class'=>'form-control chosen-select','required']) }}
                                                    {{--  <select class="form-control chosen-select"
                                                        required name="client_id">
                                                        <option value="">Type to search a client</option>
                                                        @foreach($user as $userValue)
                                                        <option value="{{$userValue->id}}">{{$userValue->first_name}} {{$userValue->last_name}}</option>
                                                        @endforeach
                                                    </select> --}}</td>
                                                <td style="" class="fixedwith-field2">
                                                    <a href="#" onclick="loadModalLG('clients/create')"
                                                       data-toggle="modal" data-target="#myModal"
                                                       class="btn btn-sm col-xs-12"
                                                       style="color: white;padding-left: 10px;background-color: #52d862"><i
                                                                class="fa fa-plus" style="padding: 2px"></i> <i
                                                                class="hidden-xs"
                                                                style="padding: 7px;background-color: white;color:black">Add
                                                            new client</i></a>
                                                </td>
                                                <td class="hidden-xs" style="font-weight: bold;font-size: 20px;"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-group row put_right_01 col-md-6" style="margin-top: -10px;">
                                        <select class="form-control  appointment_type"
                                                style="height: 30px;background-color: #f1f1f1;margin-left: 5px;"
                                                required="" onchange="selectAppointmentType()" name="appointment_type"
                                                id="select2">
                                            <option value="">Select type appointment</option>
                                            @foreach($appointment_type as  $appointment_typeValue)
                                                <option value="{{$appointment_typeValue->id}}">
                                                    {{$appointment_typeValue->type_name}}
                                                </option>}
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label style="font-weight: 400;color: black;font-size: 17px;">Select date and
                                            time:</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div id="datetimepicker12"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <ul style="" class="hoursbox">
                                                    <li class='select_available_hour' style="">Select Available hour
                                                    </li>
                                                    @foreach($select_time as $select_timeValue)
                                                        <li style="list-style: none;font-weight: 400;font-size: 15px;margin: 0px;padding: 0px;margin-top: 5px;">
                                                            <div class="radio radio-success radio-circle">
                                                                <input id="times_{{$select_timeValue->id}}" type="radio"
                                                                       name="start_time" class="start_time_id"
                                                                       value="{{$select_timeValue->id}}"
                                                                       onchange="checkAppointment('{{$select_timeValue->id}}')"
                                                                       required="">
                                                                <label for="times_{{$select_timeValue->id}}"
                                                                       id="time_html_{{$select_timeValue->id}}" title=""
                                                                       class="timeLabel">{{$select_timeValue->name}}</label>
                                                            </div>
                                                        </li>
                                                    @endforeach                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox2" type="checkbox" class="recurringToggle"
                                                       name="recurring" value="1">
                                                <label for="checkbox2" style="font-size: 16px;">
                                                    Recurring
                                                </label>
                                            </div>
                                        </div>
                                        <div class="recurringToggle_container hide">
                                            <div class="form-group">
                                                <label style="font-weight: 400;font-size: 15px">Select
                                                    interval: </label>
                                                <div class="radio radio-primary radio-inline">
                                                    <input type="radio" id="inlineRadio1" value="1" name="interval"
                                                           checked="" onclick="checkintreval('1')">
                                                    <label for="inlineRadio1"> daily </label>
                                                </div>
                                                <div class="radio radio-primary radio-inline">
                                                    <input type="radio" id="inlineRadio2" value="2" name="interval"
                                                           onclick="checkintreval('2')">
                                                    <label for="inlineRadio2"> weekly </label>
                                                </div>
                                                <div class="radio radio-primary radio-inline">
                                                    <input type="radio" name="interval" id="radio3" value="3"
                                                           onclick="checkintreval('3')">
                                                    <label for="radio3">
                                                        Monthly
                                                    </label>
                                                </div>
                                                <div class="radio radio-primary radio-inline">
                                                    <input type="radio" name="interval" id="checkbox11" value="4"
                                                           onclick="checkintreval('4')">
                                                    <label for="checkbox11">
                                                        yearly
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="remove_padding">
                                                <div class="form-group">
                                                    <div class=" checkbox-warning checkbox-inline">
                                                        <label for="radio5">
                                                            Every
                                                        </label>
                                                    </div>
                                                    <div class=" checkbox-warning checkbox-inline">
                                                        <input type="text" name="week_note" id="radio6" value=""
                                                               style="width: 30px;">
                                                        <label for="radio6">
                                                            <span class="week_span">daily</span> for
                                                        </label>
                                                    </div>
                                                    <div class=" checkbox-warning checkbox-inline">
                                                        <input type="text" name="week_time" id="radio7" value=""
                                                               style="width: 30px;">
                                                        <label for="radio7">
                                                            times
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn  btn-sm"
                                                style="background-color: #52d862;color: white;font-weight: bold"
                                                id="make_appointment">Make Appointment
                                        </button>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel <--></
                -->
            </div>
            <input type="hidden" name="date_value" id="date_value" value="{{date('Y-m-d')}}">
            <input type="hidden" name="start_times" id="start_times" required="">
            <input type="hidden" name="type_price" id="type_price" required="">
            <input type="hidden" name="type_name" id="type_name" required="">
            <input type="hidden" name="vat_number" id="vat_number" required="">
            <input type="hidden" name="color" id="color">
            </form>
        </div>
    </div>
    <style type="text/css">

    </style>
    {{-- <script src="{{url('public/js')}}/chosen.jquery.js"></script> --}}
    <script type="text/javascript">

        $(function () {

            $('input[type="checkbox"].recurringToggle').click(function () {
                $('.recurringToggle_container').toggleClass('hide');
            });
            $('.chosen-select').select2();
            $('.chosen-select').focus();
            $('#select2').select2();

            checkWeektype();
            $('#datetimepicker12').datetimepicker({
                inline: true,
                sideBySide: true,
                format: 'YYYY-MM-DD',
            }).bind('dp.change', function (e, selectedDate, $td) {
                $('#date_value').val(moment(e.date._d).format("YYYY-MM-DD"));
                checkWeektype();
            });
        });

        function checkWeektype() {
            var date_val = $("#date_value").val();
            $.ajax({
                url: "{{url('availability/weekTypeTimes')}}/" + date_val,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('ul.hoursbox .putinhere').html('');
                    for ($i = 0; $i < data[0].length; $i++) {
                        $('ul.hoursbox .putinhere').append('<li style="list-style: none;font-weight: 400;font-size: 15px;margin: 0px;padding: 0px;margin-top: 5px; padding-left: 15px;"><div class="radio radio-success radio-circle weektype_hours"><li><input id="times_' + $i + '" type="radio" name="start_time" class="start_time_id" value="' + $i + '" onchange="checkAppointment(' + $i + ')" required=""><label for="times_' + $i + '" id="time_html_' + $i + '" title="" class="timeLabel">' + data[0][$i] + '</label></li></div></li>');
                    }
                    if (data[0].length < 1) {
                        $('ul.hoursbox .putinhere').append('<li>Not  a bookable date</li>');
                    }
                    checkAvailavility();
                }
            });
        }

        function checkAvailavility() {
            var date_val = $("#date_value").val();
            $.ajax({
                url: "{{url('unavailable-weekType')}}/" + date_val,
                dataType: 'json',
                success: function (data) {
                    $("input.start_time_id").prop('disabled', false);
                    $("input.start_time_id").prop('checked', false);
                    $(".timeLabel").prop('title', "");
                    $(".timeLabel").css('color', "black");
                    jQuery.each(data, function (index, val) {
                        val['time'] = val['time'] - 1;
                        $("#times_" + val['time']).prop('disabled', true);
                        $("#time_html_" + val['time']).prop('title', "Unavailable time");
                        $("#time_html_" + val['time']).css('color', "red");
                        console.log(val);
                    });
                    checkAvailAviltimes();
                },
                error: function (data) {
                    $("input.start_time_id").prop('disabled', false);
                    $("input.start_time_id").prop('checked', false);
                    $(".timeLabel").css('color', "black");
                    checkAvailAviltimes();
                }
            });
            return true;
        }

        function checkAvailAviltimes() {
            var date_val = $("#date_value").val();
            $.ajax({
                url: "{{url('unavailavail-check-date')}}/" + date_val + "/date",
                dataType: 'json',
                success: function (data) {
                    jQuery.each(data, function (index, val) {
                        $("#times_" + val).prop('disabled', true);
                        $("#time_html_" + val).prop('title', "This time have booked");
                        $("#time_html_" + val).css('color', "green");
                        console.log(val);
                    });
                },
                error: function (data) {
                }
            });
            return true;
        }

        checkAvailavility();
        //     function checkAvailavility() {
        // var days=$("#date_value").val();
        // if (days==null) {
        // alert('Warning!Blank Field must be required.');
        // return false;
        // }
        // $.ajaxSetup({
        // headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        // });
        // $.ajax({
        // url:"{{url('appointments-available-check')}}",
        // type     : "GET",
        // cache    : false,
        // dataType : 'json',
        // data     : {'days': days},
        // success  : function(data){
        // if (data.success==true) {
        //     alert("This Date Unavailable");
        // }else if(data.success==false){
        // }
        // },
        // error: function(data){
        // }
        // });
        // return false;
        // }
        function checkAppointment(id) {
            var days = $("#date_value").val();
            var startTime = $("#time_html_" + id).html();
            $("#start_times").val(startTime);
            if (days == null) {
                alert('Warning!Blank Field must be required.');
                return false;
            }
            $.ajaxSetup({
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
            });
            $.ajax({
                url: "{{url('appointments-times-check')}}",
                type: "GET",
                cache: false,
                dataType: 'json',
                data: {'days': days, 'id': id},
                success: function (data) {
                    if (data.success == true) {
                        alert("Already Booking");
                        $('#make_appointment').prop("disabled", true);
                    } else if (data.success == false) {
                        $('#make_appointment').prop("disabled", false);
                    }
                },
                error: function (data) {
                }
            });
            return false;
        }

        function selectAppointmentType() {
            var id = $(".appointment_type").val();
            $.ajax({
                url: "{{url('appointment-types')}}/" + id + "/select",
                dataType: 'json',
                success: function (data) {
                    // $('.price').html(data.amount);
                    $('#type_price').val(data.amount);
                    $('#type_name').val(data.type_name);
                    $('#vat_number').val(data.vat_number);
                    $('#color').val(data.color);
                }
            });
            return true;
        }

        function checkintreval(id) {
            if (id == 1) {
                $(".week_span").html("daily");
            } else if (id == 2) {
                $(".week_span").html("weekly");
            }
            else if (id == 3) {
                $(".week_span").html("monthly");
            } else if (id == 4) {
                $(".week_span").html("yearly");
            }
        }
    </script>
@endsection