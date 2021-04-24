@extends('backend.index')
@section('content')
    <style type="text/css">
        table th {
            font-weight: 400;
            font-size: 12px;
            letter-spacing: 1px;
        }

        table tr td {
            font-weight: 400;
            font-size: 12px;
            letter-spacing: 1px;
            color: black
        }
    </style>
    <link href="{{url('public')}}/css/app.css" rel="stylesheet">
    <div class="applist_container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6"><h3 class="">Appointment List</h3></div>
            </div>
            <!-- 	<div class="col-md-12">
                    <div class="col-md-2">
                        <select class="form-control " style="clear: right;">
                            <option>Bulk Action</option>
                        </select>
                    </div>
                        <div class="">
                            <button class="btn btn-default">Applly</button>

                        </div>

                </div> -->
            <div class="col-md-12" style="height: 10px;"></div>
            <div class="col-md-12 actions">
                <select name="getAppointments" class="form-control input-sm" id="getAppointments">
                    <option value="0">Actions</option>
                    <option value="1">Delete</option>
                </select>
                selected items.
                <a href="#" class="apply button apply-button">Apply action</a>
                <br>
            </div>
            <div class="col-md-12">
                <div class="errors-cancel messagebox hide error"></div>
                <div class="success-cancel messagebox hide success"></div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered tablesorter" style="width:100%" id="dataTables-example">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Booked by</th>
                            <th>Starting Date</th>
                            <th>End Date</th>
                            <th>Booked Appointment</th>
                            <!-- <th>App Status</th> -->
                            <th>Order</th>
                            <th>Status</th>
                            <th title="Payment Reminder Status">P-R-Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $dataValue)
                            <tr class="one_{{$dataValue->id}}">
                                <td><input id='one_{{$dataValue->id}}' type='checkbox' name="{{$dataValue->id}}"/>
                                    <label for='one_{{$dataValue->id}}'>
                                        <span></span>

                                    </label></td>


                                <td>{{$dataValue->appointmentID}}</td>
                                <td style="color: #2bd851;font-size: 13px;"><a
                                            href="{{url('clients/details')}}/{{$dataValue->user_id}}">{{$dataValue->first_name}}</a>
                                </td>
                                <td><?php echo date("F d, Y", strtotime($dataValue->bookingDate)); ?> {{$dataValue->start_time}}</td>
                                <td><?php echo date("F d, Y", strtotime($dataValue->bookingDate)); ?> {{$dataValue->end_time}}</td>
                                <td>{{$dataValue->appointment_type}}</td>
<!--
                                <td>    @if($dataValue->is_cancel==2)
                                        <span style="color: red">Cancel</span>
                                    @elseif($dataValue->is_cancel==3)
                                        <span>Complete</span>
                                    @else
                                        <span>New</span>


                                    @endif</td> -->
                                <td>@if(@$dataValue->orderId>0)<a
                                            href="{{url('orders')}}/{{$dataValue->orderId}}/details">#{{$dataValue->orderId}}</a>@else
                                        <a href="{{url('orders')}}/{{$dataValue->order_id}}/details">#{{$dataValue->order_id}} @endif
                                </td>
                                <td>
                                    @if($dataValue->is_paid==1)
                                        <span>Paid</span>
                                    @else
                                        <span>UnPaid</span>


                                    @endif
                                </td>
                                <td>            @if($dataValue->appStatus==1)
                                        <span>Unsent</span>
                                    @else
                                        <span>Sent</span>


                                    @endif</td>
                                <td>
                                    @if($dataValue->is_order==1)
                                    @elseif($dataValue->order_id>0)
                                    @else
                                        <a class="btn btn-xs btn-default"
                                           href="{{url('appointments')}}/{{$dataValue->id}}/details"><i
                                                    class="fa fa-cart-arrow-down"></i></a>
                                    @endif
                                    @if($dataValue->is_paid==1)

                                    @else
                                        <a class="btn btn-xs btn-default" href="#"><i class="fa  fa-clock-o "></i></a>

                                    @endif
                                    <a class="btn btn-xs btn-default"
                                       href="{{url('appointments')}}/{{$dataValue->id}}/details"><i
                                                class="fa fa-search"></i></a>
                                    @if($dataValue->invoiceId=="")

                                    @else

                                        <a class="btn btn-xs btn-danger" target="_blank"
                                           href="{{url('invoices')}}/{{$dataValue->invoiceId}}/pdf"><i
                                                    class="fa fa-file-pdf-o"></i></a>
                                    @endif
                                    <a style="" href="{{url('appointments')}}/{{$dataValue->id}}/cencel"
                                       class="btn btn-danger btn-xs"
                                       onclick="return confirm('Are you sure want to cancel appointment?')"><i
                                                class="fa fa-close"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true,
                "ordering": true,

            });
            $("#select_all").change(function(){  //"select all" change
                var status = this.checked; // "select all" checked status
                $('.checkbox').each(function(){ //iterate all listed checkbox items
                    this.checked = status; //change ".checkbox" checked status
                });
            });
            $('.apply-button').click(function () {
                var selected = $('#getAppointments :selected').val();

                if (selected == 1) {
                    var allIds = [];
                    $('input:checked').each(function () {
                        allIds.push($(this).attr("name"));
                    });

                    $.ajax({
                        url: "{{url('appointments')}}/cancel",
                        method: 'POST', // Type of response and matches what we said in the route
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {id: allIds},
                        success: function (response) { // What to do if we succeed
                            var success = response['success'];
                            var error = response['error'];
                            var length = success.length;
                            var length2 = success.length;
                            if (length > 0) {
                                $('.success-cancel').removeClass('hide');
                            }

                            if (length2 > 0) {
                                $('.error-cancel').removeClass('hide');
                            }
                            for (i = 0; i < length; i++) {
                                $('.success-cancel').append(success[i] + '<br>');
                            }

                            for (i = 0; i < response['response'].length; i++) {
                                $('tr.one_' + response['response'][i]).hide();
                            }

                        },
                        error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                            console.log(JSON.stringify(jqXHR));
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                }
            });

        });
    </script>
@endsection
