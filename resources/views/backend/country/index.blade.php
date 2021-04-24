@extends('backend.index')
@section('content')
<style type="text/css">
table th{font-weight: 400;font-size: 14px;letter-spacing: 1px;}
table tr td{font-weight: 400;font-size: 13px;letter-spacing: 1px;color: black}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
<div class="col-md-12">
	<h4 style="font-weight: 400;">Country Overview</h4>
</div>
<div class="col-md-12">
	<a class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862" href="{{url('country/create')}}"><i class="fa fa-plus" style="padding: 2px"></i> <i class="" style="padding: 7px;background-color: white;color:black">Add New </i></a>
</div>
<div class="col-md-12">
	<table class="table " style="margin-top: 10px;width: 60%">
		<thead>
			<tr>

				<th>SL</th>
				<th>Name</th>
				<th>Code</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=1; ?>
@foreach($country as $dataTypeValue)
			<tr id="image_{{$dataTypeValue->id}}">

				<td>{{$i++}}</td>
				<td>{{$dataTypeValue->name}}</td>
				<td>{{$dataTypeValue->code}}</td>
				<td>
				<a class="btn btn-xs " href="{{url('country')}}/{{$dataTypeValue->id}}/edit"><i class="fa fa-pencil"></i></a>
				<button class="btn btn-xs " onclick="deleteImages('{{$dataTypeValue->id}}')"><i class="fa fa-remove" style="color: red"></i></button>
				</td>
			</tr>
@endforeach
		</tbody>
	</table>
</div>
</div>
<script type="text/javascript">
	function deleteImages(id) {
  if (confirm('Are you sure you want to delete from database?')) {
$.ajax({
  url: "{{url('country')}}/"+id+"/delete",
  dataType:'json',
  success : function(data){
  if(data.success == true){
        delete_msg.slideDown();
        delete_msg.delay(6000).slideUp(300);
        $("#image_"+id).remove();
    }else if(data.success == false){
        err_delete_msg.slideDown();
        err_delete_msg.delay(6000).slideUp(300);
    }
  }
});
return true;
}else{
  return false;
}
}
</script>

@endsection
