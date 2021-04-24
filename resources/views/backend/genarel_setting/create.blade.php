@extends('backend.index')
@section('content')
<style type="text/css">
	.table tr td{border-style: hidden;font-size: 15px;font-weight: 400}
  table tr th{font-size: 13px;font-weight: bold;color: black}
  .dayHover{cursor: pointer;}
  .dayHover:hover{border-color: #35de80};
</style>

<div class="row">

	<div class="col-md-12 ">
    <div class="col-md-12" >
    <h3 style="color: black;font-weight: bold;">General Settings</h3>
  </div>
<div class="col-md-6">
  <div class="col-md-12"><h4 style="font-weight: bold;">VAT-Class</h4></div>
  <div class="col-md-12">
    <table class="table table-bordered">
      <tr>
        <th>Country</th>
        <th>Percentage</th>
        <th></th>
      </tr>
      @foreach($select_vat as $select_vatValue)
       <tr id="trv_{{$select_vatValue->id}}">
        <td><span id="vat_type_text{{$select_vatValue->id}}">{{$select_vatValue->vat_type}}</span><input type="text" class="input-hide" id="vat_type{{$select_vatValue->id}}" value="{{$select_vatValue->vat_type}}"></td>
        <td><span id="vat_number_text{{$select_vatValue->id}}">{{$select_vatValue->vat_number}}</span><input type="text" class="input-hide" id="vat_number{{$select_vatValue->id}}" value="{{$select_vatValue->vat_number}}" style="width: 60%"></td>
        <td>
          <button onclick="deleteVat('{{$select_vatValue->id}}')" class="btn btn-xs" style=""><i class="fa fa-remove" style="color: red"></i></button>
           | <button onclick="vatEdit('{{$select_vatValue->id}}')" class="btn btn-xs " id="vat-edit{{$select_vatValue->id}}" style=""><i class="fa fa-edit" style="color: blue"></i></button>
           <button id="vat-save{{$select_vatValue->id}}" class="btn btn-xs vat-saves" style="" onclick="updateVat('{{$select_vatValue->id}}')"><i class="fa fa-floppy-o" style="color: green"></i></button>
            <button id="vat-refresh{{$select_vatValue->id}}" onclick="Vatrefresh('{{$select_vatValue->id}}')" class="btn btn-xs vat-saves" style=""><i class="fa fa-refresh" style="color: blue"></i></button>
          </td>
      </tr>
      @endforeach
    </table>
    <a class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" style="padding: 2px"></i> <i class="" style="padding: 7px;background-color: white;color:black">Add vat-class</i></a>
  </div>
</div>
<div class="col-md-6">
    <div class="col-md-12"><h4 style="font-weight: bold;">Categories</h4></div>
  <div class="col-md-12">
    <table class="table table-bordered">
      <tr>
        <th>Category name</th>

        <th></th>
      </tr>
      @foreach($category as $categoryValeu)
       <tr id="tr_{{$categoryValeu->id}}">
        <td>
          <span id="category_text{{$categoryValeu->id}}">{{$categoryValeu->name}}</span>
          <input type="text" name="category_name" class="cat_input" value="{{$categoryValeu->name}}" id="category_name{{$categoryValeu->id}}">
        </td>
        <td><button onclick="deletecategory('{{$categoryValeu->id}}')" class="btn btn-xs" style=""><i class="fa fa-remove" style="color: red"></i></button> | <button onclick="categoryEdit('{{$categoryValeu->id}}')" class="btn btn-xs " id="btn-edit{{$categoryValeu->id}}" style=""><i class="fa fa-edit" style="color: blue"></i></button><button id="btn-save{{$categoryValeu->id}}" class="btn btn-xs btn-saves" style="" onclick="updateCategory('{{$categoryValeu->id}}')"><i class="fa fa-floppy-o" style="color: green"></i></button> <button id="btn-refresh{{$categoryValeu->id}}" onclick="categoryrefresh('{{$categoryValeu->id}}')" class="btn btn-xs btn-saves" style=""><i class="fa fa-refresh" style="color: blue"></i></button></td>
      </tr>
      @endforeach
    </table>
     <a class="btn btn-sm" data-toggle="modal" data-target="#myModal1" style="color: white;padding-left: 10px;background-color: #52d862" ><i class="fa fa-plus" style="padding: 2px"></i> <i class="" style="padding: 7px;background-color: white;color:black">Add category</i></a>
  </div>
</div>
	</div>
@foreach($week_type as $week_typeValue)
  <div class="col-md-12" style="margin-left: 10px " id="div_week_type_{{$week_typeValue->id}}">


  <div class="col-md-12" class="padding-left-generalsettings">
    <h4 class="" style="color: black;font-size: 17px;margin-left: 5px">Week type: <b style="font-size: 15px;">{{$week_typeValue->week_type_name}}</b>

 <button type="button" class="fa fa-close" style="border-style: hidden;background-color: white;color: red;font-size: 22px;" onclick="deleteWeekType('{{$week_typeValue->id}}')"></button><br>
    </h4></div>
@foreach($days as $day)
          <div class="col-md-1 dayHover" id="dayHover_{{$day->id}}_{{$week_typeValue->id}}" style="border:1px solid #000;text-align: center;height: auto; min-height: 120px;    margin-left: 20px;" onclick="editWeekDay('week-types','{{$day->id}}','{{$week_typeValue->id}}','edit')" data-toggle="modal" data-target="#modal">
              <ul style="padding:0px;font-weight: bold;margin-top: 8px;font-size: 13px;" class="row">{{$day->name}}</ul>
    @foreach($week_day as $weekDay)
        @if($week_typeValue->id == $weekDay->week_type_id)
        @if($day->id == $weekDay->day_id)

                      <ul style="padding: 0px;color: black;margin-top: -10px;" class="row">
                          {{$weekDay->start_time}}-{{$weekDay->end_time}}
                      </ul>

        @endif
        @endif

    @endforeach

                  </div>
@endforeach


{{--  @foreach($week_day as $week_dayValue)
      @if($day->id == $week_dayValue->day_id)
      {{$week_dayValue->name}}
  @if($week_dayValue->week_type_id==$week_typeValue->id)

<div class="col-md-1" style="border:1px solid #000;text-align: center;height: 120px;    margin-left: 20px;">
  <ul style="padding:0px;font-weight: 400;margin-top: 10px;;font-size: 15px;" class="row">{{$week_dayValue->name}}</ul>
  <ul style="padding: 0px;" class="row">
    {{$week_dayValue->start_time}}-{{$week_dayValue->end_time}}
  </ul>
  --}}{{-- <ul style="padding: 0px;" class="row">22:00-00:00</ul> --}}{{--
</div>--}}




</div>
@endforeach
  <div class="col-md-12" style="margin-top: 10px; margin-left: 10px;">
     <a class="btn btn-sm" data-toggle="modal" data-target="#myModal2" style="margin-left: 20px;color: white;padding-left: 10px;background-color: #52d862" ><i class="fa fa-plus" style="padding: 2px"></i> <i class="" style="padding: 7px;background-color: white;color:black">Add week type</i></a>
  </div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight: bold;">VAT-Class</h4>
      </div>
        {!! Form::open(['url'=>URL::to('vat-class'),'id'=>'myForm']) !!}
      <div class="modal-body">
  <div class="form-group">
    <label for="country_id">Country:</label>

     <select name="country_id" class="form-control" id="country_id" required="">
@foreach($country as $countryValue)
      <option value="{{$countryValue->id}}">{{$countryValue->name}}</option>
     @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="country_code">Country code:</label>
    <input type="text" class="form-control" id="country_code" name="vat_type">
  </div>
  <div class="form-group">
    <label for="percentage">Percentage:</label>
    <input type="text" class="form-control" id="percentage" name="vat_number">
    <input type="hidden" class="form-control" id="" name="status" value="1">

  </div>

      </div>
      <div class="modal-footer">
  <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
{!! Form::close() !!}
    </div>

  </div>
</div>
<!-- //======================Category=================== -->
<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight: bold;">Categories</h4>
      </div>
         {!! Form::open(['url'=>URL::to('categories'),'id'=>'myForm','files'=>true]) !!}
      <div class="modal-body">
  <div class="form-group">
    <label for="names">Categorie:</label>
    <input type="text" class="form-control" id="names" name="name">
    <input type="hidden" class="form-control" id="" name="status" value="1">
  </div>
  <div class="form-group">
    <label for="image">image:</label>
    <input type="file" class="form-control" id="image" name="category_image" required="">

  </div>
      </div>
      <div class="modal-footer">
  <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
   {!! Form::close() !!}
    </div>
  </div>
</div>
{{-- //========================Add wekk types=======================// --}}

<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight: bold;">week type</h4>
      </div>
         {!! Form::open(['url'=>URL::to('weekTypes'),'id'=>'myForm']) !!}
      <div class="modal-body">

  <div class="form-group">
    <label for="names">Week Types:</label>
    <input type="text" class="form-control" id="names" name="type_name" required="">

  </div>

  <div class="form-group">
   <table class="table">
     <thead>
       <tr>
         <th>Day</th>
         <th>Start Time</th>
         <th>End Time</th>
         <th><button type="button" class="btn btn-xs btn-danger fa fa-plus" onclick="addMore()" ></button></th>
       </tr>
     </thead>
     <tbody id="tbody">
       <tr id="tr">
         <td>
          <select name="week_day[]" class="form-control">
@foreach($days as $dayValue)
      <option value="{{$dayValue->id}}">{{$dayValue->name}}</option>
     @endforeach
    </select></td>
         <td>
       
          <select name="start_time[]" class="form-control">
@foreach($select_time as $select_timeValues)
<option value="{{$select_timeValues->name}}">{{$select_timeValues->name}}</option>
@endforeach     
          </select>

         </td>
         <td>
        
      <select name="end_time[]" class="form-control">
@foreach($select_time as $select_timeValues)
<option value="{{$select_timeValues->name}}">{{$select_timeValues->name}}</option>
@endforeach     
          </select>
         </td>
         <td></td>
       </tr>
     </tbody>
   </table>
  </div>

      </div>
      <div class="modal-footer">
  <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
   {!! Form::close() !!}
    </div>

  </div>
</div>
<style type="text/css">
  .cat_input{display: none;}
  .input-hide{display: none;}
  .btn-saves{display: none;color: green}
  .vat-saves{display: none;color: green}
</style>
<script>



function addMore() {
    var max_fields  = 6;
    var x = 1;
  if(x < max_fields){
            x++;
  $('#tbody').append('<tr id="tr_'+x+'"><td><select name="week_day[]" class="form-control">@foreach($days as $dayValue)<option value="{{$dayValue->id}}">{{$dayValue->name}}</option>@endforeach</select></td> <td>    <select name="start_time[]" class="form-control">@foreach($select_time as $select_timeValues)<option value="{{$select_timeValues->name}}">{{$select_timeValues->name}}</option>@endforeach</select></td><td><select name="end_time[]" class="form-control">@foreach($select_time as $select_timeValues)<option value="{{$select_timeValues->name}}">{{$select_timeValues->name}}</option>@endforeach   </select></td><td><button type="button" class="btn btn-xs btn-danger fa fa-trash" onclick="removerMore('+x+')"></button></td></tr>');
}
}
function addMorenew() {
    var max_fields  = 6;
    var x = 1;
  if(x < max_fields){
            x++;
  $('#tbody1').append('<tr id="tr_'+x+'"><td>    <select name="start_time[]" class="form-control">@foreach($select_time as $select_timeValues)<option value="{{$select_timeValues->name}}">{{$select_timeValues->name}}</option>@endforeach</select></td><td><select name="end_time[]" class="form-control">@foreach($select_time as $select_timeValues)<option value="{{$select_timeValues->name}}">{{$select_timeValues->name}}</option>@endforeach   </select></td><td><button type="button" class="btn btn-xs btn-danger fa fa-trash" onclick="removerMore('+x+')"></button></td></tr>');
}
}

function removerMore(id) {

$("#tr_"+id).remove();
}


    $(function() {
        $('#cp1').colorpicker();
    });

function categoryEdit(id)
{
$('#btn-edit'+id).hide();
$('#category_text'+id).hide();
$('#btn-save'+id).show();
$('#category_name'+id).show();
$('#btn-refresh'+id).show();
}

function categoryrefresh(id)
{
$('#btn-edit'+id).show();
$('#category_text'+id).show();
$('#btn-save'+id).hide();
$('#btn-refresh'+id).hide();
$('#category_name'+id).hide();

}


function updateCategory(id) {
    var name=$("#category_name"+id).val();
    var title=$("#category_text"+id);

    if (name==null) {
        alert('Warning!Blank Field must be required.');
            return false;
    }
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        $.ajax({
            url:"categories/"+id+"/update",
           type     : "GET",
            cache    : false,
            dataType : 'json',
            data     : {'name': name, 'id': id},
                beforeSend: function(){
                loading.show();
            },
            success  : function(data){
                if(data.success == true){
                   $('#btn-edit'+id).show();
                    $('#category_text'+id).show();
                    $('#btn-save'+id).hide();
                    $('#btn-refresh'+id).hide();
                    $('#category_name'+id).hide();
                    $('#category_text'+id).html(name);
                    info_suc.slideDown();
                    info_suc.delay(3000).slideUp(300);

                }
                if(data.success == false){
                    info_err.hide().find('ul').empty();
                    $.each(data.error, function(index, error){
                    info_err.find('ul').append('<li>'+error+'</li>');
                    });
                    info_err.slideDown();
                    info_err.delay(6000).slideUp(300);
                }
                if(data.error == true){
                    db_err.hide().find('label').empty();
                    db_err.find('label').append(data.status);
                    db_err.slideDown();
                    db_err.delay(5000).slideUp(300);
                }
                loading.hide();
            },
            error: function(data){
                alert('error occurred! Please Check');
                loading.hide();
            }
        });

    return false;
}
function deletecategory(id){
  if (confirm('Are you sure you want to delete from database?')) {
$.ajax({
  url: "categories/"+id+"/delete",
  dataType:'json',
  success : function(data){
  if(data.success == true){
        delete_msg.slideDown();
        delete_msg.delay(6000).slideUp(300);
        $("#tr_"+id).remove();
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


//====================================Vat-class==================
//====================================Vat-class==================
function vatEdit(id)
{
$('#vat-edit'+id).hide();

$('#vat-save'+id).show();
$('#vat_type_text'+id).hide();
$('#vat_number_text'+id).hide();
$('#vat-refresh'+id).show();
$('#vat_number'+id).show();
$('#vat_type'+id).show();
}

function Vatrefresh(id)
{
$('#vat-edit'+id).show();
$('#vat-save'+id).hide();
$('#vat-refresh'+id).hide();
$('#vat_type_text'+id).show();
$('#vat_number_text'+id).show();
$('#vat_number'+id).hide();
$('#vat_type'+id).hide();
}


function updateVat(id) {
    var vat_number=$("#vat_number"+id).val();
    var vat_type=$("#vat_type"+id).val();

    if (vat_number==null||vat_type==null) {
        alert('Warning!Blank Field must be required.');
            return false;
    }
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        $.ajax({
            url:"vat-class/"+id+"/update",
           type     : "GET",
            cache    : false,
            dataType : 'json',
            data     : {'vat_number': vat_number, 'id': id,'vat_type':vat_type},
                beforeSend: function(){
                loading.show();
            },
            success  : function(data){
                if(data.success == true){
                   $('#vat-edit'+id).show();
              $('#vat-save'+id).hide();
              $('#vat-refresh'+id).hide();
              $('#vat_type_text'+id).show();
              $('#vat_number_text'+id).show();
              $('#vat_number'+id).hide();
              $('#vat_type'+id).hide();
                $('#vat_type_text'+id).html(vat_type);
              $('#vat_number_text'+id).html(vat_number);
                    info_suc.slideDown();
                    info_suc.delay(3000).slideUp(300);

                }
                if(data.success == false){
                    info_err.hide().find('ul').empty();
                    $.each(data.error, function(index, error){
                    info_err.find('ul').append('<li>'+error+'</li>');
                    });
                    info_err.slideDown();
                    info_err.delay(6000).slideUp(300);
                }
                if(data.error == true){
                    db_err.hide().find('label').empty();
                    db_err.find('label').append(data.status);
                    db_err.slideDown();
                    db_err.delay(5000).slideUp(300);
                }
                loading.hide();
            },
            error: function(data){
                alert('error occurred! Please Check');
                loading.hide();
            }
        });

    return false;
}

function deleteVat(id){
  if (confirm('Are you sure you want to delete from database?')) {
$.ajax({
  url: "vat-class/"+id+"/delete",
  dataType:'json',
  success : function(data){
  if(data.success == true){
        delete_msg.slideDown();
        delete_msg.delay(6000).slideUp(300);
        $("#trv_"+id).remove();
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

function deleteWeekType(id){
  if (confirm('Are you sure you want to delete from database?')) {
$.ajax({
  url: "week-types/"+id+"/delete",
  dataType:'json',
  success : function(data){
  if(data.success == true){
        delete_msg.slideDown();
        delete_msg.delay(6000).slideUp(300);
        $("#div_week_type_"+id).remove();
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
