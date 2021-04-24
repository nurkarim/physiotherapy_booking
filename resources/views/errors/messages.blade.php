@if(Session::has('flash_success'))
	<div class="alert alert-success {{ Session::has('flash_msg_important') ? 'alert-important' : '' }}"> 
		@if(Session::has('flash_msg_important'))
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		@endif
		{{ Session('flash_success') }} 
	</div>
@endif

@if(Session::has('flash_error'))
	<div class="alert  alert-warning alert-dismissable {{ Session::has('flash_msg_important') ? 'alert-important' : '' }}"> 
		@if(Session::has('flash_msg_important'))
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		@endif
		<strong>Warning!</strong> 
		{{ Session('flash_error') }} 
	</div>
@endif



 @if (count($errors) > 0)
	<div class="error" style="margin-top: 10px;">
		<ul class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			 @foreach ($errors->all() as $error)
                <li style="list-style: none;font-size: 15px;padding: 5px 10px;">{{ $error }}</li>
             @endforeach
		</ul>
	</div>
 @endif

 
 @if (session('success'))
<div class="alert alert-success info-succc" >
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Well done!</strong> &nbsp;{{session('success')}}<br><br>
</div>
 @endif
  @if (session('error'))
<div class="alert alert-danger info-errors" >
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>oops!</strong> &nbsp;{{session('error')}}<br><br>
</div>
 @endif
<script type="text/javascript">
var save_success   = $('.info-succc');
var error_info   = $('.info-errors');
save_success.slideDown();
save_success.delay(6000).slideUp(300);

error_info.slideDown();
error_info.delay(6000).slideUp(300);
</script>