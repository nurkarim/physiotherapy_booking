@extends('backend.index')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/product.css')}}">
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<style type="text/css">
	.table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
 .table{border-style: hidden;}
</style>
<div class="row">
	<div class="col-md-12">
		<h3 style="color: black">Add User</h3>
	</div>
	<div class="col-md-12 ">
    {!! Form::open(['url'=>URL::to('users'),'id'=>'myForm','files'=>true]) !!}
  <div class="form-group">
<div class="col-md-12 row">
  <div class="col-md-6">
	<h3 style="font-size: 16px;font-weight: bold;">Personal information:</h3>
    <table class="table">
  <tr>
      <td>Name <em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="text" name="fname" required="" minlength="4"></td>
    </tr>
  <tr>
      <td>Last name</td>
      <td>:</td>
      <td><input type="text" name="last_name" ></td>
    </tr>
  <tr>
      <td>Email <em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="email" name="email" required=""></td>
    </tr>

    <tr>
      <td>Password <em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="text" name="password" required="" minlength="6"></td>
    </tr>


    <tr>
      <td >VAT-number:</td>
      <td>:</td>
      <td>
          <input type="text" name="vat_number" ></td>
    </tr>
        <tr>
      <td >Title</td>
      <td>:</td>
      <td>
          <input type="text" name="title"></td>
    </tr>
        <tr>
      <td >Role <em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td>
<select style="height: 30px;width: 210px" required="" name="role_id">
         @foreach($role as $roleValue)
        <option value="{{$roleValue->id}}">{{$roleValue->role_name}}</option>
         @endforeach
</select>



        </td>
    </tr>
  </table>
</div>
<div class="col-md-6">

     <div class="col-md-6">


           <div class="input_fields_wrap col-md-12">

        <div id="image-preview" class="">
                                        <label for="image-upload" id="image-label">upload Image</label>
                                        <input type="file" name="image_file" id="image-upload"  />
         </div>

        </div>

     </div>
      <div class="col-md-6">

        <p>Work phone number <em style="color: red;font-weight: bold;">*</em></p>
        <p style="color: red;font-size: 12px">This number will be displayed on the website.</p>
        <p><input type="text" name="phone_number" minlength="5" required=""></p>
        <p>Priavte phone number:</p>

        <p><input type="text" name="another_phone_number"></p>

      </div>

</div>
</div>
 <div class="col-md-6">
    <h3 style="font-size: 16px;font-weight: bold;">Invoice Adress:</h3>

  <table class="table">
    <tr>
      <td>Adress<em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="text" name="i_address" id="i_address" required=""></td>
    </tr>
  <tr>
      <td>Postal number<em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="text" name="i_code" id="i_code" required=""></td>
    </tr>
  <tr>
      <td>City<em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="text" name="i_city" id="i_city" required=""></td>
    </tr>
    <tr>
      <td >Country<em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td>
         <select style="height: 30px;width: 210px" name="i_country">
         @foreach($country as $valueCountry)
        <option id="{{$valueCountry->id}}">{{$valueCountry->name}}</option>
         @endforeach
</select></td>
    </tr>

  </table>

 </div>
 <div class="col-md-6">
    <h3 style="font-size: 16px;font-weight: bold;">Shipping Adress: <input type="checkbox" class="checkbox_check" onchange="sameAddress()"><span style="font-size: 13px;font-weight: 400" >Use same as invoice adress</span></h3>
  <table class="table">
      <tr>
      <td>Adress <em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="text" name="s_address" id="s_address"></td>
    </tr>
  <tr>
      <td>Postal number <em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="text" name="s_code" id="s_code"></td>
    </tr>
  <tr>
      <td>City <em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td><input type="text" name="s_city" id="s_city"></td>
    </tr>
    <tr>
      <td >Country <em style="color: red;font-weight: bold;">*</em></td>
      <td>:</td>
      <td>
         <select style="height: 30px;width: 210px" name="s_country">
         @foreach($country as $valueCountry)
        <option id="{{$valueCountry->id}}">{{$valueCountry->name}}</option>
         @endforeach
</select>

        </td>
    </tr>

  </table>
 </div>
  </div>
<div class="col-md-12" style="height: 20px">
  <input type="checkbox" name="is_specialist" id="is_specialist" value="1"> <label for="is_specialist">are you a specialist?</label>

</div>

    <button type="submit" class="btn btn-sm" style="background-color: #52d862;color: white;font-weight: bold;padding: 7px 20px;margin-top: 10px;">Make User</button>

  <a href="{{url('users')}}"  class="btn" style="background-color: red;color: white;margin-top: 10px;">Close</a>
{!! Form::close() !!}
	</div>
</div>

<script type="text/javascript" src="{{URL::to('/')}}/public/js/jquery.uploadPreview.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose Image", // Default: Choose File
            label_selected: "Change Image", // Default: Change File
            no_label: false // Default: false
        });

    });
</script>

<script type="text/javascript">
  function sameAddress() {
    if ($('input.checkbox_check').is(':checked')) {
    var iadd=$("#i_address").val();

    var icity=$("#i_city").val();
    var icode=$("#i_code").val();
    $("#s_address").val(iadd);

    $("#s_city").val(icity);
    $("#s_code").val(icode);
            } else {

                $("#s_address").val(" ");

                $("#s_city").val(" ");
                $("#s_code").val(" ");
            }
  }


</script>
@endsection
