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
          <h1><span class="red">Jenkiné Login</span><br /></h1>
          </header>

          
        </div>
      </div>
             
  </div>
</div>

<div class="site-inner"><div class="content-sidebar-wrap"><main class="content">

<article class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry" >
@include('errors.messages')

    <div class='entry-content' style="height: 350px;">
      <div class="row ml-md-auto">
            <div class="col-md-6">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="{{url('login')}}">
                            {{csrf_field()}}
                            <fieldset>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" value="{{ old('email') }}" required autofocus>
                                     @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                     @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                </div>
                                <div class="checkbox">
                                    <label>
                                       <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn  btn-info ">Login</button>
                                  {{-- <a class="btn btn-link" href="#" style="text-decoration: none;">
                                    Forgot Your Password?</a> --}}
                            </fieldset>
                        </form>
                    </div>
                </div>
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