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

<style type="text/css" media="screen">
    .cart ul li{list-style: none;padding: 10px;}
    .cart-ul {border: 1px solid #000}
    .cart{
    float: none;
    margin: 0 auto;
}
.checkout-table tr td{border-style: hidden;}
table tr td{border-style: hidden;}
table tr th{border-style: hidden;}
table  {padding: 0px;margin: 0px;}
table{border-style: hidden;}
li{list-style: none;}
</style>



<div class='bg-img' data-bglg='{{url("public/images/Spartanova-post-LI-copy.jpg")}}' data-bgmd='{{url("public/images/Spartanova-post-LI-copy.jpg")}}'  data-bgsm='{{url("public/images/Spartanova-post-LI-copy-480x320.jpg")}}'>
</div>  

<div class='header-wrap'>
  <div class='header-container'>
      <div class="content-container">
        <div class="content">
          <header class='site-title-block'>
          <h1><span class="red">Jenkiné </span><br />create Account</h1>
          </header>

          
        </div>
      </div>
             
  </div>
</div>

<div class="site-inner"><div class="content-sidebar-wrap"><main class="content">

<article class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry" >


    <div class='entry-content'>
        @include('errors.messages')
 {!! Form::open(['url'=>URL::to('create-account'),'id'=>'myForm','files'=>true]) !!}


<div class="row col-md-12" style="margin: auto;padding: 0px;">
    <p><a href="{{url('login')}}" title="" style="font-weight: bold;">Returning client? Click here to login.</a></p>
    <div class="col-md-12 row">


    <table class="table checkout-table " style="border-style: hidden;">

            <tr>
                <th colspan="2">Personal information:</th>
            </tr>

            <tr>
                <td style="width: 15%">Name <em style="color: red">*</em>:</td>

                <td><input type="text" style="height: 35px;width: 200px;background-color: #f1f1f1" name="first_name" class="form-control" required=""></td>
            </tr>
                 <tr>
                <td style="width: 10%">Last name <em style="color: red">*</em>:</td>

                <td><input type="text" style="height: 35px;width: 200px;background-color: #f1f1f1" name="last_name" class="form-control" required=""></td>
            </tr>
                 <tr>
                <td style="width: 10%">Email <em style="color: red">*</em>:</td>

                <td><input type="text" style="height: 35px;width: 200px;background-color: #f1f1f1" name="email" class="form-control" required=""></td>
            </tr>
                 <tr>
                <td style="width: 10%" for="vat_number">VAT-number <em style="color: red">*</em>:</td>

                <td><input type="text" style="height: 35px;width: 200px;background-color: #f1f1f1" name="vat_number" class="form-control" id="vat_number"  ><span id="errmsg" style="color: red"></span></td>
            </tr>

            <tr id="">
                <td style="width: 10%">Password <em style="color: red">*</em>:</td>

                <td><input type="text" style="height: 35px;width: 200px;background-color: #f1f1f1" name="password" class="form-control" minlength="4"></td>
            </tr>
    </table>
    </div>
    <div class="col-md-12 row">


        <div class="col-md-6 row">



    <table class="table row">

            <tr>
                <th  style="width: 100%">Invoice Adress:</th>

            </tr>

        <tbody>
            <tr>
                <td>
                    <table>

                        <tr>
                            <td>Adress <em style="color: red">*</em>:</td>
                            <td><input type="text" style="height: 35px;width: 220px;background-color: #f1f1f1" name="address" class="form-control" id="address" required=""></td>
                        </tr>
                          <tr>
                            <td>Postal number <em style="color: red">*</em>:</td>
                            <td><input type="text" style="height: 35px;width: 220px;background-color: #f1f1f1" name="post_code" class="form-control" id="post_code" required="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"></td>
                        </tr>
                          <tr>
                            <td>City <em style="color: red">*</em>:</td>
                            <td><input type="text" style="height: 35px;width: 220px;background-color: #f1f1f1" name="city" class="form-control" id="city" required=""></td>
                        </tr>
                        <tr>
                            <td>Country <em style="color: red">*</em>:</td>
                            <td>
<select style="height: 30px;width: 220px;background-color: #f1f1f1" name="country"  id="country" >
    @foreach($country as $countryValue)
    <option value="{{$countryValue->id}}">{{$countryValue->name}}</option>
    @endforeach
</select>
                            </td>
                        </tr>

                </table></td>

            </tr>
        </tbody>
    </table>
      </div>
      <div class="col-md-6 row">



    <table class="table row">

            <tr>

                <th style="width: 100%">Shipping Adress <em style="color: red">*</em>: <input type="checkbox" name="checkbox_check" class="checkbox_check" onclick="sameAddress()"> Use same as invoice adress</th>
            </tr>

        <tbody>
            <tr>

                <td> <table>

                        <tr>
                            <td>Adress <em style="color: red">*</em>:</td>
                            <td><input type="text" style="height: 35px;width: 220px;background-color: #f1f1f1" name="s_address" class="form-control" id="s_address" required=""></td>
                        </tr>
                          <tr>
                            <td>Postal number <em style="color: red">*</em>:</td>
                            <td><input type="text" style="height: 35px;width: 220px;background-color: #f1f1f1" name="s_post" class="form-control" id="s_post" required="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"></td>
                        </tr>
                          <tr>
                            <td>City <em style="color: red">*</em>:</td>
                            <td><input type="text" style="height: 35px;width: 220px;background-color: #f1f1f1" name="s_city" class="form-control" id=s_city required=""></td>
                        </tr>
                        <tr>
                            <td>Country <em style="color: red">*</em>:</td>
                            <td>
<select style="height: 30px;width: 220px;background-color: #f1f1f1" name="s_country"  id="s_country" onchange="countryAccVat()">
  @foreach($country as $countryValue)
    <option value="{{$countryValue->id}}">{{$countryValue->name}}</option>
    @endforeach

</select>
                            </td>
                        </tr>

                </table></td>
            </tr>
        </tbody>
    </table>


    <script>
    function sameAddress() {
        if ($('input.checkbox_check').is(':checked')) {
           var address=$("#address").val();
           var post_code=$("#post_code").val();
           var city=$("#city").val();


         $("#s_address").val(address);
         $("#s_post").val(post_code);
         $("#s_city").val(city);
      }else{
         $("#s_address").val(" ");
         $("#s_post").val(" ");
         $("#s_city").val(" ");
      }
        }
    </script>
      </div>

          <li style="margin-top: 10px;"><button type="submit" class="btn btn-sm" style="color: white;padding-left: 10px;background-color: #52d862;cursor: pointer;"> <i class="" style="padding: 4px 22px;background-color: white;color:black">Create Account</i><i class="fa  fa-check" style="padding: 2px 16px"></i></button></li>
          <div class="col-md-12" style="height: 10px;margin-top: 10px;"></div>
</div>
    </div>
</div>
  {!! Form::close() !!}
    </div>

</article><!-- /article -->

</main></div></div>



</div>

@section('js')

<script type='text/javascript' src='{{url("public/js/main.min.js")}}'></script>
<style type="text/css" media="screen">
 #make_password{display: none;}
 </style>
 <script>

    function isPassword() {
        if ($('input.is_acc').is(':checked')) {
          $("#make_password").show();


      }else{
         $("#make_password").hide();

      }
        }



$(document).ready(function () {
  //called when key is pressed in textbox
  $("#vat_number").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});

  </script>
@endsection
@endsection