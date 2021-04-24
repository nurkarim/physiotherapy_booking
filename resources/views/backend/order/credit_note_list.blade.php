@extends('backend.index')
@section('content')
<style type="text/css">
table th{font-weight: 400;font-size: 13px;letter-spacing: 1px;}
table tr td{font-weight: 400;font-size: 13px;letter-spacing: 1px;color: black}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
<div class="col-md-12">
	<h4 style="font-weight: 400;">Credit note List</h4>

</div>

<div class="col-md-12">
	<table class="table table-bordered " id="dataTables-example" style="margin-top: 10px;">
		<thead>
			<tr style="background-color: black;color: white">
				<th style="width: 3%"><input type="checkbox" name="" id="checkAll"></th>
				<th>Order</th>
				<th>Credit</th>
				<th>Order Made By</th>
				<th>Booking date</th>
				<th>Order Date</th>
				<th>Product</th>
				<th>Total</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
<?php $i=1; ?>
		@foreach($data as $dataValue)
		<?php
$product=DB::table('order_product_cart')
->select('product_name')
->where('order_id',$dataValue->id)
->get();
$arry=array();

			?>
			<tr>
				<td align="center"><input type="checkbox" name=""></td>
				<td><a href="{{url('orders')}}/{{$dataValue->id}}/details">#{{$dataValue->id}}</a></td>
				<td><a href="{{url('credit-note-details')}}/{{$dataValue->cId}}">#{{$dataValue->cId}}</a></td>
				<td>{{ $dataValue->first_name}}<p>{{ $dataValue->email}}</p></td>
				<td><?php echo date("d M ", strtotime($dataValue->bookingDate)); ?><br>

					<b>{{$dataValue->start_time}}-{{$dataValue->end_time}}</b>
				</td>
				<td><?php echo date("d M ", strtotime($dataValue->date)); ?></td>
				<td>{{ $dataValue->appointment_type}},
<?php
$j=0;
foreach ($product as $key => $value) {
	if ($j==2) {
		break;
	}
	echo $value->product_name.',';

	$j++;
}
?></td>
				<td>{{ $dataValue->total}} €</td>
				<td>@if($dataValue->is_paid==1)
<span>Paid</span>
@else
<span>UnPaid</span>


					@endif</td>
				<td>
				<a href="{{url('orders')}}/{{$dataValue->id}}/details" class="btn btn-xs btn-default"><i class="fa fa-check-square-o"></i></a>
				<a href="{{url('credit/pdf')}}/{{$dataValue->appoitment_id}}/download" class="btn btn-xs btn-danger"><i class="fa fa-file-pdf-o"></i></a>
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
       $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
    </script>

@endsection
