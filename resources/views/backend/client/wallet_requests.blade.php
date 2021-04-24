@extends('backend.index')
@section('content')
<style type="text/css">
table th{font-weight: 400;font-size: 14px;letter-spacing: 1px;}
table tr td{font-weight: 400;font-size: 13px;letter-spacing: 1px;color: black}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
<div class="col-md-12">
	<h4 style="font-weight: 400;">Wallet Requests</h4>
</div>

<div class="col-md-12">
	<table class="table table-bordered" style="margin-top: 10px;width: 80%">
		<thead>
			<tr>
				<th style="width: 3%">ID</th>
				<th>First name, lastname</th>
				<th>Price</th>
				<th>status</th>
				<th>Contact</th>
				<th>Method</th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; ?>
		@foreach($data as $dataValue)
			<tr>
				<td align="right"><b style=""><a href="{{url('clients/details')}}/{{$dataValue->userId}}">#{{$dataValue->userId}}</a></b></td>
				<td style=""><b>{{$dataValue->first_name}} -</b> <span style="color:  #52d862">{{$dataValue->last_name}}</span></td>
			<td>{{$dataValue->price}} €</td>
			<td><select class="select" id="status_{{$dataValue->id}}" name="status" style="height: 25px;" onchange="completeStatus('{{$dataValue->id}}')">
				<option value="0">Change status</option>
				<option value="1" @if($dataValue->status==1) selected="" @endif >new request funds</option>
				<option value="2" @if($dataValue->status==2) selected="" @endif >compelete</option>
				<option value="3" @if($dataValue->status==3) selected="" @endif >cancel</option>
			</select></td>
			<td>{{$dataValue->phone_number}}</td>
				<td>
				<button class="btn btn-xs btn-default">Bank transfer <i class="fa   fa-credit-card"></i></button>

				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
</div>
<script type="text/javascript">
	function completeStatus(id) {
		var status=$("#status_"+id).val();
		if (status=="0") {

			alert("Sorry!!input was required");
			return false;
		}

		$.ajax({
    url: "{{url('refund-complete-status')}}/"+id+"/"+status,
    dataType:'json',
    success : function(data){
if (data.success==true) {
alert("status Change successfully");
} else {
alert("Sorry!!status Change Unsuccessfully");

}
    }
    });
    return true;

	}
</script>

@endsection
