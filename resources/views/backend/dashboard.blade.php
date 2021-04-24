@extends('backend.index')
@section('content')
    <style type="text/css">
        .fc-center h2 {
            display: none;
        }

        #custom-search-input {
            padding: 2px;
            border: solid 1px #E4E4E4;
            background-color: #f3f3f3;
            height: 29px;
        }

        #custom-search-input input {
            border: 0;
            box-shadow: none;
        }

        #custom-search-input button {
            margin: 2px 0 0 0;
            background: none;
            box-shadow: none;
            border: 0;
            color: #666666;
            padding: 0 7px 0 10px;
            border-left: solid 1px #ccc;
        }

        #custom-search-input button:hover {
            border: 0;
            box-shadow: none;
            border-left: solid 1px #ccc;
        }

        #custom-search-input .glyphicon-search {
            font-size: 20px;
        }

        .search-input {
            height: 22px;
            background-color: #f3f3f3;
        }

        .search-input:focus {
            outline: none;
        }

        #checkboxType {
            background-color: #f3f3f3;
        }

        .btn span.glyphicon {
            opacity: 0;
        }

        .btn.active span.glyphicon {
            opacity: 1;
        }

        .bg-custom {
            background-color: #5fbeaa !important;
        }

        .bg-primary {
            background-color: #5d9cec !important;
        }

        .bg-success {
            background-color: #81c868 !important;
        }

        .bg-info {
            background-color: #34d3eb !important;
        }

        .bg-warning {
            background-color: #ffbd4a !important;
        }

        .bg-danger {
            background-color: #f05050 !important;
        }

        .bg-muted {
            background-color: #f4f8fb !important;
        }

        .bg-inverse {
            background-color: #4c5667 !important;
        }

        .bg-purple {
            background-color: #7266ba !important;
        }

        .bg-pink {
            background-color: #fb6d9d !important;
        }

        .bg-white {
            background-color: #ffffff !important;
        }

        .bg-lightdark {
            background-color: #f4f8fb !important;
        }

        /* Text colors */
        .text-custom {
            color: #5fbeaa;
        }

        .text-white {
            color: #ffffff;
        }

        .text-danger {
            color: #f05050;
        }

        .text-muted {
            color: #98a6ad;
        }

        .text-primary {
            color: #5d9cec;
        }

        .text-warning {
            color: #ffbd4a;
        }

        .text-success {
            color: #81c868;
        }

        .text-info {
            color: #34d3eb;
        }

        .text-inverse {
            color: #4c5667;
        }

        .text-pink {
            color: #fb6d9d;
        }

        .text-purple {
            color: #7266ba;
        }

        .text-green {
            color: #69f368;
            font-size: 22px;
        }

        .text-dark {
            color: #000000 !important;
        }

        #inputes {
            height: 30px;
            background-color: #f3f3f3;
        }

        #make_table tr {
            height: 35px;
        }

        #make_table tr td {
            font-weight: 400;
            font-size: 16px;
            color: #000
        }

        .or {
            font-size: 30px;
            text-align: center;
        }

    </style>

    <link href="{{url('public')}}/css/app.css" rel="stylesheet">
    <div class="row">

        <div class="col-lg-12">
            <h1 class="page-header" style="font-weight: 400;font-size: 23px;">Appoinments</h1>
            <span class="title-types" style="font-size: 15px;font-weight: bold;color: #000;letter-spacing: 1px;"></span>
            <span class="title-days"
                  style="font-size: 15px;font-weight: bold;color: #000;letter-spacing: 1px;"></span><span
                    class="title-calenders"
                    style="font-size: 15px;font-weight: bold;color: #000;letter-spacing: 1px;"></span>
            <span class="title-currents" style="font-size: 15px;font-weight: 400;padding-left: 10px;color: #000">Current month</span>
            <span class="" style="font-size: 15px;font-weight: 400;padding-left: 10px;color: #000"> <b
                        id="countBooking">{{count($monthBooking)}}</b> appointments</span>
        </div>
        <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">

            <div class="row">

                <div class="col-md-12">
                    <div class="card-box">
                        <div id="calendar"></div>
                    </div>
                </div> <!-- end col -->
            </div>  <!-- end row -->

            <!-- BEGIN MODAL -->


            <!-- Modal Add Category -->
            <!-- BEGIN MODAL -->
            <div class="modal fade none-border" id="event-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-style: hidden;">
                            <button id="closeButton" type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                    style=""><i class="fa fa-close" style="font-size: 26px"></i></button>
                            <h4 class="modal-title">Make appointment for</h4>
                        </div>
                        <div class="modal-body">


                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button> -->
                            {{-- <button type="button" class="btn btn-success save-event waves-effect waves-light" id="create_event"></button>
                            <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button> --}}
                        </div>
                    </div>
                </div>
            </div>


            <!-- END MODAL -->
            <!-- END MODAL -->
        </div>
        <!-- end col-12 -->
    </div> <!-- end row -->
    <!-- /.row -->
    <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-plus" style="font-weight: bold;"></i> <span style="padding: 5px;background-color: white;color: black">Add Appointments</span></a> -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" id="model_body">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">Appointment
                    </h4>


                </div>
                {!! Form::open(['url'=>URL::to('edit.personalAppointment'),'id'=>'myForm']) !!}
                <div class="modal-body" id="body-model">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <button class="btn btn-sm editPersonalApp"
                            style="color: white;padding-left: 10px;background-color: #52d862" type="button"><i class=""
                                                                                                               style="padding: 4px;background-color: white;color:black">Comfirm
                            change</i><i class="fa  fa-check" style="padding: 2px 6px"></i></button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
    <button data-toggle="modal" data-target="#myModal" style="display:none;" type="button" id="editButton"></button>
