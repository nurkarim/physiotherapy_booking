@extends('layouts.app')
@section('content')

    <style type="text/css">
img.wp-smiley,
img.emoji {
  display: inline !important;
  border: none !important;
  box-shadow: none !important;
  height: 1em !important;
  width: 1em !important;
  margin: 0 .07em !important;
  vertical-align: -0.1em !important;
  background: none !important;
  padding: 0 !important;
}
</style>

<body><div class="site-container"><style>
  .openForm .appointment_form{height:250px;}
  .openForm .appointment_form.large{height:270px;}
  p.appointment-info{margin:15px 0;}

  .appointment_form .left{
  }

  .appointment_form a.btn{margin-top:10px;}

  #newclients_wrap .close{
    display: none;
  }

  #newclients_links{
    margin: 15px 0;
  }

  #newclients_links a{
    display:block;
    color: white;
    margin: 5px 10px 5px 0;
  }


  @media (max-width: 40em){
    .openForm .appointment_form {
      height: 300px;
    }
    .openForm .appointment_form.large{
      height: 330px;
    }

    .appointment_form .wrap .part.right{
      margin-top:15px;
    }
  }

  .category-nav{border-right: 1px solid #000;}
.category-nav li{list-style: none;padding: 3px;}
.category-nav li a{color: black;letter-spacing: 1px}
.product-list div li{list-style: none;text-align: center;}
.product-list div{list-style: none;}
.product-grid{margin-top:  10px;}
li{list-style: none;}
</style>



<div class='bg-img' data-bglg='{{url("public/images/Spartanova-post-LI-copy.jpg")}}' data-bgmd='{{url("public/images/Spartanova-post-LI-copy.jpg")}}'  data-bgsm='{{url("public/images/Spartanova-post-LI-copy-480x320.jpg")}}'>
</div>  

<div class='header-wrap'>
  <div class='header-container'>
      <div class="content-container">
        <div class="content">
          <header class='site-title-block'>
          <h1><span class="red">Jenkiné Webshop</span><br />Product Overview</h1>
          </header>

          
        </div>
      </div>
             
  </div>
</div>

<div class="site-inner"><div class="content-sidebar-wrap"><main class="content">

<article class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry" >
  @include('layouts.ajaxMsg')
    <div class='entry-content'>
      <div class="row">
    <div class="col-md-3">
        <div class="category-nav">
         @foreach($category as $categoryValue)
            <li><a href="{{url('shop/category')}}/{{$categoryValue->id}}/products">{{$categoryValue->name}}</a> </li>
          @endforeach
        </div>
    </div>

    <div class="col-md-9  row">
      <div class="col-md-12 row">
        <div class="col-md-5">
          <li style="list-style: none;"><img src="{{url('public/image/products/display')}}/{{$product->desplay_image}}" alt="" style="height: 250px;width: 100%"></li>

        <li style="overflow: auto" style="width: 300px;">
          @if(count($product_image)>0)
          <?php  $j=1;?>
          @foreach($product_image as $product_imageValue)
          <?php if ($j==3) {
            break;
          } ?>
          <img src="{{url('public/image/products')}}/{{$product_imageValue->image}}" alt="" style="height: 100px;width: 92px">
          <?php $j++; ?>
          @endforeach
        @endif
        </li>
        </div>
        <div class="col-md-7">
          <li  style="list-style: none;"><h4>{{$product->product_name}}</h4>
<input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
<input type="hidden" name="product_name" id="product_name" value="{{$product->product_name}}">
<input type="hidden" name="product_image" id="product_image" value="{{$product->desplay_image}}">
          </li>

            <li style="list-style: none;font-size: 14px;font-weight: bold;letter-spacing: 1px">Short description</li>
            <li style="list-style: none;font-weight: 400;font-size: 16px;color: #000">


<?php
                                  $stringem=$product->short_description;

                                                        $a=array("\r\n", "\n", "\r");
                                                        $replace='';
                                                        $abouten=str_replace($a, $replace, $stringem);
                                                        print  '<span style="">'.$abouten.'</span>';



                                  ?>
            </li>
            <li style="font-size: 16px;font-weight: bold;">Select options</li>
            <li>
            <select name="option_products" style="height: 30px;width: 200px;" id="option_products" onchange="selectOptionPrice()">
              <option value="0">select option</option>}

              @foreach($option_product as $option_productValue)
              <option value="{{$option_productValue->id}}">{{$option_productValue->name}}</option>
            @endforeach
            </select>
            </li>

          <li style="color: #52d862;font-weight: bold;margin-top: 10px;font-size: 20px">€ <b class="price">{{$product->amount}}</b><input type="hidden" id="product_price" name="product_price" value="{{$product->amount}}"></li>
          <li style="margin-top: 10px;"><a class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862" href="javascript:void()" onclick="addcart()"> <i class="" style="padding: 4px 20px;background-color: white;color:black">Add to cart</i><i class="fa  fa-shopping-basket" style="padding: 2px 6px"></i></a></li>
        </div>
      </div>
