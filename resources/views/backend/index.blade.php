<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>P-Booking</title>

   @include('backend._partials.header')
   <link href="{{url('public')}}/css/app.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
   @include('backend._partials.nav')


        <div id="page-wrapper">
   @include('errors.messages')
   @include('errors.ajaxMsg')
<script type="text/javascript">
    var inactive_msg = $('.inactive-msg');
    var active_msg   = $('.active-msg');
    var active_msg2   = $('.sms-nochange');
    var loading      = $('.loading');
    var info_err     = $('.info-error');
    var info_suc     = $('.info-suc');
    var info_sucInvoice     = $('.info-sucInvoice');
    var delete_msg     = $('.delete-msg');
    var err_delete_msg     = $('.err-delete-msg');
    var db_err     = $('.db-error');</script>
             @yield('content')
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


     @include('backend._partials.footer')
     @include('backend._partials.modal')

</body>

</html>
