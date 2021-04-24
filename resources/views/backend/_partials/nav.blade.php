<style type="text/css">
    #bg-black{background-color: #1b1818;}
    #bg-black li a{color: white}
    .navbar-default {
    background-color: #ffffff;
    border-color: #191515;
}
#bg-black li a:hover{color: black}
#bg-black li.active > a{
    color: red;
}

body {
    background-color: #ffffff;
}
#page-wrapper {
    padding: 0 15px;
    min-height: 568px;
    background-color: #ffffff;
}
   .prev{background-color: #2bd851;border-radius: 0px;}
.prev span{color: #fff;border-radius: 0px;}
.prev span:hover{color: #000;}

.picker-switch{background-color: #2bd851;border-radius: 0px;color: #fff}
.next{background-color: #2bd851;border-radius: 0px;}
.next span{color: #fff;border-radius: 0px;}
.next span:hover{color: #000;}
.picker-switch:hover{color: #000;}
.bootstrap-datetimepicker-widget{border:1px solid #ccc;}
.bootstrap-datetimepicker-widget table td.day {
    height: 15px;

    width: 20px;
}
.bootstrap-datetimepicker-widget table th {
    height: 20px;
    line-height: 40px;
    width: 20px;
}
.bootstrap-datetimepicker-widget table th {
    text-align: center;
     border-radius: 0px;
}
.sidebar ul li a.active {
    background-color: #922b2b;
}
</style>
<link href="{{url('public')}}/css/app.css" rel="stylesheet">


<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" style="color: black">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">P-Booking</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->

                <!-- /.dropdown -->

                <!-- /.dropdown -->

                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar " role="navigation" id="bg-black">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>

                        </li>

                         <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                          <div id="datetimepicker1" style="background-color: white"></div>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="{{url('dashboard')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="javascript::void()"><i class="fa  fa-plus-square fa-fw"></i> Appointment<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level" id="dropdown-menu_id">
                                <li>
                                    <a href="{{url('appointments/create/new')}}">Add Appointment</a>
                                </li>
                                <li>
                                    <a href="{{url('appointments')}}">Appointment List</a>
                                </li>
                                <li>
                                    <a href="{{url('appointment/types')}}">Appointment Types</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="{{url('orders')}}"><i class="fa  fa-cart-arrow-down fa-fw"></i> Order List</a>
                        </li>
                         <li>
                            <a href="{{url('invoices')}}"><i class="fa  fa-cart-arrow-down fa-fw"></i> invoices List</a>
                        </li>
                        <li>
                            <a href="{{url('creditList')}}"><i class="fa  fa-cart-arrow-down fa-fw"></i> Credit Note List</a>
                        </li>
                        <li>
                            <a href="{{url('clients')}}"><i class="fa  fa-user-plus fa-fw"></i> Clients</a>
                        </li>

                        <li>
                            <a href="javascript::void()"><i class="fa fa-product-hunt fa-fw"></i> Products<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level" id="dropdown-menu_id">
                                <li>
                                    <a href="{{url('products')}}">Product List</a>
                                </li>
                                <li>
                                    <a href="{{url('products/create')}}">Add Product</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="{{url('genarel-settings')}}"><i class="fa  fa-cog fa-fw"></i> General Setting</a>
                        </li>
                        <li>
                            <a href="javascript::void()"><i class="fa fa-cog fa-fw"></i> Setting<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level" id="dropdown-menu_id">
                                <li>
                                    <a href="{{url('roles')}}">Add Role</a>
                                </li>
                                 <li>
                                    <a href="{{url('country')}}">Add country</a>
                                </li>

                                 <li>
                                    <a href="{{url('setting/company')}}">company setting</a>
                                </li>


                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="{{url('availability')}}"><i class="fa  fa-cog fa-fw"></i> Availability</a>
                        </li>
                         <li>
                            <a href="{{url('users')}}"><i class="fa  fa-user-plus fa-fw"></i> Users</a>
                        </li>
                        <li>
                            <a href="{{url('wallet-requests')}}"><i class="fa   fa-credit-card"></i> Wallet Requests</a>
                        </li>
                         <li class="logout">
                            <a href="{{url('logout')}}"><i class="fa  fa-toggle-off fa-fw "></i> Logout</a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>

            <!-- /.navbar-static-side -->
        </nav>

        <script type="text/javascript">

        $(function () {
            $('#datetimepicker1').datetimepicker({
                inline: true,
                sideBySide: true,

                format: 'YYYY-MM-DD',

            });
   });

    </script>
