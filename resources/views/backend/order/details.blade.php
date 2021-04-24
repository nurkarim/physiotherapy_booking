@extends('backend.index') @section('content')
<style type="text/css">
    address {
        font-weight: 400;
        letter-spacing: 1px;
    }
    
    li {
        list-style: none;
    }
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">
    <form action="{{url('appointments/Orderupdate')}}" method="post" accept-charset="utf-8">


 <div class="col-md-12">
    <ul class="col-md-5 "><h4 style="letter-spacing: 1px;font-weight: 400;font-size: 24px;">Order <a href="" style="color: #52d862;">#{{$order->id}}</a> Details</h4></ul>
</div>

      <div class="col-md-12">
    <ul class="col-md-6">
        <b>Client:</b>
        <p style="font-weight:400;font-size:22px;color:#52d862">{{$users->first_name}}</p>
        <address style="margin-top: -10px;">{{$users->email}}</address>

            <address class="col-md-6 row">
            <span style="font-weight: bold;">Invoice address</span>
            <p style="">{{$users_address->invoice_address}}</p>
            <p style="margin-top: -10px">{{$users_address->post_code}} {{$users_address->city}}</p>
            <p style="margin-top: -10px">{{$users_address->iCName}}</p>
        </address>

        <address class="col-md-6 row">
            <span style="font-weight: bold;">Shipping address</span>
            <p style="">{{$users_address->shipping_address}}</p>
            <p style="margin-top: -10px">{{$users_address->shipping_post_code}} {{$users_address->shopping_city}}</p>
            <p style="margin-top: -10px">{{$users_address->ScName}}</p>
        </address>

<address class="col-md-6 row" style="">
    <b style="font-weight: 400;font-size: 20px;letter-spacing: 1px;">Order status:</b>
    <p><select style="height: 26px;width: 120px;background-color: #f3f3f3" name="is_paid">
        <option value="0"  @if($order->is_paid==0) selected="" @endif>Unpaid</option>
        <option value="1"  @if($order->is_paid==1) selected="" @endif>Paid</option>
    </select></p>
</address>
<address class="col-md-6 row" style="">
    <b style="font-weight: 400;font-size: 20px;letter-spacing: 1px;">Sourch:</b>
    <p>{{$order->order_sourch}} || Website</p>
</address>

    </ul>

    <ul class="col-md-6" style="border-left: 1px solid #000">
        <b>Reminder:</b>
        <p>Last reminder sent:<span id="sentrminders"> @if(@count($emailSendreminder)>0) <?php echo date("d F Y", strtotime($emailSendreminder->date)); ?> @else never @endif </span></p>
        <p>Send reminder <a href="javascript:void()" onclick="return sendReminder('{{$order->id}}')" title="send reminder" style="font-size: 15px;"><i class="fa  fa-clock-o "></i></a> <span id="msg"></span></p>
        <h4>Invoice:</h4>
        <p>last invoice sent: @if(@count($emailInvoice)>0) <?php echo date("d F Y", strtotime($emailInvoice->date)); ?> @else never @endif </p>
        <p><i class="fa fa-file-pdf-o" style="color: red"></i> invoice.pdf</p>
        <p><a href="{{url('invoices/pdf')}}/{{$order->invoiceId}}/download" title="" target="_blank">Download pdf</a> | <a href="javascript:void()" onclick="return sendPDF('{{$order->id}}')" title="">Send pdf to client</a> <span id="sms"></span></p>
    </ul>
</div>
        <div class="col-md-12" style="">
            <ul class="col-md-12">
                <h4>Products</h4>

                <table class="table" id="cart_table" style="background-color: #f7f5f5;border: 1px solid #ccc;width: 80%">

                    <tr id="app_tr">
                        <td style="border-right: 1px solid #000">
                            <p style="margin-top: 10px;color: #54ea54;font-weight: 400;font-size: 20px;letter-spacing: 1px">{{$appointment->appointment_type}}</p>
                            <li class="col-md-12 row">
                                <p style="margin-top: -10px;color: black;font-weight: 400;font-size: 13px;">start date:
                                    <?php echo date("d M ", strtotime($appointment->date)); ?>,{{$appointment->start_time}}</p>
                                <p style="margin-top: -10px;color: black;font-weight: 400;font-size: 13px;">end date :
                                    <?php echo date("d M ", strtotime($appointment->date)); ?>,{{$appointment->end_time}}</p>
                            </li>
                        </td>
                        <td><samp>{{$appointment->total}} € ({{$appointment->price}}+{{$appointment->vat_price}} vat)</samp>
                           
                        </td>
                        <td>

                        </td>
                    </tr>

                    <tbody id="body_cart">
                        <?php
