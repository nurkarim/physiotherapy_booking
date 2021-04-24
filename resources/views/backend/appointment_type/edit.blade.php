@extends('backend.index')
@section('content')
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<style type="text/css">
	.table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
</style>
<div class="row">
	<div class="col-md-12 col-md-offset-1">
		<h3 style="color: black">Edit Appointment Type</h3>
	</div>
	<div class="col-md-6 col-md-offset-1">

      {!! Form::model($dataType,['url'=>['appointment/types',$dataType->id],'id'=>'myForm','method'=>'PUT','files'=>true]) !!}
  <div class="form-group">
  <table class="table" id="tablenew">
  	<tr>
  		<td>Name</td>
  		<td>:</td>
  		<td><input type="text" name="type_name" class="form-control" required="" value="{{$dataType->type_name}}"></td>
  	</tr>
	<tr>
  		<td>Default Price</td>
  		<td>:</td>
  		<td><input type="text" name="amount" class="form-control" required="" value="{{$dataType->amount}}"></td>
  	</tr>
	<tr>
  		<td>Max#. of person</td>
  		<td>:</td>
  		<td><select class="form-control" id="select" onchange="onchangePersond()" name="max_person">
        <option value="">select person</option>
        <option value="1" @if($dataType->max_person==1) selected="" @endif>1</option>
        <option value="2" @if($dataType->max_person==2) selected="" @endif>2</option>
        <option value="3" @if($dataType->max_person==3) selected="" @endif>3</option>
        <option value="4" @if($dataType->max_person==4) selected="" @endif>4</option>

  		</select></td>
  	</tr>
  	<tr id="affter">
  		<td >Make Variable Price</td>
  		<td>:</td>
  		<td>
          <div class="checkbox checkbox-black " style="height: 10px;">
                        <input id="checkbox9" type="checkbox"  @if($dataType->has_variable_price==1) checked="" @endif name="has_variable_price" value="1" >
                        <label for="checkbox9"></label>
          </div></td>
  	</tr>

<!--   	<tr>
  		<td>Price 2 persone(s)</td>
  		<td>:</td>
  		<td><input type="text" name="" class="form-control"></td>
  	</tr>
  	<tr>
  		<td>Price 3 persone(s)</td>
  		<td>:</td>
  		<td><input type="text" name="" class="form-control"></td>
  	</tr> -->
  	<tr>
  		<td>Vat (in %)</td>
  		<td>:</td>
  		<td>
  		<select class="form-control" name="vat_number">
  		 @foreach($vat as $valueVat)
                          <option value="{{ $valueVat->vat_number}}" @if($dataType->vat_number==$valueVat->vat_number) selected="" @endif>{{ $valueVat->vat_number}}</option>
                          @endforeach
  		</select>

  		</td>
  	</tr>
  	<tr>
  		<td>Featured image</td>
  		<td>:</td>
  		<td><input type="file" name="image" class="form-control"></td>
  	</tr>
  	<tr>
  		<td>Description</td>
  		<td>:</td>
  		<td><textarea class="form-control" rows="5" name="description">{{$dataType->description}}</textarea></td>
  	</tr>
  	<tr>
  		<td>Color</td>
  		<td>:</td>
  		<td>
<div class="input-group custom-search-form">
	<div class="input-group">
		<select class="form-control" name="color"><option value="#2ecc71">emerald</option><option value="#3498db">blue</option><option value="#9b59b6">purple</option><option value="#34495e">Darkblue</option><option value="#f1c40f">yellow</option><option value="#f39c12">orange</option>
			<option value="#e74c3c">red</option>
			<option value="#bdc3c7">silver</option>
		</select>


 </div>

  		</td>
  	</tr>
  </table>
  </div>

  <button type="submit" class="btn" style="background-color: #52d862;color: white">Make appointment type</button>
 {!! Form::close() !!}
	</div>
</div>

<script>
    $(function() {
        $('#cp1').colorpicker();
    });
function inputColor() {
	var color=$('#cp1').val();
	$(".btn-backcolor").css('background-color',''+color);
	$(".fa-backcolor").css('background-color',''+color);
	$(".fa-backcolor").css('color',''+color);
}

    function onchangePersond() {
      var divs=$('#select').val();

      if (divs>0) {
$(".appendedTr").remove();
for (var i = divs; i >=1; i--) {

  $('<tr class="appendedTr"><td>Price '+i+' persone(s)</td><td>:</td><td><input type="text" name="person_amount[]" class="form-control" required=""><input type="hidden" name="person_number[]" value="'+i+'" class="form-control" required=""></td></tr>').insertAfter("#affter");

}


      }
    }
</script>

@endsection
