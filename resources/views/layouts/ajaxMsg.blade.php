<style>
	.alert{
		margin-bottom: 10px;
		padding-bottom: 0;
	}
	.alert ul li{
		margin-top: -15px; 
		padding-bottom: 10px;
	}
</style>
<div class="loading" style="display:none;">
	Loding...
</div>	

<div class="alert alert-danger info-error" style="display:none;">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Whoops!</strong> There were some problems with your input.<br><br>
	<ul></ul>
</div>

<div class="alert alert-success info-suc" style="display:none;">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Well done!</strong> &nbsp;Add cart successfully.<br><br>
</div>

<div class="alert alert-success update-suc" style="display:none;">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Well done!</strong> &nbsp;quantity updated successfully.<br><br>
</div>

<div class="alert alert-success app-suc" style="display:none;">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Well done!</strong> &nbsp;Add Appointment successfully.<br><br>
</div>
<div class="alert alert-success info-send" style="display:none;">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Well done!</strong> &nbsp;Send successfully.<br><br>
</div>

<div class="alert alert-danger file-error" style="display:none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Oh snap!</strong> There were some problem because your old existing file not found. <br/><br/>
</div>
<div class="alert alert-warning sms-nochange" style="display:none;">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Oops!</strong> Already Booking.<label></label></span><br><br>
</div>
<div class="alert alert-warning db-error" style="display:none;">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Oops!</strong> &nbsp;<label></label></span><br><br>
</div>
<div class="alert alert-info alert-dismissable delete-msg" style="display:none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Well done!</strong> Delete Record Successfully.<br><br>
</div>
<div class="alert alert-info alert-dismissable err-delete-msg" style="display:none;">
  <strong>Sorry!</strong> Delete Record UnSuccessfully.<br><br>
</div>
<div class="alert alert-info alert-dismissable inactive-msg" style="display:none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Well done!</strong> Inactive Record Successfully.<br><br>
</div>
<div class="alert alert-info alert-dismissable active-msg" style="display:none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Well done!</strong> Active Record Successfully.<br><br>
</div>
<div class="alert alert-warning alert-dismissable warning-msg" style="display:none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> Something wrong! Please try again.<br><br>
</div>
<div class="alert alert-warning alert-dismissable fk-msg" style="display:none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> Already Used! You can't Delete it.<br><br>
</div>
<div class="alert alert-warning alert-dismissable fk-constraint-msg" style="display:none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> Already Used! You can't Delete it.<br><br>
</div>
<div class="alert alert-success info-suc-custome" style="display:none;">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<label></label><br><br>
</div>

<div class="alert alert-success info-suc-dynamic" style="display:none;">	
	<strong>Well done!</strong> &nbsp;<label></label><br><br>
</div>

<div class="alert alert-info alert-dismissable info-update-dynamic" style="display:none;">
	<strong>Well done!</strong> &nbsp;<label></label><br><br>
</div>


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