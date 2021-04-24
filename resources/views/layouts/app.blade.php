<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <link rel="shortcut icon" href="{{url('public/images/download.png')}}" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Jenkine') }}</title>
    @include('layouts._partials.header')

</head>

<style type="text/css">
    .intro {
        position: relative;
        color: #fffdff;
        /*padding: 50px 20% 100px;*/
        text-align: center;
    }
</style>
{{-- <div class="col-md-12" style="height: 20px;"></div> --}}

<header class="site-header fixed">
    <div class="wrap">
        <div class="title-area">
            <p class="site-title" itemprop="headline"><a class="navbar-brand" href="{{url('/')}}" style="font-family:BLKCHCRY;font-size: 30px;color: white;padding-top: 15px;">Jen<span style="color: #52d862">k</span>ine</a></p>
        </div>
        <div class="widget-area header-widget-area">
            <section id="nav_menu-3" class="widget widget_nav_menu">
                <div class="widget-wrap">
                    <nav class="nav-header" itemscope="" itemtype="#">
                        <ul id="menu-main-navigation" class="menu genesis-nav-menu">
                            <li id="menu-item-4228" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4228"><a href="{{url('appointment-types')}}" @if(Request::is( 'appointment-types')=="appointment-types" ) style="color: #52d862" @else style="color: #fff" @endif itemprop="url"><span itemprop="name">Appointment Type</span></a></li>
                            <li id="menu-item-4227" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4227"><a href="{{url('reserve/appointment')}}" @if(Request::is( 'reserve/appointment')=="reserve/appointment" ) style="color: #52d862" @else style="color: #fff" @endif itemprop="url"><span itemprop="name">Reserve</span></a></li>
                            <li id="menu-item-4226" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4226"><a href="{{url('shop/category')}}" @if(Request::is( 'shop/category')=="shop/category" ) style="color: #52d862" @else style="color: #fff" @endif itemprop="url"><span itemprop="name">Shop</span></a></li>
                            <li id="menu-item-4225" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4225"><a href="{{url('busket')}}" @if(Request::is( 'busket')=="busket" ) style="color: #52d862" @else style="color: #fff" @endif itemprop="url"><span itemprop="name"><i class="fa fa-shopping-basket"></i></span></a></li>

                            <li id="menu-item-4249" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4249"><a href="{{url('contact')}}"  @if(Request::is( 'contact')=="contact" ) style="color: #52d862" @else style="color: #fff" @endif itemprop="url" style="color: #fff"><span itemprop="name">Contact</span></a></li>

                            @if (Auth::check()) @if (Auth::user()->user_type==2)
                            <li id="menu-item-4251" class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-4251"><a href="{{url('my-account')}}" itemprop="url"><span itemprop="name" style="color: #52d862">Account</span></a></li>|   <li id="menu-item-4251" class=" menu-item menu-item-type-custom menu-item-object-custom menu-item-4251"><a href="{{url('logout')}}" itemprop="url"><span itemprop="name" style="color: #52d862">Logout</span></a></li>
                            @else

                            <li id="menu-item-4251" class=" menu-item menu-item-type-custom menu-item-object-custom menu-item-4251"><a href="{{url('logout')}}" itemprop="url"><span itemprop="name">Logout</span></a></li>

                            @endif @else

                            <li id="menu-item-4251" class=" menu-item menu-item-type-custom menu-item-object-custom menu-item-4251"><a href="{{url('login')}}" itemprop="url"><span itemprop="name">Login</span></a></li>
                            @endif


                            @if(Auth::check())
                                @if(Auth::user()->user_type==1)
                                    <li id="menu-item-4251" class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-4251"><a href="{{url('dashboard')}}" itemprop="url"><span itemprop="name" style="color: #52d862">Dashboard</span></a></li>|   <li id="menu-item-4251" class=" menu-item menu-item-type-custom menu-item-object-custom menu-item-4251"><a href="{{url('logout')}}" itemprop="url"><span itemprop="name" style="color: #52d862">Logout</span></a></li>

                                @endif
                            @endif

                        </ul>
                    </nav>
                </div>
            </section>

        </div>
    </div>
</header>

<body>

    @yield('content')

    <footer class="py-5 bg-dark footer-css">
        <?php
$dfoot=DB::table("company_info")->get();
?>
            <div class="container">
                <div class="row col-md-12">
                    <div class="col-md-4 footer-left-style-title">
                        <p style="padding-top: -10px;"><a class="navbar-brand" href="#" style="font-family:BLKCHCRY;font-size: 30px;padding: 0px;color: white">Jen<span style="color: #52d862">k</span>ine</a></p>
                        <p style="padding-top: -10px;"><i class="fa fa-home"></i> {{$dfoot[0]->address}}
                        </p>
                        <p style="padding-top: -10px;color: white"><i class="fa fa-home"></i>VAT: {{$dfoot[0]->vat_number}}
                        </p>
                        <p style="padding-top: -10px;"><i class="fa fa-phone"></i> {{$dfoot[0]->contact}}</p>
                        <p style="padding-top: -10px;"><a href="mailto:{{$dfoot[0]->email}}?subject=feedback" "email me"><i class="fa fa-envelope-open"></i> {{$dfoot[0]->email}}</a></p>
                    </div>
                    <div class="col-md-4" id="footer-middel-title">
                        <p style="padding-top: -10px;"><a class="navbar-brand" href="#" style="font-family:BLKCHCRY;font-size: 24px;padding: 0px;color: white">Pages</a></p>

                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="#">Personal Training</a></li>
                        <li><a href="{{url('reserve/appointment')}}">Reserve</a></li>
                        <li><a href="{{url('shop/category')}}">Shop</a></li>
                        <li><a href="{{url('contact')}}">Contact</a></li>
                        <li><a href="{{url('create-account')}}">Registration</a></li>
                    </div>
                    <div class="col-md-4" id="footer-right-title">
                        <p style="padding-top: -10px;"><a class="navbar-brand" href="#" style="font-family:BLKCHCRY;font-size: 24px;padding: 0px;color: white">My Account</a></p>

                        <li><a href="{{url('my-account')}}">My account</a></li>
                        <li><a href="{{url('my-account')}}">Account details</a></li>
                        <li><a href="{{url('my-account/my-appointments')}}">Appointments</a></li>
                        <li><a href="{{url('my-account/my-orders')}}">My order</a></li>
                        <li><a href="#">shop</a></li>
                    </div>
                </div>
            </div>
            <!-- /.container -->
    </footer>

    @include('layouts._partials.footer')
    @include('layouts._partials.modal')
</body>

</html>