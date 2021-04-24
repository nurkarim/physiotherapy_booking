@extends('backend.index')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('public/css/product.css')}}">
    <style type="text/css">
      #image-preview {

        width: 200px;
        height: 200px;
        position: relative;
        overflow: hidden;

        background-size: 100%;
        color: #000;
        border: 1px solid #ccc;
        margin-left: 20px;
        margin-top: 10px;
      }
  </style>
  <link href="{{url('public')}}/css/app.css" rel="stylesheet">

<div class="row">

         {!! Form::model($product,['url'=>['products',$product->id],'id'=>'myForm','method'=>'PUT','files'=>true]) !!}
 <div class="col-md-12">
  <div class="col-md-12"><h4>Product Details</h4></div>
  <div class="col-md-4">
    <h4 style="font-weight: 400;color: #52d862;letter-spacing: 1px;">{{$product->product_name}}</h4>
     <div class="input_fields_wrap col-md-12">

        <div id="image-preview" class="" title="{{$product->desplay_image}}" style="background-image: url(<?php echo url('public/image/products/display')."/".$product->desplay_image; ?>);background-size: 100%">
                                        <label for="image-upload" id="image-label">Product Image</label>
                                        <input type="file" name="image_file" id="image-upload"   />
         </div>

        </div>
        <div class="col-md-12 row" style="margin-top: 10px;">
          <?php $i=1; ?>
  @foreach($images as $imagesValue)

<div  id="image_{{$imagesValue->id}}" style="padding: 0px;" >
<ul  class="image_preview_{{$imagesValue->id}} " title="click image for remove" style="width: 100px;float: left;clear: right;margin-left: 5px;border:2px solid #000;padding: 0px;">
  <img onclick="deleteImages('{{$imagesValue->id}}')" style="height: 100px;width:98px;padding: 0px;background-size: 100%;cursor: pointer;" src="<?php echo url('public/image/products')."/".$imagesValue->image; ?>" alt="">
</ul>
 </div>  <?php if ($i==2) {
  echo "</div><div style='margin-top: 10px;'>";
  } ?>
 @endforeach
        </div>
        <div class="input_fields_wrap2 col-md-12">
                <div class="col-md-12 row" style="margin-top:10px"><ul id="image-preview1" "><label for="image-upload1" id="image-label1">coming soon</label><input type="file" name="image_path[]" id="image-upload1" multiple="multiple" /></ul> </div>


        </div>

  </div>
   <div class="col-md-8">
    <style type="text/css">
      #cke_editor{height: 150px;border-bottom: 1px solid #000}
      #cke_editor1{height: 150px;border-bottom: 1px solid #000}

      #cke_2_bottom{display: none;}
      #cke_bottom{display: none;}
    </style>
    <select style="background-color: #f3f3f3;height: 26px;width: 260px;margin-top: 10px;" name="category_id" required="">
      <option value="">Product Category</option>
                          @foreach($category as $value)
                          <option value="{{ $value->id}}" @if($product->category_id==$value->id) selected="" @endif>{{ $value->name}}</option>
                          @endforeach
                        </select>
                           <div class="col-md-12 row" style="margin-top: 10px">
        <label style="font-weight: 400;color: black">Short description</label>
        <textarea class="form-control" rows="3" id="editor" name="short_description" required="">{{$product->short_description}}</textarea>
      </div>
       <div class="col-md-12 row" style="margin-top: 10px">
        <label style="font-weight: 400;color: black">Description</label>
        <textarea class="form-control" rows="3" id="editor1" name="description" required="">{{$product->description}}</textarea>
      </div>
  </div>
 </div>
<div class="col-md-12" style="border-top: 1px solid #000;margin-top: 10px;">
  <ul class="col-md-12"><b style="font-size: 16px;">Main Version</b></ul>