<div class="col-md-12">
      <div class="mrg-div"></div>
      <div class="mrg-div"></div>

  <h4 style="font-weight: bold;font-size: 25px;">Description</h4>


<?php
                                  $description=$product->description;

                                                        $b=array("\r\n", "\n", "\r");
                                                        $replaces='';
                                                        $result=str_replace($b, $replaces, $description);
                                                        print  '<span style="">'.$result.'</span>';



                                  ?>
</div>

   <div class="col-md-12 product-list row">
    <ul style="border-bottom: 1px solid #000;color: #000;font-size: 18px;font-weight: bold" class="col-md-10 ">Related products</ul>

        @foreach($releted_product as $releted_productValue)
                        <?php $i=0;
$url=explode(' ',$releted_productValue->product_name);
$imp=implode($url, '_');
$exp=explode('-', $imp);
$url1=implode($exp, '_');
        ?>
        <div class="col-md-4 product-grid row">
        <a href="{{url('shop/product')}}/{{$releted_productValue->productId}}/{{$url1}}/overview" title="" style="text-decoration: none;">
          <li style="font-size: 15px;font-weight: bold;letter-spacing: 1px;color: #000;padding: 7px 0px;">{{$releted_productValue->product_name}}</li>
          <li><img src="{{url('public/image/products/display')}}/{{$releted_productValue->desplay_image}}" alt=""  style="height: 190px;width:190px"></li>
          <li style="color: #52d862;font-weight: bold;padding: 7px 0px;">€ {{$releted_productValue->amount}}</li>
        </a>
        </div>
        @endforeach


   </div>

    </div>
</div>
<input type="hidden" name="" id="vat_class" value="{{$product->vat_number}}">
    </div>

</article><!-- /article -->

</main></div></div>



</div>

@section('js')

<script type='text/javascript' src='{{url("public/js/main.min.js")}}'></script>
      <script type="text/javascript">
    var inactive_msg = $('.inactive-msg');
    var active_msg   = $('.active-msg');
    var active_msg2   = $('.sms-nochange');
    var loading      = $('.loading');
    var info_err     = $('.info-error');
    var info_suc     = $('.info-suc');
    var app_suc     = $('.app-suc');
    var delete_msg     = $('.delete-msg');
    var err_delete_msg     = $('.err-delete-msg');
    var db_err     = $('.sms-nochange');</script>
<script type="text/javascript" charset="utf-8" >



 function addcart() {
    var product_id=$("#product_id").val();
    var product_name=$("#product_name").val();
    var product_image=$("#product_image").val();
    var option_products=$("#option_products").val();
    var option_products_html= $('#option_products').find(":selected").text();
    var product_price=$("#product_price").val();
    var vat_class=$("#vat_class").val();

    if (option_products==null) {
    alert('Warning!Please select a option product');
    return false;
    }
    $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    $.ajax({
    url:"{{url('add-to-shop')}}",
    type     : "GET",
    cache    : false,
    dataType : 'json',
    data     : {'product_id': product_id,'product_name':product_name,'product_image':product_image,'option_products':option_products,'product_price':product_price,'vat_class':vat_class,'option_products_html':option_products_html},

    success  : function(data){

    if (data.success==true) {

        info_suc.slideDown();
        info_suc.delay(6000).slideUp(300);
    }else if(data.success==false){

    }
    },
    error: function(data){


    }
    });
    return false;
    }

    function selectOptionPrice() {

    var id=$("#option_products").val();
    $.ajax({
    url: "{{url('option-product')}}/"+id+"/select",
    dataType:'json',
    success : function(data){

    $('.price').html(data.price);
    $('#product_price').val(data.price);

    }
    });
    return true;
    }



</script>

@endsection
@endsection