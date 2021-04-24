@extends('backend.index')
@section('content')
<?php
$arr=array();
$arr1=array();
?>
@foreach($roleMenu as $roleMenuValue)
<?php
$arr[]=$roleMenuValue->menu_id;

 ?>
@endforeach

@foreach($roleSubMenu as $roleSubMenuValue)
<?php
$arr1[]=$roleSubMenuValue->sub_menu_id;

 ?>
@endforeach
<style type="text/css">
	.table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
	<div class="col-md-12 col-md-offset-1">
		<h3 style="color: black">Edit Roles</h3>
	</div>
	<div class="col-md-8 col-md-offset-1">


      {!! Form::model($role,['url'=>['roles',$role->id],'id'=>'myForm','method'=>'PUT','files'=>true]) !!}
  <div class="form-group">
  <table class="table" id="tablenew">
  	<tr>
  		<td style="width: 20%">Role Name</td>
  		<td>:</td>
  		<td><input type="text" name="type_name" value="{{$role->role_name}}" class="form-control" required="" placeholder="enter role name"></td>
  	</tr>
	<tr>
   <td>Access</td>
   <td>:</td>
   <td>

    @foreach($menu as $values)
   <div class="col-md-6">
        <div class="checkbox checkbox-info checkbox-inline">
                        <input type="checkbox" id="menus{{$values->id}}" value="{{$values->route}}_{{$values->id}}" name="menu_name[]" @if(in_array($values->id, $arr)) checked="" @endif onchange="sameAddress('{{$values->id}}')">
                        <label for="menus{{$values->id}}"> {{$values->menu_name}} </label>
        </div>
        @foreach($subMenu as $subMenuValue)
        @if($values->id==$subMenuValue->menu_id)
<div class="col-md-12">
   <div class="checkbox checkbox-primary checkbox-inline" style="">
                        <input type="checkbox" class="sb_menu_{{$values->id}}" id="subMenu{{$subMenuValue->id}}" value="{{$subMenuValue->route}}_{{$subMenuValue->id}}_{{$values->id}}" name="sub_menu_name[]" @if(in_array($subMenuValue->id, $arr1)) checked="" @endif>
                        <label for="subMenu{{$subMenuValue->id}}"> {{$subMenuValue->sub_menu_name}} </label>
        </div>
</div>
        @endif
        @endforeach

   </div>
       @endforeach
   </td>
  </tr>
  </table>
  </div>

  <button type="submit" class="btn" style="background-color: #52d862;color: white">Make Role</button>

  <a href="{{url('roles')}}"  class="btn" style="background-color: red;color: white">Close</a>
 {!! Form::close() !!}
	</div>
</div>
<script type="text/javascript">
    function sameAddress(id) {
if ($('#menus'+id).is(':checked')) {

    $('.sb_menu_'+id).prop('checked', true);
  }else{
      $('.sb_menu_'+id).prop('checked', false);
  }
}
</script>

@endsection
