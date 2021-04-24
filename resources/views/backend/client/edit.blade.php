@extends('backend.index')
@section('content')
<style type="text/css">
	.table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
    input{height: 30px;border:1px solid #000;width: 220px;}
  select{height: 30px;width: 220px;border:1px solid #000;}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
	<div class="col-md-12 col-md-offset-1">
		<h3 style="color: black">Add Client</h3>
	</div>
	<div class="col-md-8 col-md-offset-1">
	<h3 style="font-size: 16px;font-weight: bold;">Personal information:</h3>
 {!! Form::model($client,['url'=>['clients',$client->id],'id'=>'myForm','method'=>'PUT','files'=>true]) !!}
  <div class="form-group">
  <table class="table">
  	<tr>
  		<td>Name</td>
  		<td>:</td>
  		<td><input type="text" name="fname" value="{{$client->first_name}}"></td>
  	</tr>
	<tr>
  		<td>Last name</td>
  		<td>:</td>
  		<td><input type="text" name="last_name" value="{{$client->last_name}}"></td>
  	</tr>
	<tr>
  		<td>Email</td>
  		<td>:</td>
  		<td><input type="email" name="email" value="{{$client->email}}"></td>
  	</tr>
      <tr>
      <td>Contact number</td>
      <td>:</td>
      <td><input type="text" name="phone_number" value="{{$client->phone_number}}"></td>
    </tr>
  	<tr>
  		<td >VAT-number:</td>
  		<td>:</td>
  		<td>
          <input type="text" name="vat_number" value="{{$client->vat_number}}"></td>
  	</tr>

  </table>
  <h3 style="font-size: 16px;font-weight: bold;">Invoice Adress</h3>

  <table class="table">
  	<tr>
  		<td>Adress</td>
  		<td>:</td>
  		<td><input type="text" id="i_address" name="i_address" value="{{$address->invoice_address}}"></td>
  	</tr>
	<tr>
  		<td>Postal number</td>
  		<td>:</td>
  		<td><input type="text" id="i_code" name="i_code" value="{{$address->post_code}}"></td>
  	</tr>
	<tr>
  		<td>City</td>
  		<td>:</td>
  		<td><input type="text" id="i_city" name="i_city" value="{{$address->city}}"></td>
  	</tr>
  	<tr>
  		<td >Country</td>
  		<td>:</td>
  		<td>

 <select name="i_country" id="i_country" required="">
          @foreach($country as $values)
          <option value="{{$values->id}}" @if($address->country_name==$values->id) selected="" @endif>{{$values->name}}</option>
         @endforeach
        </select>

    </td>
  	</tr>

  </table>
  <table class="table">



    <tr>
      <td style=""><b style="font-size: 16px;font-weight: bold;padding: 0px;">Shipping Adress:</b></td>
      <td style="width: 5%" ><input style="width: 20px" type="checkbox" name="" class="checkbox_check" onchange="sameAddress()"></td>
      <td><b style="font-size: 16px;font-weight: bold;padding: 0px;">  Use same as invoice adress </b></td>
    </tr>

</table>

  <table class="table">
  	<tr>
  		<td>Adress</td>
  		<td>:</td>
  		<td><input type="text" id="s_address" name="s_address" value="{{$address->shipping_address}}"></td>
  	</tr>
	<tr>
  		<td>Postal number</td>
  		<td>:</td>
  		<td><input type="text" id="s_code" name="s_code" value="{{$address->shipping_post_code}}"></td>
  	</tr>
	<tr>
  		<td>City</td>
  		<td>:</td>
  		<td><input type="text" id="s_city" name="s_city" value="{{$address->shopping_city}}"></td>
  	</tr>
  	<tr>
  		<td >Country</td>
  		<td>:</td>
  		<td>
 <select name="s_country" id="s_country" required="">
          @foreach($country as $valuess)
          <option value="{{$valuess->id}}" @if($address->shipping_country_name==$valuess->id) selected="" @endif>{{$valuess->name}}</option>
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

@endsection
