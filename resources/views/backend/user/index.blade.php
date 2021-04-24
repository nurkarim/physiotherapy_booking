@extends('backend.index')
@section('content')
<style type="text/css">
table th{font-weight: 400;font-size: 14px;letter-spacing: 1px;}
table tr td{font-weight: 400;font-size: 13px;letter-spacing: 1px;color: black}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
<div class="col-md-12">
	<h4 style="font-weight: 400;">User list</h4>
</div>
<div class="col-md-12">
	<a class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862" href="{{url('users/create')}}"><i class="fa fa-plus" style="padding: 2px"></i> <i class="" style="padding: 7px;background-color: white;color:black">Add User</i></a>
</div>
<div class="col-md-12">
	<table class="table table-bordered" style="margin-top: 10px;width: 60%">
		<thead>
			<tr>
				<th style="width: 3%">ID</th>
				<th>Name</th>
				<th>Role</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1; ?>
		@foreach($users as $usersValue)
			<tr>
				<td align="right"><b style=""><a href="">#0{{$i++}}</a></b></td>
				<td style=""><b>{{$usersValue->first_name}} -</b> <span style="color:  #52d862">{{$usersValue->email}}</span></td>
				<td>{{$usersValue->role_name}}</td>
				<td>
				<a class="btn btn-xs btn-default" href="{{url('users')}}/{{$usersValue->id}}/edit"><i class="fa fa-pencil"></i></a>
				<button class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
</div>


@endsection
