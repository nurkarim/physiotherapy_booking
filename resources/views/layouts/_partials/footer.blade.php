
    <script src="{{ asset('public/vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{url('public/js/moment.js')}}"></script>
<script src="{{url('public/js/bootstrap-datetimepicker.min.js')}}"></script>
{{--     			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script> --}}

    			  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript">
	var inactive_msg = $('.inactive-msg');
    var active_msg   = $('.active-msg');
    var active_msg2   = $('.sms-nochange');
    var loading      = $('.loading');
    var info_err     = $('.info-error');
    var info_suc     = $('.info-suc');
    var app_suc     = $('.app-suc');
    var delete_msg     = $('.delete-msg');
    var err_delete_msg     = $('.err-delete-msg');
    var db_err     = $('.sms-nochange');
    var info_suc_dynamic     = $('.info-suc-dynamic');
    var info_update_dynamic  = $('.info-update-dynamic');
</script>
   @yield('js') 