@section('js')
    <script type="text/javascript">


        function getDateIfDate(d) {
            var m = d.match(/\/Date\((\d+)\)\//);
            return m ? (new Date(+m[1])).toLocaleDateString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }) : d;
        }


        !function ($) {
            "use strict";

            var CalendarApp = function () {
                this.$body = $("body")
                this.$modal = $('#event-modal'),
                    this.$event = ('#external-events div.external-event'),
                    this.$calendar = $('#calendar'),
                    this.$saveCategoryBtn = $('.save-category'),
                    this.$categoryForm = $('#add-category form'),
                    this.$extEvents = $('#external-events'),
                    this.$calendarObj = null
            };


            /* on drop */
            CalendarApp.prototype.onDrop = function (eventObj, date) {
                var $this = this;
                // retrieve the dropped element's stored Event Object
                var originalEventObject = eventObj.data('eventObject');
                var $categoryClass = eventObj.attr('data-class');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;
                if ($categoryClass)
                    copiedEventObject['className'] = [$categoryClass];
                // render the event on the calendar
                $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    eventObj.remove();
                }
            },
                /* on click on event */
                CalendarApp.prototype.onEventClick = function (calEvent, jsEvent, view) {
                    var $this = this;
                    $(".modal-title").html(calEvent.title);
                    $(".divNew").hide();

                    selectApp(calEvent.className);
                    $(".appDiv").remove();
                    $(".modal-body").append("<div class='row appDiv'><div class='col-md-12' style='margin-top:-10px;'><h4><span class='text-green timeClass'> </span> I <span class='text-dark dateDiv'></span></h4></div><div class='col-md-12'><h4><span class='text-dark appType'> </span> - <span class=' isPaid' style='color:red'></span></h4></div><div class='col-md-12'>  <a href='#' style='color:black' class='appEdit'><i class='fa fa-pencil' style='font-size:17px;'></i></a> <a href='#' style='color:black' class='personalEdit'><i class='fa fa-pencil' style='font-size:17px;'></i></a>&nbsp;&nbsp;&nbsp; <a href=''  style='color:black' class='appSend' onclick=''><i class='fa fa-clock-o' style='font-size:17px;'></i></a>   &nbsp;&nbsp;&nbsp; <a href='{{url('appointments')}}//details' style='color:black' class='order-details'><i class='fa fa-shopping-basket' style='font-size:17px;'></i></a> &nbsp;&nbsp;&nbsp;<a href='#' style='color:red;text-decoration: none;' class='appcancel' onclick=''><i class='fa fa-close' style='font-size:17px;'></i> Cancel</a></div></</div>");

                    $this.$modal.modal({
                        backdrop: 'static'
                    });

                    $('.appcancel').click(function () {
                        $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                            return (ev._id == calEvent._id);
                        });
                        $this.$modal.modal('hide');
                    });

                },
                /* on select */
                CalendarApp.prototype.onSelect = function (date, start, end, allDay) {
                    var $this = this;
                    $this.$modal.modal({
                        backdrop: 'static'
                    });

                    var newDate = date.format();
                    var sp = newDate.split('T');
                    if (sp[1] == null) {
                        var dt = new Date();
                    } else {
                        var dt = new Date(newDate);
                    }

                    var time = dt.getHours() + ": 00";
                    var date = new Date();
                    var d = date.getDate();
                    var m = date.getMonth();
                    var y = date.getFullYear();
                    var form = '';
                    var today = new Date($.now());

                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    var condate = getDateIfDate("/Date(" + start + ")/");
                    var ds = condate.slice(0, 10).split('/');
                    var dates = ds[2] + '-' + ds[0] + '-' + ds[1];

                    var d = new Date("2017-10-11 09:00:00");
                    var day = d.getDay();
                    var month = monthNames[d.getMonth()];

                    var year = d.getYear();
                    var hour = d.getHours();
                    var min = d.getMinutes();
                    var yea = d.getFullYear();

                    var fullDatetime = day + ' ' + month + ', ' + yea;

                    var d1 = new Date(),
                        d2 = new Date(d1);
                    d2.setHours(dt.getHours() + 1);

                    var endtime = d2.getHours() + ":00"
                    //$('#create_event').remove();
                    $(".modal-title").html("Make an Appointments");
                    var form = $("<form ></form>");
                    form.append("<div class='row divNew'></div>");
                    form.find(".row")
                        .append("<div class='col-md-12'><h4><span class='text-green '><input type='text' value='" + time + "' style='width:100px;' name='start_time'  class='start_times_app'> </span>- <span class='text-green '><input type='text' value='" + endtime + "' style='width:100px;' name='end_time'  id='end_times'> </span> I <span class='text-dark'><input type='hidden' name='date' id='app_date' value='" + dates + "' > " + dates + "</span></h4></div><div class='col-md-3'><a href='{{url("appointments/create/new")}}' class='btn btn-success btn-sm'><i class='fa fa-plus' style='font-weight: bold;'></i> <span style='padding: 5px;background-color: white;color: black'>Add Appointments</span></a></div><div class='col-md-2' style='text-align: center;'><b class='or'>OR </b></div><div class='col-md-7'><table id='make_table'><tr><td>Name :</td><td><input type='text' id='inputes' class='name_in' name='title'></td></tr><tr><td>Location :</td><td><input type='text' id='inputes' class='location' name='location'><input type='hidden' id='last_id' class='' name='last_id'></td></tr><tr><td colspan='2'><button type='button' class='btn btn-success btn-sm button' ><i class='fa fa-plus' style='font-weight: bold;'></i> <span style='padding: 5px;background-color: white;color: black'>Personal Appointments</span></button></td></tr></table></div>");
                    // <div class='col-md-6'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>
                    // .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>")
                    // .find("select[name='category']")
                    // .append("<option value='bg-danger'>Danger</option>")
                    // .append("<option value='bg-success'>Success</option>")
                    // .append("<option value='bg-purple'>Purple</option>")
                    // .append("<option value='bg-primary'>Primary</option>")
                    // .append("<option value='bg-pink'>Pink</option>")
                    // .append("<option value='bg-info'>Info</option>")
                    // .append("<option value='bg-warning'>Warning</option></div></div>");
                    $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                        form.submit();
                    });
                    $('.button').on('click', function () {
                        var start_timee = form.find("input[name='start_time']").val();
                        var end_timee = form.find("input[name='end_time']").val();
                        var srch = form.find("input[name='title']").val();
                        var title = srch + ': ' + start_timee + '-' + end_timee;

                        var start_time = $('input.start_times_app').val();
                        var end_time = $('#end_times').val();
                        var app_date = $('#app_date').val();
                        var name_in = $('.name_in').val();
                        var location = $('.location').val();
                        if (start_time == '' || end_time == '' || app_date == '' || name_in == '' || location == '') {
                            alert("Sorry!! input was required");
                            return false;
                        }
                        $.ajaxSetup({
                            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                        });
                        $.ajax({
                            url: "{{url('appointments-personal')}}",
                            type: "GET",
                            cache: false,
                            dataType: 'json',
                            data: {
                                'start_time': start_time,
                                'end_time': end_time,
                                'app_date': app_date,
                                'name_in': name_in,
                                'location': location
                            },

                            success: function (data) {
                                if (data.success == true) {
                                    // alert("Wel Done! Personal Appointment Make Successfully");
                                    console.log(data);
                                    var categoryClass = data.appId;


                                    if (title !== null && title.length != 0 && categoryClass !== null) {
                                        $this.$calendarObj.fullCalendar('renderEvent', {
                                            title: title,
                                            start: start,
                                            end: end,
                                            allDay: false,

                                            className: data.appId

                                        }, true);
                                        $this.$modal.modal('hide');
                                    }
                                    else {

                                    }
                                } else if (data.success == false) {
                                }
                            },
                            error: function (data) {


                            }
                        });

                        // var beginning = form.find("input[name='beginning']").val();
                        // var ending = form.find("input[name='ending']").val();

                        return false;

                    });
                    $this.$calendarObj.fullCalendar('unselect');


                },
                CalendarApp.prototype.enableDrag = function () {
                    //init events
                    $(this.$event).each(function () {
                        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                        // it doesn't need to have a start or end
                        var eventObject = {
                            title: $.trim($(this).text()) // use the element's text as the event title
                        };
                        console.log(eventObject);
                        // store the Event Object in the DOM element so we can get to it later
                        $(this).data('eventObject', eventObject);
                        // make the event draggable using jQuery UI
                        $(this).draggable({
                            zIndex: 999,
                            revert: false,      // will cause the event to go back to its
                            revertDuration: 0  //  original position after the drag
                        });
                    });
                }
            /* Initializing */
            CalendarApp.prototype.init = function () {
                this.enableDrag();
                /*  Initialize the calendar  */
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var form = '';
                var today = new Date($.now());
                var defaultEvents =<?php if (isset($calender)) {
                    echo $calender;
                } else {
                    echo '';
                } ?>;

                var $this = this;
                $this.$calendarObj = $this.$calendar.fullCalendar({
                    slotDuration: '01:00:00', /* If we want to split  each 15minutes */
                    minTime: '01:00:00',
                    maxTime: '24:00:00',
                    defaultView: 'month',

                    handleWindowResize: true,
                    height: $(window).height() - 100,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    events: defaultEvents,
                    axisFormat: 'HH:mm',
                    timeFormat: {
                        agenda: 'HH:mm'
                    },
                    editable: true,
                    droppable: true, // this allows things to be dropped onto the calendar !!!
                    eventLimit: true, // allow "more" link when too many events
                    selectable: true,
                    drop: function (date) {
                        $this.onDrop($(this), date);
                    },
                    select: function (start, end, allDay) {
                        $this.onSelect(start, end, allDay);
                    },
                    eventClick: function (calEvent, jsEvent, view) {
                        $this.onEventClick(calEvent, jsEvent, view);
                    }

                });
                $(".fc-left").append('<a href="{{url('appointments/create/new')}}" class="btn btn-success btn-sm"><i class="fa fa-plus" style="font-weight: bold;"></i> <span style="padding: 5px;background-color: white;color: black">Add Appointments</span></a> ');
                $(".fc-left").append('<form action="{{url('seacrh_appointment')}}" method="get" accept-charset="utf-8"><div id="custom-search-input"><div class="fc-button-group"><input type="text" name="search" class="search-input" placeholder="  search.." /><span class="input-group-btn"><button class="btn btn-info btn-sm" type="submit"><i class="glyphicon glyphicon-search"></i></button></span></div></div></form>');

                var title_calenderss = $(".fc-center h2").html();
                $(".title-calenders").html(title_calenderss);

                $('.fc-month-button').click(function () {
                    var title_calenderss = $(".fc-center h2").html();
                    $(".title-calenders").html(title_calenderss);
                    $(".title-types").html(" ");
                    $(".title-currents").html("Current month ");
                    $(".title-days").html("");
//$(".type_week").html("Month");

                });

                $('.fc-prev-button').click(function () {
                    var title_calenderss = $(".fc-center h2").html();
                    $(".title-calenders").html(title_calenderss);
                    $(".title-types").html(" ");
                    $(".title-currents").html("Current month ");
                    $(".title-days").html("");
//$(".type_week").html("Month");
                    selectAppointmentCount(title_calenderss);
                });
                $('.fc-next-button').click(function () {
                    var title_calenderss = $(".fc-center h2").html();
                    $(".title-calenders").html(title_calenderss);
                    $(".title-types").html(" ");
                    $(".title-currents").html("Current month ");
                    $(".title-days").html("");
//$(".type_week").html("Month");
                    selectAppointmentCount(title_calenderss);
                });

                $('.fc-agendaWeek-button').click(function () {
                    var title_calenderss = $(".fc-center h2").html();
                    $(".title-calenders").html(title_calenderss);
                    $(".title-types").html("week of ");
                    $(".title-currents").html("Current week ");
                    $(".title-days").html("");
//$(".type_week").html("Week");

                });
                $('.fc-agendaDay-button').click(function () {
                    var title_calenderss = $(".fc-center h2").html();
                    $(".title-calenders").html(title_calenderss);
                    $(".title-types").html("Day of ");
                    $(".title-currents").html("Current day ");
                    var day = $(".fc-day-header").html();
                    $(".title-days").html(day);
//$(".type_week").html("Day");


                });

                $('<div class="col-md-12">@if(isset($appointment_type)) @foreach($appointment_type as $appointment_typevalue)<div class="checkbox-inline" ><input @if(isset($id))  @if($id==$appointment_typevalue->id) checked="true" @else @endif @else @endif type="checkbox"  id="inlineRadio{{$appointment_typevalue->id}}" value="option1" name="radioInline" style="display:none" class="checkbox_checkapp" onclick="checkAppType({{$appointment_typevalue->id}})" data-id="{{$appointment_typevalue->id}}" ><label for="inlineRadio{{$appointment_typevalue->id}}" style="cursor: pointer;"><b style="padding:2px 15px 1px 2px;cursor: pointer;background-color:{{$appointment_typevalue->color}}" class=""></b> <b style="padding-left:2px;">{{$appointment_typevalue->type_name}}</b>  </label><input type="hidden" value="' + title_calenderss + '" id="month_Name"></div>@endforeach @endif</div>').insertAfter(".fc-toolbar");
                $("<div class=''> <lable for='checkboxType'><span class='type_week'></span>  </lable></div><br>").insertAfter("#custom-search-input");

                // $('.fc-right').remove();
                //on new event
                this.$saveCategoryBtn.on('click', function () {
                    var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
                    var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                    if (categoryName !== null && categoryName.length != 0) {
                        $this.$extEvents.append('<div class="external-event bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-move"></i>' + categoryName + '</div>')
                        $this.enableDrag();
                    }

                });
            },

                //init CalendarApp
                $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

        }(window.jQuery),

