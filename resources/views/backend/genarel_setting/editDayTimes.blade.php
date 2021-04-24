{!! Form::open(['url'=>URL::to('weekTypesDayTimesUpdate'),'id'=>'myForm']) !!}
<input type="hidden" name="days_id" value="{{$dayId}}">
<input type="hidden" name="weekType_id" value="{{$weekTypeId}}">
<table class="table">
     <thead>
       <tr>
         <th>Start Time</th>
         <th>End Time</th>
         <th><button type="button" class="btn btn-xs btn-danger fa fa-plus" onclick="addMorenew()" ></button></th>
       </tr>
     </thead>
     <tbody id="tbody1">
     	@if(count($weekDays)>0)
@foreach($weekDays as $weekDaysValues)
 <tr id="tr">

         <td>
       
          <select name="start_time[]" class="form-control">
@foreach($select_time as $select_timeValues)
<option value="{{$select_timeValues->name}}" @if($weekDaysValues->start_time==$select_timeValues->name) selected="" @endif>{{$select_timeValues->name}}</option>
@endforeach     
          </select>

         </td>
         <td>
        
      <select name="end_time[]" class="form-control">
@foreach($select_time as $select_timeValues)
<option value="{{$select_timeValues->name}}" @if($weekDaysValues->end_time==$select_timeValues->name) selected="" @endif>{{$select_timeValues->name}}</option>
@endforeach     
          </select>
         </td>
         <td></td>
       </tr>
@endforeach
     	@else
       <tr id="tr1">

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
       @endif
     </tbody>
   </table>
   <div class="modal-footer">
  <button type="submit" class="btn btn-success">update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    {!! Form::close() !!}