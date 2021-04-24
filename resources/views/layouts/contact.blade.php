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
          <h1><span class="red">Jenkiné Contact</span></h1>
          </header>

          
        </div>
      </div>
             
  </div>
</div>

<div class="site-inner"><div class="content-sidebar-wrap"><main class="content">

<article class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry" >


    <div class='entry-content'>
       <div class="row col-md-12">
     <div class="col-md-6">
       <?php
$dfoot=DB::table("company_info")->get();
?>
             <div class="col-md-12">
                <div class="mrg-div"></div>
        <p style="padding-top: -10px;"><a class="navbar-brand" href="#" style="font-family:BLKCHCRY;font-size: 30px;padding: 0px;">Jen<span style="color: #52d862">k</span>ine</a></p>
        <p style="padding-top: -10px;"><i class="fa fa-home"></i> {{$dfoot[0]->address}}
</p>
<p style="padding-top: -10px;"><i class="fa fa-home"></i>
VAT: {{$dfoot[0]->vat_number}}</p>
<p style="padding-top: -10px;"><i class="fa fa-phone"></i> {{$dfoot[0]->contact}}</p>
<p style="padding-top: -10px;"><a href="mailto:{{$dfoot[0]->email}}?subject=feedback" "email me"><i class="fa fa-envelope-open"></i> {{$dfoot[0]->email}}</a></p>
       </div>
     </div>
      <div class="col-md-6">
        <div class="mrg-div"></div>
       <div id="map" style="height:400px;background:yellow" class="col-md-12"></div>

<script>
function myMap() {
var mapOptions = {
    center: new google.maps.LatLng(51.5, -0.12),
    zoom: 10,
    mapTypeId: google.maps.MapTypeId.HYBRID
}
var map = new google.maps.Map(document.getElementById("map"), mapOptions);
}
</script>


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