$cartGtotal=0;
  ?>
                            @if(count($products_cart)>0) @foreach($products_cart as $products_cartValue)
                            <?php
$cartGtotal=$cartGtotal+$products_cartValue->total;
$tot=($products_cartValue->price+$products_cartValue->vat_price);
  ?>
                                <tr id="tr_{{$products_cartValue->id}}">
                                    <td style="border-right: 1px solid #000"><samp><p style="color: #54ea54;font-weight: 400;font-size: 18px;letter-spacing: 1px">{{$products_cartValue->product_name}}</p></samp>
                                        <input type="hidden" value="{{$products_cartValue->id}}" name="product_id_cart[]">
                                        <input type="hidden" value="{{$products_cartValue->product_name}}" name="product_name_cart[]">
                                        <input type="hidden" value="1" name="cart_qty[]">
                                        <input type="hidden" value="{{$products_cartValue->product_vat}}" name="vat_cart[]">
                                        <input type="hidden" value="{{$products_cartValue->vat_price}}" name="cart_vat_price[]">
                                        <input type="hidden" value="{{$tot}}" name="cart_total[]">
                                        <input type="hidden" value="{{$products_cartValue->price}}" name="product_price[]">
                                    </td>
                                    <td><samp>{{$products_cartValue->total}} € ({{number_format($products_cartValue->price,2)}}+{{$products_cartValue->vat_price}} vat)</samp>
                                        <input value="{{$tot}}" class="amt" type="hidden">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-danger" onclick="removeCartFormOrder('{{$products_cartValue->id}}')"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                @endforeach @endif

                    </tbody>

                    <tfoot>
                        <tr>
                            <td>
                                <button class="btn btn-xs" style="background-color: #54ea54;color: white;font-weight: bold;" data-toggle="modal" data-target="#myModal" type="button">+ <samp class="" style="font-weight: 400;font-size: 16px;">Add Product</samp></button>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </ul>

            <ul class="col-md-5" style="background-color: white;">
                <h4>Notes</h4>
                <textarea class="form-control" name="order_note" rows="4" style="background-color:#f7f5f5">{{$order->order_note}}</textarea>
            </ul>
            <ul class="col-md-7" style="background-color: white;">

                <table class="table" style="border-style: hidden;">
                    <tr>
                        <td style="border-style: hidden;width: 20%">Shipping cost</td>
                        <td style="border-style: hidden;width: 2%">:</td>
                        <td style="border-style: hidden;" align="left">
                            <input type="text" name="shippment_cost" placeholder="0.00" style="border:1px solid #000" id="shippment_cost" autocomplete="off" value="{{$appointment->shippment_cost}}"> <span>€</span></td>
                    </tr>
                    <tr>
                        <td style="border-style: hidden;">Btw</td>
                        <td style="border-style: hidden;width: 2%">:</td>
                        <td style="border-style: hidden;" align="left"><span id="vatShow">{{$appointment->grand_vat}}</span> <span>€</span>
                            <input type="hidden" class="vatsum" name="vat_price" id="vat_price_g" value="{{$appointment->grand_vat}}">
                            <input type="hidden" name="vat_number_order" id="vat_price_g" value="{{$appointment->grand_vat}}">
                        </td>
                    </tr>

                    <tr>
                        <td style="border-style: hidden;">Total</td>
                        <td style="border-style: hidden;width: 2%">:</td>
                        <td style="border-style: hidden;" align="left"><span id="sb_total">{{$appointment->grand_total}}</span> <span>€</span>
                            <input type="hidden" class="" name="sub_total" id="sub_total" value="{{$appointment->grand_total}}">
                            <input type="hidden" class="amta" name="sub_total_grand" id="sub_total_grand" value="{{$appointment->grand_total}}">
                        </td>
                    </tr>
                    <tr>
                        <td style="border-style: hidden;">Total with vat</td>
                        <td style="border-style: hidden;width: 2%">:</td>
                        <td style="border-style: hidden;" align="left"><span id="g_total">{{$appointment->grand_total_with_vat}}</span> <span>€</span>
                            <input type="hidden" name="" id="grand_total_amm" value="{{$appointment->grand_total_with_vat}}">
                            <input type="hidden" name="grand_total_ammount" id="grand_total_amm2" value="{{$appointment->grand_total_with_vat}}">

                        </td>
                    </tr>
                </table>
            </ul>
            <ul class="col-md-12">
                <input type="hidden" name="vat_number" id="vat_number">
                <input type="hidden" name="sub_total" id="sub_total">
                <input type="hidden" name="" id="grand_total" value="{{$appointment->grand_total_with_vat}}">

                <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                <input type="hidden" name="appointment_id" id="appointment_id" value="{{$appointment->id}}">
                <button class="btn btn-primary btn-xs" type="submit">save order</button>
            </ul>
        </div>
