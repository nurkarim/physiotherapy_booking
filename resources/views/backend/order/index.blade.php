@extends('backend.index')
@section('content')
<style type="text/css">
table th{font-weight: 400;font-size: 13px;letter-spacing: 1px;}
table tr td{font-weight: 400;font-size: 13px;letter-spacing: 1px;color: black}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">
<div class="applist_container">
<div class="row">
<div class="col-md-12">
	<h4 style="font-weight: 400;">Orders</h4>
	<p><a href="{{url('invoices')}}">view invoices list</a></p>
{{-- 	<p class="pull-right"><button type="button" class="btn btn-danger fa fa-trash btn-delete"> Delete</button></p> --}}
</div>

<div class="col-md-12">
	<table class="table table-bordered " id="dataTables-example" style="margin-top: 10px;">
		<thead>
			<tr style="background-color: black;color: white">
				<th style="width: 3%"><input type="checkbox" name="" id="checkAll"></th>
				<th>Order</th>
				<th>Invoice</th>
				<th>Order Made By</th>
				<th>Date</th>
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

$appointments=DB::table('appointments')->where('order_id',$dataValue->id)->get();
			?>
			<tr>
				<td><input id='one_{{$dataValue->id}}' type='checkbox'  name="{{$dataValue->id}}" />
					<label for='one_{{$dataValue->id}}'>
						<span></span>

					</label></td>
				<td><a href="{{url('orders')}}/{{$dataValue->id}}/details">#{{ $dataValue->id}}</a></td>
				<td>@if(isset($dataValue->invoiceId))<a href="{{url('invoices')}}/{{$dataValue->invoiceId}}/details">#{{ $dataValue->invoiceId}}</a>@endif</td>
				<td>{{ $dataValue->first_name}}<p>{{ $dataValue->email}}</p></td>
				<td><?php echo date("F d, Y", strtotime($dataValue->date)); ?></td>
				<td>
					{{ $dataValue->appointment_type}}

<?php
$j=0;
$i=0;
foreach ($appointments as $key => $values) {
	if ($i==2) {
		break;
	}
	echo $values->appointment_type.',';

	$i++;
}
?>

<?php
$j=0;
foreach ($product as $key => $value) {
	if ($j==3) {
		break;
	}
	echo $value->product_name.',';

	$j++;
}
?>
				</td>
				<td>{{ $dataValue->total}} €</td>
				<td>{{$dataValue->mollie_status}}</td>
				<td>
							@if($dataValue->is_paid==1)

				@else
				<a class="btn btn-xs btn-default" href="#"><i class="fa  fa-clock-o "></i></a>

				@endif
				<a class="btn btn-xs btn-default" href="{{url('orders')}}/{{$dataValue->id}}/details"><i class="fa fa-search"></i></a>@if(isset($dataValue->invoiceId))
				<a target="_blank" href="{{url('invoices')}}/{{$dataValue->invoiceId}}/pdf" class="btn btn-xs btn-danger"><i class="fa fa-file-pdf-o"></i>
				</a>@endif

				</td>
			</tr>
			@endforeach
		</tbody>
	</table>


</div>
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