//initializing CalendarApp
            function ($) {
                "use strict";
                $.CalendarApp.init()
            }(window.jQuery);

        function checkAppType(id) {

            var month = $("#month_Name").val();

            if ($('#inlineRadio' + id).is(':checked')) {
                window.location.href = '{{url('appointments-type-acc')}}/' + id + '/find/' + month;
            } else {
                window.location.href = '{{url('dashboard')}}';


            }
        }


        function selectApp(id) {
            $.ajaxSetup({
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
            });

            $.ajax({
                url: "{{url('appointments-check-calender')}}",
                type: "GET",
                cache: false,
                dataType: 'json',
                data: {'id': id},

                success: function (data) {
                    if (data.success == true) {

                        $(".modal-title").html(data.user_name);
                        $(".timeClass").html(data.times);
                        $(".dateDiv").html(data.date);
                        $(".appType").html(data.type);
                        $(".isPaid").html(data.is_paid);
                        if (Number(data.is_order) > 0) {
                            $('.order-details').hide();
                        } else {
                            $('.order-details').show();
                            $(".order-details").prop('href', '{{url('appointments/')}}/' + data.app_id + '/details');
                        }

                        if (data.order_id > 0) {
                            $('.order-details').hide();
                        }

                        if (data.is_paid == 'PAID') {
                            $('.order-details').hide();
                        }

                        $('.personalEdit').hide();
                        $(".appEdit").prop('href', '{{url('appointments/')}}/' + data.app_id + '/edit');
                        $(".appcancel").prop('href', '{{url('appointments/')}}/' + data.app_id + '/cencel');
                        $(".appSend").prop('href', 'javascript:void()');

                        $(".appSend").attr('onclick', 'sendReminder(' + data.app_id + ')');

                        if (data.is_parsonal == 1) {
                            $('.order-details').hide();
                            $('.appEdit').hide();
                            $('.personalEdit').show();
                            $('.appSend').hide();
                            $('.isPaid').html(" ");
                            $(".appcancel").prop('href', 'javascript:void()');
                            $(".appcancel").attr('onclick', 'appCancel(' + data.app_id + ')');
                            $(".appSend").prop('onclick', 'javascript:void()');
                            $(".personalEdit").attr('onclick', 'editApp(' + data.app_id + ')');
                        }
                    } else if (data.success == false) {

                    }
                },
                error: function (data) {


                }
            });
            return false;
        }

        function appCancel(id) {
            if (confirm('Are you sure you want to cancel Appointment?')) {
                $.ajax({
                    url: "{{url('appointment-cancel-personal')}}/" + id,
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == true) {
                            alert("Personal Appointment Cancel Successfully");

                        } else {
                            alert("Personal Appointment Cancel Unsuccessfully");

                        }
                    }
                });
                return true;
            } else {


            }


        }

        function editApp(id) {
            $.ajax({
                url: "{{url('appointment')}}/" + id + "/select",
                dataType: 'json',
                success: function (data) {

                    $("#closeButton").click();
                    $(".modal-title").html("Edit an Appointments");
                    $("#editButton").click();
                    $(".modal-body").html(" ");
                    $("#body-model").html("<div class='col-md-12'><h4><span class='text-green '><input type='text' value='" + data.start_time + "' style='width:100px;' name='start_time1'  class='start_times_app1'> </span>- <span class='text-green '><input type='text' value='" + data.end_time + "' style='width:100px;' name='end_time1'  id='end_times1'> </span> I <span class='text-dark'><input type='hidden' name='date' id='app_date1' value='" + data.date + "' > " + data.date + "</span></h4></div><div class='col-md-3'><a href='{{url("appointments/create/new")}}' class='btn btn-success btn-sm'><i class='fa fa-plus' style='font-weight: bold;'></i> <span style='padding: 5px;background-color: white;color: black'>Add Appointments</span></a></div><div class='col-md-2' style='text-align: center;'><b class='or'>OR </b></div><div class='col-md-7'><table id='make_table'><tr><td>Name :</td><td><input type='text' id='inputes' class='name_in1' name='title1' value='" + data.name + "'></td></tr><tr><td>Location :</td><td><input type='text' id='inputes' class='location1' name='location1' value='" + data.location + "'><input type='hidden' id='edit_id1' class='edit_id' name='edit_id' value='" + data.appointment_id + "'></td></tr><tr><td colspan='2'></td></tr></table></div>");

                }
            });
            return true;
        }


        $('.editPersonalApp').on('click', function () {

            $.ajaxSetup({
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
            });

            var start_timee = $("input[name='start_time1']").val();
            var end_timee = $("input[name='end_time1']").val();
            var srch = $("input[name='title1']").val();
            var title = srch + ': ' + start_timee + '-' + end_timee;

            var start_time = $("input[name='start_time1']").val();
            var end_time = $("input[name='end_time1']").val();
            var app_date = $('#app_date1').val();
            var name_in = $('.name_in1').val();
            var location = $('.location1').val();
            var edit_id = $('.edit_id').val();

            if (start_time == '' || end_time == '' || app_date == '' || name_in == '' || location == '' || edit_id == '') {
                alert("Sorry!! input was required");
                return false;
            }


            $.ajax({
                url: "{{url('edit.personalAppointment')}}",
                type: "GET",
                cache: false,
                dataType: 'json',
                data: {
                    'start_time': start_time,
                    'end_time': end_time,
                    'app_date': app_date,
                    'name_in': name_in,
                    'location': location,
                    'edit_id': edit_id
                },

                success: function (data) {
                    if (data.success == true) {
                        alert("Wel Done! Personal Appointment Edit Successfully");

                    } else if (data.success == false) {
                    }
                },
                error: function (data) {


                }
            });

            // var beginning = form.find("input[name='beginning']").val();
            // var ending = form.find("input[name='ending']").val();

            return false;

        });


        function makeAnPersonalAppointment() {

            var start_time = $('input.start_times_app').val();
            var end_time = $('#end_times').val();
            var app_date = $('#app_date').val();
            var name_in = $('.name_in').val();
            var location = $('.location').val();


            if (start_time == '' || end_time == '' || app_date == '' || name_in == '' || location == '') {
                alert("Sorry!! input was required");
                return false;
            }
            $.ajaxSetup({
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
            });

            $.ajax({
                url: "{{url('appointments-personal')}}",
                type: "GET",
                cache: false,
                dataType: 'json',
                data: {
                    'start_time': start_time,
                    'end_time': end_time,
                    'app_date': app_date,
                    'name_in': name_in,
                    'location': location
                },

                success: function (data) {
                    if (data.success == true) {

                        alert("Wel Done! Personal Appointment Make Successfully");

                        location.reload();
                    } else if (data.success == false) {

                    }
                },
                error: function (data) {


                }
            });
            return false;
        }

        function selectAppointmentCount(date) {

            $.ajax({
                url: "{{url('appointment-Select-Month')}}/" + date,
                dataType: 'json',
                success: function (data) {

                    $('#countBooking').html(data.count);

                    // $('#type_price').val(data.amount);
                    // $('#type_name').val(data.type_name);
                    // $('#vat_number').val(data.vat_number);
                }
            });
            return true;
        }


        function sendReminder(id) {
            $.ajax({
                url: "{{url('appointment-send')}}/" + id + "/reminder",
                dataType: 'json',
                beforeSend: function () {
                    $('#msg').html("wait....");
                },
                success: function (data) {
                    if (data.success == true) {
                        alert("Send Reminder Successfully")
                    } else {
                        alert("opps!! have network problem")
                    }

                },
                error: function (data) {


                }
            });
            return true;
        }


    </script>

@endsection
@endsection