<div class="col-md-12">
<table class="table" style="border-style: hidden;">
    <tr>
    <td>Name</td>
    <td><input type="text" name="product_name" placeholder="    Product Name  " required="" style="width: 150px;height: 28px" value="{{$product->product_name}}"></td></td>
    <td>Base Price</td>
    <td><input type="text" name="amount" placeholder="    Base Price    " required="" style="width: 150px;height: 28px" value="{{$product->amount}}"> €</td>

    <td><span>VAT CLASS</span><select style="background-color: #f3f3f3;height: 26px;width: 150px;" name="vat_number" required="">

                        @foreach($vat as $valueVat)
                          <option value="{{ $valueVat->vat_number}}"  @if($product->vat_number==$valueVat->vat_number) selected="" @endif>{{ $valueVat->vat_number}}</option>
                          @endforeach
                         </select>
                       </td>
    <td><div class="checkbox checkbox-info checkbox-circle">
                        <input id="checkbox8" type="checkbox" @if($product->is_veriable_product==1) checked="" @endif value="1" name="is_veriable_product">
                        <label for="checkbox8">
                          Variable product
                        </label>
          </div></td>

  </tr>
</table>
</div>
</div>

 <div class="col-md-12 ">
      <div class="col-md-6">
        <div class="form-group table-responsive">
        <h4 style="font-weight: bold;color: black">Options</h4>
     <table class="table " style="border-style: hidden;width: 60%">
       <tr style="height: 18px;">
         <td style="font-weight: 400;font-size: 14px;color: black">Option name</td>
         <td style="font-weight: 400;font-size: 14px;color: black">Option price</td>
         <td style="font-weight: 400;font-size: 14px;color: black"></td>
       </tr>
      <tbody id="option_body">
     @foreach($optionProduct as $optionProductValue)
     <tr style="height: 18px;" id="option_tr{{$optionProductValue->id}}">
      <td style="font-weight: 400;font-size: 14px;color: black"><input type="text" name="option_name[]" value="{{$optionProductValue->name}}"></td><td style="font-weight: 400;font-size: 14px;color: black"><input type="text" name="option_price[]" value="{{$optionProductValue->amount}}"></td><td style="font-weight: 400;font-size: 14px;color: black"><button type="button" class="btn-xs btn " id="btn_remove" onclick="removeOption('{{$optionProductValue->id}}')"><i class="fa fa-remove" style="color: red"></i></button></td>
     </tr>
     @endforeach
      </tbody>
       <tr>
         <td colspan="2"><a class="btn btn-sm add_more" style="color: white;padding-left: 10px;background-color: #52d862" ><i class="fa fa-plus" style="padding: 2px"></i> <i class="" style="padding: 7px;background-color: white;color:black">Add option</i></a></td>
       </tr>
     </table>
        </div>
      </div>
      <div class="col-md-6" style="border-left: 2px solid #000">
      <div class="col-md-12"><h4 style="font-weight: bold;color: black">Related products</h4></div>
    <div id="product_div" class="row">
 @foreach($reletedProduct as $reletedProductValue)
 <div class="col-md-12" id="div_product{{$reletedProductValue->releted_product_id}}" style="margin-top: 6px;">
  <div class="col-md-8 col-xs-9"><span id="product_title">{{$reletedProductValue->product_name}}</span><input type="hidden" name="product_id[]" id="product_id" value="{{$reletedProductValue->releted_product_id}}"></div><div class="col-md-4 col-xs-3"><button type="button" class="btn btn-sm" style="background-color: red" onclick="removeProduct('{{$reletedProductValue->releted_product_id}}')"><i class="fa fa-remove" style="color: white"></i></button></div>
</div>
@endforeach
    </div>
        <div class="col-md-12" >
     <div class="col-md-7" style=""><br>
           <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search..." id="search">
                                <span class="input-group-btn">

                                   <button class="btn btn-default add_product" type="button" >
                                    <i class="fa fa-plus"></i>
                                </button>
                            </span>
          </div>
          <input type="hidden"  id="pdt_id">
          <input type="hidden"  id="pdt_name">
     </div>
        </div>
      </div>

    </div>
    <div class="col-md-12">
           <ul class="list-inline pull-right">

                            <li><button type="submit" class="btn " style="background-color: #52d862;color: white">Save Product</button></li>
                        </ul>
    </div>
   {!! Form::close() !!}
</div>

<script type="text/javascript" src="{{URL::to('/')}}/public/js/jquery.uploadPreview.min.js"></script>
   <script src="{{URL::to('/')}}/public/ckeditor/ckeditor.js"></script>
<style type="text/css">
  #cke_1_contents{height: 100px;}
  #cke_2_contents{height: 100px;}
  #cke_1_bottom{display: none;}
