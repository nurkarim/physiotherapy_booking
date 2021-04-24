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
</style>
<script>

</script>


<div class='bg-img' data-bglg='{{url("public/images/Spartanova-post-LI-copy.jpg")}}' data-bgmd='{{url("public/images/Spartanova-post-LI-copy.jpg")}}'  data-bgsm='{{url("public/images/Spartanova-post-LI-copy-480x320.jpg")}}'>
</div>  
<div class="col-md-12" style="height: 20px"></div>
<div class='header-wrap'>
  <div class='header-container'>
      <div class="content-container">
        <div class="content">
          <header class='site-title-block'>
          <h1><span class="red">Jenkiné Webshop</span><br />Select product category</h1>
          </header>

          
        </div>
      </div>
             
  </div>
</div>

<div class="site-inner"><div class="content-sidebar-wrap"><main class="content">

<article class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry" >


    <div class='entry-content'>
          <div class="row col-md-12">

        <?php $i=1; ?>
        @foreach($category as $categoryValue)
        <div class="category-div col-md-4" style="border: 1px solid #ccc">
           <p class="text-center" style="font-weight: bold;padding-top: 10px;font-size: 20px;">{{$categoryValue->name}}</p>
           <p class="text-center" style="margin-top: -20px"><a href="{{url('shop/category')}}/{{$categoryValue->id}}/products" title="" style="font-weight: bold">VIEW ALL</a></p>
           <p class="text-center"><a href="{{url('shop/category')}}/{{$categoryValue->id}}/products" title=""><img src="{{url('public/image/category')}}/{{$categoryValue->image}}" alt="" style="height: 200px;width: 90%"></a></p>
        </div>
        @endforeach

    </div>
    </div>

</article><!-- /article -->

</main></div></div>



</div>

@section('js')

<script type='text/javascript' src='{{url("public/js/main.min.js")}}'></script>
@endsection
@endsection