</div>

</form>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Cart</h4>
            </div>
            <div class="modal-body">
                <table class="table">

                    <tr>
                        <td>Select Product</td>
                        <td>
                            <select name="product_id" class=" chosen-select" onchange="selectProduct()" id="product_id">
                                <option value="">Select Product</option>

                                @foreach($products as $productsValue)
                                <option value="{{$productsValue->id}}">{{$productsValue->product_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="addProduct()">Add cart</button>
            </div>
        </div>

    </div>
</div>

<input type="hidden" id="pdt_price">
<input type="hidden" id="product_name">
<input type="hidden" id="vat_number_product">
<input type="hidden" id="product_id_p">
<input type="hidden" id="cart_grand_total" value="">
<input type="hidden" class="amt" value="{{$appointment->price}}">
<script src="{{url('public/js')}}/chosen.jquery.js"></script>
<script>
    function precise_round(num, decimals) {
        return Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
    }

    function vatSum() {
        var add = 0;
        $(".vatsum").each(function() {
            add += Number($(this).val());
        });
        var sub = precise_round(add, 2);
        $("#vat_price_g").val(sub);
        $("#vat_price_g2").val(sub);
        $("#vatShow").html(sub);
    }

    function sums() {
        var add = 0;
        $(".amt").each(function() {
            add += Number($(this).val());
        });
        var sub = precise_round(add, 2);
        $("#cart_grand_total").val(sub);

        grandTotal(add);

    }

    function sumsSubTotal() {
        var add = 0;
        $(".amta").each(function() {
            add += Number($(this).val());
        });
        var sub = precise_round(add, 2);

        $("#sub_total_grand").val(sub);
        $("#sub_total").val(sub);
        $("#sb_total").html(sub);

    }

    // sums();

    function grandTotal(add) {

        var sub = precise_round(add, 2);
        $("#grand_total_amm2").val(sub);
        $("#grand_total_amm").val(sub);
        $("#g_total").html(sub);

        //withShipmentCost();

    }

    function withShipmentCost() {

        var cost = $("#shippment_cost").val();
        var grand = $("#grand_total_amm2").val();
        var total = (Number(cost) + Number(grand));

        $("#grand_total_amm2").val(total);
        $("#g_total").html(total);

    }

    $('.chosen-select').chosen();

    $('#myModal').on('shown.bs.modal', function() {
        $('.chosen-select', this).chosen('destroy').chosen();
    });

    function addProduct() {
        var pdt_id = $("#product_id_p").val();
        var pdt_price = $("#pdt_price").val();
        var product_name = $("#product_name").val();
        var vat_number_product = $("#vat_number_product").val();
        var vatprice = (Number(pdt_price) * Number(vat_number_product) / 100);
        if (pdt_id == "") {
            alert("please select product");
            return false;
        }
        var total = (Number(pdt_price) + Number(vatprice));
        $("#body_cart").append('<tr id="tr_' + pdt_id + '"><td style="border-right: 1px solid #000"><samp><p style="color: #54ea54;font-weight: 400;font-size: 18px;letter-spacing: 1px">' + product_name + '</p></samp> <input type="hidden" value="' + pdt_id + '" name="product_id_cart[]"> <input type="hidden" value="' + product_name + '" name="product_name_cart[]"><input type="hidden" value="1" name="cart_qty[]"><input type="hidden" value="' + vat_number_product + '" name="vat_cart[]"><input type="hidden" value="' + vatprice + '" name="cart_vat_price[]"><input type="hidden" value="' + total + '" name="cart_total[]"><input type="hidden" value="' + pdt_price + '" name="product_price[]"></td><td><samp>' + total + ' € ( ' + pdt_price + '+' + vatprice + ' vat)</samp><input type="hidden" value="' + total + '" class="amt"><input type="hidden" value="' + vatprice + '" class="vatsum"><input type="hidden" value="' + pdt_price + '" class="amta"></td><td><button type="button" class="btn btn-xs btn-danger" onclick="removeCart(' + pdt_id + ')"><i class="fa fa-times"></i></button></td></tr>');
        sums();
        vatSum();
        sumsSubTotal();
    }

    function removeCart(id) {
        $("#tr_" + id).remove();
        sums();
    }

    function removeCartFormOrder(id) {
        $("#tr_" + id).remove();
        sums();

    }

     function sendPDF(id) {
 if (confirm('Are you sure you want to Send invoice?')) {

    $.ajax({
    url: "{{url('invoice-send')}}/"+id+"/pdf",
    dataType:'json',
    beforeSend: function() {
                   $('#sms').html("wait....");
                },
    success : function(data){
    if (data.success==true) {
    $('#sms').html("Send PDF successfully");
    $('#sentrminders').html("Yes");
    }else{
    $('#sms').html("Sorry!!Invoice Not Found");

    }

    },
    error: function(data){


    }
    });
    return true;
}else{

}
    }



    function sendReminder(id) {
         if (confirm('Are you sure you want to Send Reminder?')) {
    $.ajax({
    url: "{{url('orders-send')}}/"+id+"/reminder",
    dataType:'json',
    beforeSend: function() {
                   $('#msg').html("wait....");
                },
    success : function(data){
    if (data.success==true) {
    $('#msg').html("Send reminder successfully");
    $('#sentrminders').html("Yes");
    }else{
    $('#msg').html("opps!! have network problem");

    }

    },
    error: function(data){


    }
    });
    return true;
    } else{

    }

}

    function selectProduct() {

        var id = $("#product_id").val();
        $.ajax({
            url: "{{url('product-check')}}/" + id + "/select",
            dataType: 'json',
            success: function(data) {
                if (data.success == true) {

                    $('#pdt_price').val(data.price);
                    $('#product_name').val(data.product_name);
                    $('#vat_number_product').val(data.vat_number);
                    $('#product_id_p').val(id);
                }
            }
        });
        return true;
    }

    function makeInvoiceConf(appointmentID, client_id) {
        if (confirm('Are you sure you want to make invoice?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('appointments/makeInvoice/new')}}",
                type: "GET",
                cache: false,
                dataType: 'json',
                data: {
                    'appointment_id': appointmentID,
                    'client_id': client_id
                },

                success: function(data) {
                    if (data.success == true) {
                          info_sucInvoice.hide().find('label').empty();
                    info_sucInvoice.find('label').append(data.status);
                    info_sucInvoice.slideDown();
                    info_sucInvoice.delay(5000).slideUp(300);
                        
                    } else if (data.success == false) {
                       
db_err.hide().find('label').empty();
                    db_err.find('label').append(data.status);
                    db_err.slideDown();
                    db_err.delay(5000).slideUp(300);

                    } else if (data.errors == true) {
                       db_err.hide().find('label').empty();
                    db_err.find('label').append(data.status);
                    db_err.slideDown();
                    db_err.delay(5000).slideUp(300);


                    } else if (data.notyet == true) {
                        
db_err.hide().find('label').empty();
                    db_err.find('label').append(data.status);
                    db_err.slideDown();
                    db_err.delay(5000).slideUp(300);

                    }
                },
                error: function(data) {

                }
            });
            return true;
        } else {
            return false;
        }
    }

    function makeOrder(app_id, client_id) {
        if (confirm('Are you sure you want to make order?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('appointment/makeOrder')}}",
                type: "GET",
                cache: false,
                dataType: 'json',
                data: {
                    'appointment_id': app_id,
                    'client_id': client_id
                },

                success: function(data) {
                    if (data.success == true) {
                    info_sucInvoice.hide().find('label').empty();
                    info_sucInvoice.find('label').append(data.status);
                    info_sucInvoice.slideDown();
                    info_sucInvoice.delay(5000).slideUp(300);
                    
                      
                    } else if (data.success == false) {
                       

                    } else if (data.error == true) {
                    db_err.hide().find('label').empty();
                    db_err.find('label').append(data.status);
                    db_err.slideDown();
                    db_err.delay(5000).slideUp(300);

                    }
                },
                error: function(data) {

                }
            });
            return true;
        } else {
            return false;
        }
    }
</script>

@endsection