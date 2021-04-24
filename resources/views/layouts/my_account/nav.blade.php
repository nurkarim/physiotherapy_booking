
<style type="text/css" media="screen">
	.sub-menu li {padding: 5px;color: black;font-weight: 400;font-size: 18px;text-decoration: none;}
	.sub-menu li a{color: black;font-weight: 400;font-size: 18px;text-decoration: none;}
@media (max-width:40em) {
  body{height: 0px;}
  .sub-menu{display: none;}
  .header-wrap{height: 100px;}
}
</style>
    <ul class="sub-menu">

          <li ><a href="{{url('my-account')}}" title="My information"  @if(Request::is('my-account')=="my-account") style="color: #52d862"  @endif>My information </a></li>
          <li><a href="{{url('my-account/my-appointments')}}" @if(Request::is('my-account/my-appointments')=="my-account/my-appointments") style="color: #52d862"  @endif>My Appointments</a></li>
          <li><a href="{{url('my-account/list-history')}}" title="" @if(Request::is('my-account/list-history')=="my-account/list-history") style="color: #52d862"  @endif>History</a></li>
          <li><a href="{{url('my-account/unpaid-appointment')}}" title="" @if(Request::is('my-account/unpaid-appointment')=="my-account/unpaid-appointment") style="color: #52d862"  @endif>Unpaid Appointments</a></li>
          <li><a href="{{url('my-account/my-invoice')}}" title="" @if(Request::is('my-account/my-invoice')=="my-account/my-invoice") style="color: #52d862"  @endif>My invoices</a></li>

          <li><a href="{{url('my-account/my-orders')}}" title="" @if(Request::is('my-account/my-orders')=="my-account/my-orders") style="color: #52d862"  @endif>My Orders</a></li>
          <li><a href="{{url('my-account/requst-funds')}}" @if(Request::is('my-account/requst-funds')=="my-account/requst-funds") style="color: #52d862"  @endif>My wallet: € @if(@Auth::user()->wallet->price>0)
                {{Auth::user()->wallet->price}}

                @else
0.00
                @endif <i class="fa fa-credit-card" aria-hidden="true"></i></a></li>
          <li><a href="{{url('my-account/change-password')}}"  @if(Request::is('my-account/change-password')=="my-account/change-password") style="color: #52d862"  @endif>Password Change</a></li>
      </ul>
<section id="nav_menu-3" class="widget widget_nav_menu">
                <div class="widget-wrap">
                    <nav class="nav-header" itemscope="" itemtype="#">
                        <ul id="menu-main-navigation" class="menu genesis-nav-menu">
                            <li id="menu-item-4228" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4228"><a href="{{url('my-account')}}" title="My information" style="color: #fff" @if(Request::is('my-account')=="my-account") style="color: #52d862"  @endif itemprop="url"><span itemprop="name">My information</span></a></li>
                            <li id="menu-item-4227" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4227"><a href="{{url('my-account/my-appointments')}}" title="My Appointments" style="color: #fff" @if(Request::is('my-account/my-appointments')=="my-account/my-appointments") style="color: #52d862"  @endif  itemprop="url"><span itemprop="name">My Appointments</span></a></li>
                            <li id="menu-item-4226" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4226"><a href="{{url('my-account/list-history')}}" title="Appointment History" style="color: #fff" @if(Request::is('my-account/list-history')=="my-account/list-history") style="color: #52d862"  @endif  itemprop="url"><span itemprop="name">History</span></a></li>
                            <li id="menu-item-4225" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4225"><a  style="color: #fff" href="{{url('my-account/unpaid-appointment')}}" title="" @if(Request::is('my-account/unpaid-appointment')=="my-account/unpaid-appointment") style="color: #52d862"  @endif itemprop="url"><span itemprop="name">Unpaid Appointments</span></a></li>

                            <li id="menu-item-4249" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4249"><a  style="color: #fff" href="{{url('my-account/my-invoice')}}" title="" @if(Request::is('my-account/my-invoice')=="my-account/my-invoice") style="color: #52d862"  @endif itemprop="url"><span itemprop="name">My invoices</span></a></li>   

                            <li id="menu-item-4249" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4249"><a  style="color: #fff" href="{{url('my-account/my-orders')}}" title="" @if(Request::is('my-account/my-orders')=="my-account/my-orders") style="color: #52d862"  @endif itemprop="url"><span itemprop="name">My Orders</span></a></li>

                            <li id="menu-item-4249" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4249"><a  style="color: #fff"  href="{{url('my-account/requst-funds')}}" @if(Request::is('my-account/requst-funds')=="my-account/requst-funds") style="color: #52d862"  @endif itemprop="url"><span itemprop="name">My wallet: € @if(@Auth::user()->wallet->price>0)
                {{Auth::user()->wallet->price}}

                @else
0.00
                @endif <i class="fa fa-credit-card" aria-hidden="true"></i></span></a></li>
                
                            <li id="menu-item-4249" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4249"><a  style="color: #fff"  href="{{url('my-account/change-password')}}"  @if(Request::is('my-account/change-password')=="my-account/change-password") style="color: #52d862"  @endif itemprop="url"><span itemprop="name">Password Change</span></a></li>

                                        
                             
                        </ul>
                    </nav>
                </div>
            </section>