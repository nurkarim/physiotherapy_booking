
<style type="text/css">
	.table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
  input{height: 30px;border:1px solid #000;width: 220px;}
  select{height: 30px;width: 220px;border:1px solid #000;}
</style>


<div class="row">

	<div class="col-md-12">
{!! Form::open(['url'=>URL::to('clients'),'id'=>'myForm','files'=>true]) !!}
  <div class="form-group">
  <table class="table" style="width: 50%;float: left;clear: right;">
    <tr>
      <td colspan="3" style="font-size: 16px;font-weight: bold;">Personal information:</td>
    
    </tr>
  	<tr>
  		<td>Name <em style="color: red">*</em></td>
  		<td>:</td>
  		<td><input type="text" name="fname" required=""></td>
  	</tr>
	<tr>
  		<td>Last name <em style="color: red">*</em></td>
  		<td>:</td>
  		<td><input type="text" name="last_name" required=""></td>
  	</tr>
	<tr>
  		<td>Email <em style="color: red">*</em></td>
  		<td>:</td>
  		<td>
        <input type="email" name="email" required="" id="email"><br>
        <span id="userresult" style="font-size:13px;font-weight:bold"></span>
      </td>
  	</tr>
      <tr>
      <td>Contact number <em style="color: red">*</em></td>
      <td>:</td>
      <td><input type="text" name="phone_number" required=""></td>
    </tr>
  	<tr>
  		<td >VAT-number <em style="color: red">*</em></td>
  		<td>:</td>
  		<td>
          <input type="text" name="vat_number" required="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"></td>
  	</tr>

  </table>

  <table class="table col-md-6" style="width: 50%;float: left;clear: right;">
    <tr>
      <td colspan="3" style="font-size: 16px;font-weight: bold;">Invoice Adress </td>
    
    </tr>
  	<tr>
  		<td>Adress <em style="color: red">*</em></td>
  		<td>:</td>
  		<td><input type="text" name="i_address" id="i_address" required=""></td>
  	</tr>
	<tr>
  		<td>Postal number <em style="color: red">*</em></td>
  		<td>:</td>
  		<td><input type="text" name="i_code" id="i_code" required=""></td>
  	</tr>
	<tr>
  		<td>City <em style="color: red">*</em></td>
  		<td>:</td>
  		<td><input type="text" name="i_city" id="i_city" required=""></td>
  	</tr>
  	<tr>
  		<td >Country <em style="color: red">*</em></td>
  		<td>:</td>
  		<td>
        <select name="i_country" id="i_country" required="">
          @foreach($country as $values)
          <option value="{{$values->id}}">{{$values->name}}</option>
         @endforeach
        </select>
</td>
  	</tr>

  </table>



  <table class="table">
        <tr>
      <td style=""><b style="font-size: 13px;font-weight: bold;padding: 0px;">Shipping Adress:</b></td>
    
      <td colspan="2">
      <div class="checkbox checkbox-primary checkbox-inline">
                            
                                <input id="checkbox22" type="checkbox" class="checkbox_check" onchange="sameAddress()"   name="recurring" value="1" >
                        <label for="checkbox22" style="font-size: 16px;">
                            Use same as invoice address
                        </label>
                            </div>
    </td>
    </tr>
  	<tr>
  		<td>Adress <em style="color: red">*</em></td>
  		<td>:</td>
  		<td><input type="text" name="s_address" id="s_address" required=""></td>
  	</tr>
	<tr>
  		<td>Postal number <em style="color: red">*</em></td>
  		<td>:</td>
  		<td><input type="text" name="s_code" id="s_code" required=""></td>
  	</tr>
	<tr>
  		<td>City <em style="color: red">*</em></td>
  		<td>:</td>
  		<td><input type="text" name="s_city" id="s_city" required=""></td>
  	</tr>
  	<tr>
  		<td >Country <em style="color: red">*</em></td>
  		<td>:</td>
  		<td>

     <select name="s_country" id="s_country" required="">
          @foreach($country as $values)
          <option value="{{$values->id}}">{{$values->name}}</option>
         @endforeach
        </select>
        </td>
  	</tr>

  </table>
  </div>

  <button type="submit" class="btn btn-success">Save client</button>
 {!! Form::close() !!}
	</div>
</div>

<script type="text/javascript">
  function sameAddress() {
    if ($('input.checkbox_check').is(':checked')) {
    var iadd=$("#i_address").val();
    var icon=$("#i_country").val();
    var icity=$("#i_city").val();
    var icode=$("#i_code").val();
    $("#s_address").val(iadd);
    $("#s_country").val(icon);
    $("#s_city").val(icity);
    $("#s_code").val(icode);
            } else {

                $("#s_address").val(" ");
                $("#s_country").val(" ");
                $("#s_city").val(" ");
                $("#s_code").val(" ");
            }
  }


</script>

<script type="text/javascript">
$(document).ready(function() {
    var x_timer;
    $("#email").keyup(function (e){


        clearTimeout(x_timer);
        var user_name = $(this).val();
        x_timer = setTimeout(function(){
            check_username_ajax(user_name);
        }, 1000);
    });

function check_username_ajax(username){

    $.get('{{url("email-checker")}}', {'email':username}, function(data) {
      if(data==1){
        $("#userresult").html("E-mail already taken for another client").css('color','red');
      }else{
        $("#userresult").html("E-mail is accepted").css('color','green');
      }

    });
}
});
</script>


