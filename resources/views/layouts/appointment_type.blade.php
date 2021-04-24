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
          <h1><span class="red">Jenkiné</span><br />Appointment Type</h1>
          </header>

          
        </div>
      </div>
             
  </div>
</div>

<div class="site-inner"><div class="content-sidebar-wrap"><main class="content">

<article class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry" >
  <header class="entry-header">
        <h1 class="entry-title" itemprop="headline">Appointment Types List</h1>
    
    </header>

    <div class='entry-content'>
      <div class="row bg-white category-body">
@foreach($appointment_types as $appointment_typesValue)
    <div class="row col-md-12" style="margin-top: 10px">

<div class="col-md-3">
  @if($appointment_typesValue->image!="")
  <img src="{{url('public/image/appointmentType')}}/{{$appointment_typesValue->image}}" style="height: 100px;">
  @else
   <img src="{{url('public/image/no-image.jpg')}}" style="height: 100px;">

  @endif

</div>

<div class="col-md-7">
<p style="font-weight: bold;font-size: 17px;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif">{{$appointment_typesValue->type_name}}</p>
  <p style="font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size: 14px;">@if($appointment_typesValue->description=="")oops!!Not found details. @else {{$appointment_typesValue->description}}@endif</p>

</div>

    </div>
    @endforeach

    <div class="col-md-12">
      {{ $appointment_types->links() }}
    </div>
</div>
    </div>

</article><!-- /article -->

</main></div></div>



</div>

@section('js')

<script type='text/javascript' src='{{url("public/js/main.min.js")}}'></script>
@endsection
@endsection