.btn-deletes{border-style: none;margin-left: 20px;margin-top: -10px;}
      #image-preview1 {

        width: 100px;
        height: 100px;
        position: relative;
        overflow: hidden;
        background-image: url('{{url('public/image/add-button-512.png')}}');
        background-size: 100%;
        color: #000;
        border: 1px solid #ccc;
        margin-left: 20px;
        margin-top: 10px;
      }
    #image-preview1 input {
        line-height: 200px;
        font-size: 200px;
        position: absolute;
        opacity: 0;
        z-index: 10;
    }

    #image-label1 {
        position: absolute;
        z-index: 5;
        opacity: 0.8;
        cursor: pointer;
        background-color: #bdc3c7;
        width: 100px;
        height: 50px;
        font-size: 12px;
        line-height: 50px;
        text-transform: uppercase;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        text-align: center;
    }
</style>
       <script type="text/javascript">


jQuery(document).ready(function() {
    src = "{{ url('searchajax') }}";
     jQuery("#search").autocomplete({
        source: function(request, response) {
            jQuery.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
                },
                success: function(data) {
                     response(data);
                    return false;
                }
            });

        },
        min_length: 3,
       select: function( event, ui ) {
        $( "#pdt_id" ).val( ui.item.id );
        $( "#pdt_name" ).val( ui.item.value );
        $( "#search" ).val( ui.item.value );


        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      if(item.num>0){
      return $( "<li>" )
        .append( "<div>" + item.value + "</div>" )
        .appendTo( ul );
      }else{
      return $('<li>').append("<div>No Result Found</div>").appendTo( ul );

      }

    };
});





$(document).ready(function() {
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose Image", // Default: Choose File
            label_selected: "Change Image", // Default: Change File
            no_label: false // Default: false
        });

    });
</script>
                                </script>


  <script type="text/javascript">

$(document).ready(function() {
    var max_f     = 10; //maximum input boxes allowed
   var opption=$("#option_body");
    var add_more      = $(".add_more"); //Add button ID

    var a = 1; //initlal text box count
    $(add_more).click(function(e){ //on add input button click
        e.preventDefault();
        if(a < max_f){ //max input box allowed
            a++; //text box increment
            $(opption).append('<tr style="height: 18px;" id="option_tr'+a+'"><td style="font-weight: 400;font-size: 14px;color: black"><input type="text" name="option_name[]"></td><td style="font-weight: 400;font-size: 14px;color: black"><input type="text" name="option_price[]"></td><td style="font-weight: 400;font-size: 14px;color: black"><button type="button" class="btn-xs btn " id="btn_remove" onclick="removeOption('+a+')" ><i class="fa fa-remove" style="color: red"></i></button></td></tr>'); //add input box
        }
    });

    var max_p          = 10; //maximum input boxes allowed
   var product_div     =$("#product_div");
  var add_product      = $(".add_product"); //Add button ID

    var b = 1; //initlal text box count

    $(add_product).click(function(e){ //on add input button click

        e.preventDefault();

        if(b < max_p){ //max input box allowed
            b++; //text box increment
             var pdt_id      =$("#pdt_id").val();
              var pdt_name   = $("#pdt_name").val(); //Add button ID

            $(product_div).append('<div class="col-md-12" id="div_product'+b+'"><div class="col-md-8 col-xs-9"><span id="product_title">'+pdt_name+'</span><input type="hidden" name="product_id[]" id="product_id" value="'+pdt_id+'"></div><div class="col-md-4 col-xs-3"><button type="button" class="btn btn-sm"  style="background-color: red" onclick="removeProduct('+b+')"><i class="fa fa-remove" style="color: white"></i></button></div></div><div class="col-md-12" style="height:10px;"></div>');
        }
    });


});

function removeProduct(id){ //user click on remove text

        $("#div_product"+id).remove();
        b--;
    }

function removeOption(id){ //user click on remove text

        $("#option_tr"+id).remove();
        a--;
    }



   CKEDITOR.replace('editor');
 CKEDITOR.replace('editor1');

  $(document).ready(

    function()
    {
      $('#redactor').redactor();
    }
  );

function deleteImages(id) {
  if (confirm('Are you sure you want to delete from database?')) {
$.ajax({
  url: "{{url('products/images')}}/"+id+"/delete",
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
