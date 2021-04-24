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

.category-nav{border-right: 1px solid #000;}

.category-nav li{list-style: none;padding: 3px;}
.category-nav li a{color: black;letter-spacing: 1px}
.product-list div li{list-style: none;text-align: center;}
.product-list div{list-style: none;height: auto;}
.product-grid{margin-top:  10px;}
.pagination{margin-top: 10px;}
.pagination li{padding: 3px 10px;}
.pagination li a{text-decoration: none;font-weight: bold;font-size: 15px;}
.pagination li.active{background-color:black;color: white }
  @media (max-width: 40em){
.site-header{margin-top: -20px;}
  .category-nav{border-right: hidden;}
}


</style>



<div class='bg-img' data-bglg='{{url("public/images/Spartanova-post-LI-copy.jpg")}}' data-bgmd='{{url("public/images/Spartanova-post-LI-copy.jpg")}}'  data-bgsm='{{url("public/images/Spartanova-post-LI-copy-480x320.jpg")}}'>
</div>  

<div class='header-wrap'>
  <div class='header-container'>
      <div class="content-container">
        <div class="content">
          <header class='site-title-block'>
          <h1><span class="red">{{$select_category->name}}</span><br />Select product</h1>
          </header>

          
        </div>
      </div>
             
  </div>
</div>

<div class="site-inner"><div class="content-sidebar-wrap"><main class="content">

<article class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry" >


    <div class='entry-content'>
<div class="row">

    <div class="col-md-3">
        <div class="category-nav">
          @foreach($category as $categoryValue)
            <li><a href="{{url('shop/category')}}/{{$categoryValue->id}}/products">{{$categoryValue->name}}</a> @if($select_category->id==$categoryValue->id)<i class="fa fa-check" style="color: #52d862;font-size: 15px; "></i>@endif</li>
          @endforeach
        </div>
        <ul class="col-md-12">

   <div data-role="main" class="ui-content">
    <form method="post" action="">
      <div data-role="rangeslider">
        <label for="price-min">Price:</label><br>
        <input type="range" class="form-control" name="price-min" id="price-min" value="60" min="0" max="1000" onchange="rangeChabge()">

     <span class="min" style="">€ 0</span>
     <span class="max" style="float: right;">€ 1000</span>
      </div>

      </form>
  </div>
        </ul>
    </div>

    <div class="col-md-9 product-list row">

      <div class="col-md-12">
        <li style="list-style: none">Filter by: 
          <select style="height: 25px;border-style: hidden;">
          <option value="1">Newest first</option>
          <option value="2">Low Price</option>
        </select></li>
      </div>
      <div class="row col-md-12" id="productGride">
        <?php $i=0;

        ?>
        @if(count($products)>0)
        @foreach($products as $productsValue)
                <?php $i=0;
$url=explode(' ',$productsValue->product_name);
$imp=implode($url, '_');
$exp=explode('-', $imp);
$url1=implode($exp, '_');
        ?>
        <div class="col-md-4 col-6 product-grid">
        <a href="{{url('shop/product')}}/{{$productsValue->id}}/{{$url1}}/overview" title="" style="text-decoration: none;">
          <li style="font-size: 15px;font-weight: bold;letter-spacing: 1px;color: #000;padding: 7px 0px;">{{$productsValue->product_name}}</li>
          <li><img src="{{url('public/image/products/display')}}/{{$productsValue->desplay_image}}" alt="" style="height: 190px;width:100%"></li>
          <li style="color: #52d862;font-weight: bold;padding: 7px 0px;">€ {{$productsValue->amount}}</li>
        </a>
        </div>
        @endforeach

</div>
        <div class="col-md-12">
          {{$products->links()}}
        </div>
          @else
     <div class="col-md-12">
          <h4 style="text-align: center; font-size: 17px; color: #101010">Sorry!!Product Not Found</h4>
     </div>
        @endif
    </div>
</div>
    </div>

</article><!-- /article -->

</main></div></div>



</div>

@section('js')
<script type="text/javascript">
  function rangeChabge() {
    var valu=$("#price-min").val();
    $(".min").html("€ "+valu);

$.ajax({
    url: "{{url('check-range-product')}}/"+valu+"",
    dataType:'json',
    beforeSend: function() {
                   $('#msg').html("wait....");
                },
    success : function(data){
    if (data.success==false) {
return false;
         }else{
          $(".product-grid").remove();
       $.each(data, function(index, value) {

$("#productGride").append('<div class="col-md-4 product-grid"><a href="{{url('shop/product')}}/'+value.id+'/'+value.url+'/overview" title="" style="text-decoration: none;"><li style="font-size: 15px;font-weight: bold;letter-spacing: 1px;color: #000;padding: 7px 0px;">'+value.product_name+'</li><li><img src="{{url('public/image/products/display')}}/'+value.desplay_image+'" alt="" style="height: 190px;width:190px"></li><li style="color: #52d862;font-weight: bold;padding: 7px 0px;">€ '+value.amount+'</li></a></div>');

      });

    }

    },
    error: function(data){


    }
    });
    return true;


  }



</script>
<script type='text/javascript' src='{{url("public/js/main.min.js")}}'></script>
@endsection
@endsection