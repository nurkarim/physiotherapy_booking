@extends('backend.index')
@section('content')
<style type="text/css">
table th{font-weight: 400;font-size: 14px;letter-spacing: 1px;}
table tr td{font-weight: 400;font-size: 13px;letter-spacing: 1px;color: black}
#dataTables-example_length{display: none;}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
<div class="col-md-12">
	<h4 style="font-weight: 400;">Clients</h4>
</div>
    <div class="col-md-12">
        import users: <a href="{{url('client/import')}}"> here</a>
    </div>
<div class="col-md-12">
	<a class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862" href="#" onclick="loadModalLG('clients/create')" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" style="padding: 2px"></i> <i class="" style="padding: 7px;background-color: white;color:black">Add Client</i></a>
</div>
<div class="col-md-7">
	<table class="table table-bordered" id="dataTables-example" style="margin-top: 10px;width: 100%">
		<thead>
			<tr>
				<th style="width: 3%">SL</th>
				<th>Name</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; ?>
		@foreach($client as $clientValue)
			<tr id="image_{{$clientValue->id}}">
				<td align="right"><b style=""><a href="{{url('clients/details')}}/{{$clientValue->id}}">#00{{$i++}}</a></b></td>
				<td style=""><b>{{$clientValue->first_name}} -</b> <span style="color:  #52d862">{{$clientValue->email}}</span></td>

				<td>
				<a class="btn btn-xs btn-default" href="{{url('clients')}}/{{$clientValue->id}}/edit"><i class="fa fa-pencil"></i></a>
				<button class="btn btn-xs btn-danger" onclick="deleteClient('{{$clientValue->id}}')"><i class="fa fa-remove"></i></button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
</div>
 <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            "ordering": false,

        });
    });
    </script>
<script type="text/javascript">
	function deleteClient(id) {
  if (confirm('Are you sure you want to delete from database?')) {
$.ajax({
  url: "{{url('clients')}}/"+id+"/delete",
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
