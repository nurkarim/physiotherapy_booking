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
		<h3 style="color: black">Edit User</h3>
	</div>
	<div class="col-md-12 ">
      {!! Form::model($user,['url'=>['users',$user->id],'id'=>'myForm','method'=>'PUT','files'=>true]) !!}
  <div class="form-group">
<div class="col-md-12 row">
  <div class="col-md-6">
	<h3 style="font-size: 16px;font-weight: bold;">Personal information:</h3>
    <table class="table">
  <tr>
      <td>Name</td>
      <td>:</td>
      <td><input type="text" name="fname" required="" minlength="4" value="{{$user->first_name}}"></td>
    </tr>
  <tr>
      <td>Last name</td>
      <td>:</td>
      <td><input type="text" name="last_name" required="" value="{{$user->last_name}}"></td>
    </tr>
  <tr>
      <td>Email</td>
      <td>:</td>
      <td><input type="email" name="email" required="" value="{{$user->email}}"></td>
    </tr>

    <tr>
      <td>Password</td>
      <td>:</td>
      <td><input type="text" name="password" required="" minlength="6"></td>
    </tr>

    <tr>
      <td >VAT-number:</td>
      <td>:</td>
      <td>
          <input type="text" name="vat_number" value="{{$user->vat_number}}"></td>
    </tr>
        <tr>
      <td >Title</td>
      <td>:</td>
      <td>
          <input type="text" name="title" value="{{$user->title}}"></td>
    </tr>
        <tr>
      <td >Role</td>
      <td>:</td>
      <td>
<select style="height: 30px;width: 210px" required="" name="role_id">
         @foreach($role as $roleValue)
        <option value="{{$roleValue->id}}"  @if($user->role_id==$roleValue->id) selected="" @endif>{{$roleValue->role_name}}</option>
         @endforeach
</select>



        </td>
    </tr>
  </table>
</div>
<div class="col-md-6">

     <div class="col-md-6">


           <div class="input_fields_wrap col-md-12">

        <div id="image-preview" class="" style="background-image: url(<?php echo url('public/image/users')."/".$user->image; ?>);background-size: 100%">
                                        <label for="image-upload" id="image-label">upload Image</label>
                                        <input type="file" name="image_file" id="image-upload"  />
         </div>

        </div>

     </div>
      <div class="col-md-6">

        <p>Work phone number</p>
        <p style="color: red;font-size: 12px">This number will be displayed on the website.</p>
        <p><input type="text" name="phone_number" minlength="5" required="" value="{{$user->phone_number}}"></p>
        <p>Priavte phone number:</p>

        <p><input type="text" name="another_phone_number" value="{{$user->another_phone_number}}"></p>

      </div>

</div>
</div>
 <div class="col-md-6">
    <h3 style="font-size: 16px;font-weight: bold;">Invoice Adress:</h3>

  <table class="table">
    <tr>
      <td>Adress</td>
      <td>:</td>
      <td><input type="text" name="i_address" id="i_address" required="" value="{{$address->invoice_address}}"></td>
    </tr>
  <tr>
      <td>Postal number</td>
      <td>:</td>
      <td><input type="text" name="i_code" id="i_code" required="" value="{{$address->post_code}}"></td>
    </tr>
  <tr>
      <td>City</td>
      <td>:</td>
      <td><input type="text" name="i_city" id="i_city" required="" value="{{$address->city}}"></td>
    </tr>
    <tr>
      <td >Country</td>
      <td>:</td>
      <td>
         <select style="height: 30px;width: 210px" name="i_country">
         @foreach($country as $valueCountry)
        <option value="{{$valueCountry->id}}"@if($address->country_name==$valueCountry->id) selected="" @endif>{{$valueCountry->name}}</option>
         @endforeach
</select></td>
    </tr>

  </table>

 </div>
 <div class="col-md-6">
    <h3 style="font-size: 16px;font-weight: bold;">Shipping Adress: <input type="checkbox" class="checkbox_check" onchange="sameAddress()"><span style="font-size: 13px;font-weight: 400" >Use same as invoice adress</span></h3>
  <table class="table">
      <tr>
      <td>Adress</td>
      <td>:</td>
      <td><input type="text" name="s_address" id="s_address" value="{{$address->shipping_address}}"></td>
    </tr>
  <tr>
      <td>Postal number</td>
      <td>:</td>
      <td><input type="text" name="s_code" id="s_code" value="{{$address->shipping_post_code}}"></td>
    </tr>
  <tr>
      <td>City</td>
      <td>:</td>
      <td><input type="text" name="s_city" id="s_city" value="{{$address->shopping_city}}"></td>
    </tr>
    <tr>
      <td >Country</td>
      <td>:</td>
      <td>
         <select style="height: 30px;width: 210px" name="s_country">
         @foreach($country as $valueCountry)
        <option value="{{$valueCountry->id}}" @if($address->shipping_country_name==$valueCountry->id) selected="" @endif>{{$valueCountry->name}}</option>
         @endforeach
</select>

        </td>
    </tr>

  </table>
 </div>
  </div>

    <button type="submit" class="btn btn-sm" style="background-color: #52d862;color: white;font-weight: bold;padding: 7px 20px;">Make User</button>

  <a href="{{url('users')}}"  class="btn" style="background-color: red;color: white">Close</a>
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
