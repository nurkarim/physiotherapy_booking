@extends('backend.index')
@section('content')

<style type="text/css">
	.table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
	<div class="col-md-12 col-md-offset-1">
		<h3 style="color: black">Add Company Info </h3>
	</div>
	<div class="col-md-8 col-md-offset-1">
    {!! Form::open(['url'=>URL::to('setting/company'),'id'=>'myForm','files'=>true]) !!}
  <div class="form-group">
  <table class="table" id="tablenew">
  	<tr>
  		<td style="width: 20%">Company Name</td>
  		<td>:</td>
  		<td><input type="text" name="name" class="form-control" required="" placeholder="" value="{{@$data->name}}"></td>
  	</tr>
  		<tr>
  		<td style="width: 20%">Contact</td>
  		<td>:</td>
  		<td><input type="text" name="contact" class="form-control" required="" placeholder="" value="{{@$data->contact}}"></td>
  	</tr>
  	<tr>
  		<td style="width: 20%">VAT Number</td>
  		<td>:</td>
  		<td><input type="text" name="vat_number" class="form-control" required="" placeholder="" value="{{@$data->vat_number}}"></td>
  	</tr>
	 <tr>
  		<td style="width: 20%">Email</td>
  		<td>:</td>
  		<td><input type="text" name="email" class="form-control" required="" placeholder="" value="{{@$data->email}}"></td>
  	</tr>
  		 <tr>
  		<td style="width: 20%">Post Code</td>
  		<td>:</td>
  		<td><input type="text" name="post_code" class="form-control" required="" placeholder="" value="{{@$data->post_code}}"></td>
  	</tr>
  	 <tr>
  		<td style="width: 20%">City</td>
  		<td>:</td>
  		<td><input type="text" name="city" class="form-control" required="" value="{{@$data->city}}"></td>
  	</tr>
    <tr>
      <td style="width: 20%">Bank Account Number</td>
      <td>:</td>
      <td><input type="text" name="bank_account_number" class="form-control" required="" value="{{@$data->bank_account_number}}"></td>
    </tr>
    <tr>
  		<td style="width: 20%">Country</td>
  		<td>:</td>
  		<td><input type="text" name="country" class="form-control" required="" value="{{@$data->country}}"></td>
  	</tr>
  	<tr>
  		<td style="width: 20%">Address</td>
  		<td>:</td>
  		<td>
<textarea class="form-control" rows="5" name="address">{{@$data->address}}</textarea>
  		</td>
  	</tr>
  		 <tr>
  		<td style="width: 20%">Logo</td>
  		<td>:</td>
  		<td>
  			<input type="file" name="logo" class="form-control"  placeholder="">
  			<br>
  			<img src="{{url('public/image')}}/{{@$data->logo}}" style="height: 110px;width: 120px;padding-top: 20px;">
  		</td>
  	</tr>
  </table>
  </div>

  <button type="submit" class="btn" style="background-color: #52d862;color: white">save </button>

 {!! Form::close() !!}
	</div>
</div>


@endsection
