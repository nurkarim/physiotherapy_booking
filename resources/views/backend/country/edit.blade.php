@extends('backend.index')
@section('content')
<style type="text/css">
	.table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
	<div class="col-md-12 col-md-offset-1">
		<h3 style="color: black">Edit country {{$country->name}} </h3>
	</div>
	<div class="col-md-8 col-md-offset-1">

          {!! Form::model($country,['url'=>['country',$country->id],'id'=>'myForm','method'=>'PUT','files'=>true]) !!}
  <div class="form-group">
  <table class="table" id="tablenew">
  	<tr>
  		<td style="width: 20%">Country Name</td>
  		<td>:</td>
  		<td><input type="text" name="name" class="form-control" required="" placeholder="enter country name" value="{{$country->name}}"></td>
  	</tr>
	  	<tr>
  		<td style="width: 20%">code</td>
  		<td>:</td>
  		<td><input type="text" name="code" class="form-control" required="" placeholder="enter country code" value="{{$country->code}}"></td>
  	</tr>
  </table>
  </div>

  <button type="submit" class="btn" style="background-color: #52d862;color: white">save country</button>

  <a href="{{url('roles')}}"  class="btn" style="background-color: red;color: white">Close</a>
 {!! Form::close() !!}
	</div>
</div>


@endsection
