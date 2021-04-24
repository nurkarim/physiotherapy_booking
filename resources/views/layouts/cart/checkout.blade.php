@extends('layouts.app')
@section('content')
    @if(@count(Session::get('appoinmentCart'))>0 || count(Session::get('shopcart'))>0)
        <style type="text/css" media="screen">
            .cart div li {
                list-style: none;
                padding: 10px;
            }

            .cart-ul {
                border: 1px solid #000
            }

            .cart {
                float: none;
                margin: 0 auto;
            }

            .checkout-table tr td {
                border-style: hidden;
            }

            table tr td {
                border-style: hidden;
            }

            table tr th {
                border-style: hidden;
            }

            table {
                padding: 0px;
                margin: 0px;
            }

            table {
                border-style: hidden;
            }

            li {
                list-style: none;
            }
        </style>
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

        <body>
        <div class="site-container">
            <style>
                .openForm .appointment_form {
                    height: 250px;
                }

                .openForm .appointment_form.large {
                    height: 270px;
                }

                p.appointment-info {
                    margin: 15px 0;
                }

                .appointment_form .left {
                }

                .appointment_form a.btn {
                    margin-top: 10px;
                }

                #newclients_wrap .close {
                    display: none;
                }

                #newclients_links {
                    margin: 15px 0;
                }

                #newclients_links a {
                    display: block;
                    color: white;
                    margin: 5px 10px 5px 0;
                }

                @media (max-width: 40em) {

                }
            </style>
            <script>

            </script>

            <div class="col-md-12" style="height: 20px"></div>
            <div class='bg-img' data-bglg='{{url("public/images/Spartanova-post-LI-copy.jpg")}}'
                 data-bgmd='{{url("public/images/Spartanova-post-LI-copy.jpg")}}'
                 data-bgsm='{{url("public/images/Spartanova-post-LI-copy-480x320.jpg")}}'>
            </div>

            <div class='header-wrap'>
                <div class='header-container'>
                    <div class="content-container">
                        <div class="content">
                            <header class='site-title-block'>
                                <h1><span class="red">Jenkiné Checkout</span><br/></h1>
                            </header>


                        </div>
                    </div>

                </div>
            </div>

            <div class="site-inner">
                <div class="content-sidebar-wrap">
                    <main class="content">

                        <article
                                class="post-4975 post type-post status-publish format-standard has-post-thumbnail entry">


                            <div class='entry-content'>
                                {!! Form::open(['url'=>URL::to('checkout/complete'),'id'=>'myForm','files'=>true]) !!}

                                <div class="mrg-div"></div>
                                <div class="row col-md-10" style="margin: auto;padding: 0px;">


                                        <input type="hidden" name="user_loggedin" value="0">

                                        <p><a href="{{url('login')}}" title="" style="font-weight: bold;">Returning
                                                client? Click here to login.</a></p>
                                        <div class="col-md-12 row">

                                            <table class="table checkout-table " style="border-style: hidden;">

                                                <tr>
                                                    <th colspan="2">Personal information:</th>
                                                </tr>

                                                <tr>
                                                    <td style="width: 15%">Name:</td>

                                                    <td><input type="text"
                                                               style="height: 35px;width: 200px;background-color: #f1f1f1"
                                                               name="first_name" class="form-control" required=""
                                                               value="{{old('first_name')}}"></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 10%">Last name:</td>

                                                    <td><input type="text"
                                                               style="height: 35px;width: 200px;background-color: #f1f1f1"
                                                               name="last_name" class="form-control" required=""
                                                               value="{{old('last_name')}}"></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 10%">Email:</td>

                                                    <td><input type="text"
                                                               style="height: 35px;width: 200px;background-color: #f1f1f1"
                                                               name="email" class="form-control" required="" id="email"
                                                               value="{{old('email')}}"><span id="userresult"
                                                                                              style="color: red"></span>
                                                    </td>
                                                </tr>
                                                <tr id="make_password">
                                                    <td style="width: 10%">Password:</td>

                                                    <td><input type="password"
                                                               style="height: 35px;width: 200px;background-color: #f1f1f1"
                                                               name="password" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 10%">VAT-number:</td>

                                                    <td><input type="text"
                                                               style="height: 35px;width: 200px;background-color: #f1f1f1"
                                                               name="user_vat_number" class="form-control"
                                                               onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                               value="{{old('user_vat_number')}}"></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 10%"></td>

                                                    <td>
                                                        <input type="checkbox" name="is_acc" class="is_acc" checked
                                                               style="display: none" value="1" onclick="isPassword()">

                                                    </td>
                                                </tr>

                                            </table>


                                        </div>
                                        <div class="col-md-12 row">


                                            <div class="col-md-6 row">


                                                <table class="table row">

                                                    <tr>
                                                        <th style="width: 100%">Invoice Adress:</th>

                                                    </tr>

                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <table>

                                                                <tr>
                                                                    <td>Adress:</td>
                                                                    <td><input type="text"
                                                                               style="height: 35px;width: 220px;background-color: #f1f1f1"
                                                                               name="address" class="form-control"
                                                                               id="address" required=""
                                                                               value="{{old('address')}}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Postal number:</td>
                                                                    <td><input type="text"
                                                                               style="height: 35px;width: 220px;background-color: #f1f1f1"
                                                                               name="post_code" class="form-control"
                                                                               id="post_code" required=""
                                                                               value="{{old('post_code')}}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>City:</td>
                                                                    <td><input type="text"
                                                                               style="height: 35px;width: 220px;background-color: #f1f1f1"
                                                                               name="city" class="form-control"
                                                                               id="city" required=""
                                                                               value="{{old('city')}}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Country:</td>
                                                                    <td>
                                                                        <select style="height: 30px;width: 220px;background-color: #f1f1f1"
                                                                                name="country" id="country">
                                                                            @foreach($country as $countryValue)
                                                                                <option value="{{$countryValue->id}}"
                                                                                        @if(old('country')==$countryValue->id) selected="" @endif>{{$countryValue->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 row">


                                                <table class="table row">

                                                    <tr>

                                                        <th style="width: 100%">Shipping Adress: <input type="checkbox"
                                                                                                        name="checkbox_check"
                                                                                                        class="checkbox_check"
                                                                                                        onclick="sameAddress()">
                                                            Use same as invoice adress
                                                        </th>
                                                    </tr>

                                                    <tbody>
                                                    <tr>

                                                        <td>
                                                            <table>

                                                                <tr>
                                                                    <td>Adress:</td>
                                                                    <td><input type="text"
                                                                               style="height: 35px;width: 220px;background-color: #f1f1f1"
                                                                               name="s_address" class="form-control"
                                                                               id="s_address" required=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Postal number:</td>
                                                                    <td><input type="text"
                                                                               style="height: 35px;width: 220px;background-color: #f1f1f1"
                                                                               name="s_post" class="form-control"
                                                                               id="s_post" required=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>City:</td>
                                                                    <td><input type="text"
                                                                               style="height: 35px;width: 220px;background-color: #f1f1f1"
                                                                               name="s_city" class="form-control"
                                                                               id=s_city required=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Country:</td>
                                                                    <td>
                                                                        <select style="height: 30px;width: 220px;background-color: #f1f1f1"
                                                                                name="s_country" id="s_country">
                                                                            @foreach($country as $countryValue)
                                                                                <option value="{{$countryValue->id}}">{{$countryValue->name}}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <script>
                                                    function sameAddress() {
                                                        if ($('input.checkbox_check').is(':checked')) {
                                                            var address = $("#address").val();
                                                            var post_code = $("#post_code").val();
                                                            var city = $("#city").val();


                                                            $("#s_address").val(address);
                                                            $("#s_post").val(post_code);
                                                            $("#s_city").val(city);
                                                        } else {
                                                            $("#s_address").val(" ");
                                                            $("#s_post").val(" ");
                                                            $("#s_city").val(" ");
                                                        }
                                                    }
                                                </script>
                                            </div>
                                            <div class="row col-md-12">
                                                <div class="col-md-6">
                                                    <h4 style="font-weight: bold;">Order notes</h4>
                                                    <textarea rows="6" name="order_note" placeholder="Add order notes.."
                                                              style="background-color: #f1f1f1""
                                                    class="form-control"></textarea>
                                                </div>

                                            </div>
                                            <div class="row col-md-12" style="margin-top: 10px;">
                                                <h4 style="font-weight: bold;">Your Order</h4>
                                                <div class="mrg-div"></div>
                                                <div class="row">
                                                    <div class="cart row col-md-12 ">

                                                        <div class="row col-md-12 cart-ul">
                                                            <li class="col-md-6"
                                                                style="color: #101010;font-weight: bold;font-size: 16px;">
                                                                Products
                                                            </li>
                                                            <li class="col-md-2 "
                                                                style="color: #101010;font-weight: bold;font-size: 16px;">
                                                                Price
                                                            </li>
                                                            <li class="col-md-2 "
                                                                style="color: #101010;font-weight: bold;font-size: 16px;">
                                                                Amount
                                                            </li>
                                                            <li class="col-md-2 "
                                                                style="color: #101010;font-weight: bold;font-size: 16px;">
                                                                Total price
                                                            </li>
                                                            <?php
                                                            $vatApp = 0;
                                                            $vatPDT = 0;
                                                            $appTotal = 0;
                                                            $PdtTotal = 0;
                                                            $vatNumber = 0;
                                                            $totalPriceProduct = 0;
                                                            $theVatAdded = 0;
                                                            $getVatNumber = 0;
                                                            $priceforUser = 0;
                                                            $subTotals = 0;
                                                            $PdtsubTotals = 0;
                                                            ?>
                                                            @if(Session::has('appoinmentCart'))
                                                                <?php
                                                                $dataRec = array_reverse(Session::get('appoinmentCart'));
                                                                $appointvat = 0;

                                                                $i = 1;
                                                                ?>
                                                                @foreach($dataRec as $dataRecValue)
                                                                    <?php

                                                                    $getVatNumber = '1.' . $dataRecValue['vat_number'];
                                                                    $totalPriceProduct = $dataRecValue['price'];
                                                                    $theVatAdded = (floatval($totalPriceProduct) / floatval($getVatNumber));
                                                                    $priceforUser = (floatval($totalPriceProduct) - floatval($theVatAdded));

                                                                    // $appointvat=$dataRecValue["price"];
                                                                    // $vatPrice=($dataRecValue["price"]*$dataRecValue["vat_number"])/100;
                                                                    // $vatNumber=$vatNumber+$dataRecValue["vat_number"];
                                                                    $vatApp += $priceforUser;
                                                                    $subTotals += $theVatAdded;
                                                                    $appTotal += $totalPriceProduct;
                                                                    ?>
                                                                    <div class="row col-md-12 "
                                                                         style="margin-top: -10px;">
                                                                        <li class="col-md-6"><span
                                                                                    style="color: #52d862;font-weight: bold;font-size: 15px;">{{$dataRecValue['name']}}</span>
                                                                            <p style="font-weight: 400;font-size: 13px">
                                                                                start
                                                                                date: <?php echo date("F d, Y", strtotime($dataRecValue['date'])); ?>
                                                                                , {{$dataRecValue['start_time']}}</p>
                                                                            <p style="margin-top: -12px;font-weight: 400;font-size: 13px">
                                                                                end
                                                                                date: <?php echo date("F d, Y", strtotime($dataRecValue['date'])); ?>
                                                                                ,
                                                                                <?php

                                                                                $date = new DateTime($dataRecValue['start_time']);
                                                                                $date->add(new DateInterval('PT60M'));
                                                                                echo $date->format('h:i') . "\n";  //it i will give you 10:00:00
                                                                                ?>
                                                                            </p>
                                                                        </li>
                                                                        <li class="col-md-2 text-center"
                                                                            style="color: #000;font-size: 16px;margin-left: -35px;">{{number_format($totalPriceProduct,2)}}
                                                                            €
                                                                        </li>
                                                                        <li class="col-md-2 text-center"
                                                                            style="color: #000;font-size: 16px;margin-left: -0px;">{{$dataRecValue['qty']}}</li>
                                                                        <li class="col-md-2 text-center"
                                                                            style="color: #000;font-size: 16px;margin-left: -0px;">{{number_format($totalPriceProduct,2)}}
                                                                            €
                                                                        </li>
                                                                    </div>
                                                                    @if(@count($dataRec)>1)
                                                                        <input type="hidden"
                                                                               name="appointment_type_id[]"
                                                                               value="{{$dataRecValue['id']}}">
                                                                        <input type="hidden" name="appointment_type[]"
                                                                               value="{{$dataRecValue['name']}}">
                                                                        <input type="hidden" name="appointment_price[]"
                                                                               value="{{$dataRecValue['price']}}">
                                                                        <input type="hidden" name="start_time[]"
                                                                               value="{{$dataRecValue['start_time']}}">
                                                                        <input type="hidden" name="end_time[]"
                                                                               value="{{$date->format('h:i')}}">
                                                                        <input type="hidden" name="date[]"
                                                                               value="{{$dataRecValue['date']}}">
                                                                        <input type="hidden" name="start_time_id[]"
                                                                               value="{{$dataRecValue['start_time_id']}}">
                                                                        <input type="hidden" name="specialist_id[]"
                                                                               value="{{$dataRecValue['specialist']}}">
                                                                        <input type="hidden" name="vat_number[]"
                                                                               value="{{$dataRecValue["vat_number"]}}">
                                                                        <input type="hidden" name="color[]"
                                                                               value="{{$dataRecValue["color"]}}">



                                                                    @else

                                                                        <input type="hidden" name="appointment_type_id"
                                                                               value="{{$dataRecValue['id']}}">
                                                                        <input type="hidden" name="appointment_type"
                                                                               value="{{$dataRecValue['name']}}">
                                                                        <input type="hidden" name="appointment_price"
                                                                               value="{{$dataRecValue['price']}}">
                                                                        <input type="hidden" name="start_time"
                                                                               value="{{$dataRecValue['start_time']}}">
                                                                        <input type="hidden" name="end_time"
                                                                               value="{{$date->format('h:i')}}">
                                                                        <input type="hidden" name="date"
                                                                               value="{{$dataRecValue['date']}}">
                                                                        <input type="hidden" name="start_time_id"
                                                                               value="{{$dataRecValue['start_time_id']}}">
                                                                        <input type="hidden" name="specialist_id"
                                                                               value="{{$dataRecValue['specialist']}}">
                                                                        <input type="hidden" name="vat_number"
                                                                               value="{{$dataRecValue["vat_number"]}}">
                                                                        <input type="hidden" name="color"
                                                                               value="{{$dataRecValue["color"]}}">
                                                                    @endif
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            @endif
                                                            @if(@count(Session::get('appoinmentCart'))>0 && count(Session::get('shopcart'))>0)
                                                                <div class="mrg-div col-md-12"
                                                                     style="border-top: 1px solid #000"></div>
                                                            @endif
                                                            {{-- //========================Product cart================================== --}}
                                                            @if(Session::has('shopcart'))

                                                                <?php
                                                                $dataPdt = array_reverse(Session::get('shopcart'));
                                                                $withVat = 0;
                                                                ?>
                                                                @foreach($dataPdt as $dataPdtValue)
                                                                    <?php


                                                                    $getVatNumber1 = $dataPdtValue["qty"] . '.' . $dataPdtValue['vat'];
                                                                    $totalPriceProduct1 = $dataPdtValue['product_price'];
                                                                    $theVatAdded1 = (floatval($totalPriceProduct1) / floatval($getVatNumber1));
                                                                    $priceforUser1 = (floatval($totalPriceProduct1) - floatval($theVatAdded1));
                                                                    $PdtTotal += $totalPriceProduct1 * $dataPdtValue["qty"];
                                                                    $vatPDT += $priceforUser1;
                                                                    $PdtsubTotals += $theVatAdded1;
                                                                    // $amount =60;
                                                                    // $percent =21;
                                                                    // echo $vat = round($amount - ($amount/(($percent/100)+1)),2);
                                                                    ?>
                                                                    <div class="row col-md-12 ">
                                                                        <li class="col-md-6">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <img src="{{url('public/image/products/display')}}/{{@$dataPdtValue['image']}}"
                                                                                         style="height: 60px;width: 80px;">
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <span style="color: #52d862;font-weight: bold;font-size: 15px;">{{$dataPdtValue['name']}}</span>
                                                                                    <p style="font-size: 14px;">{{@$dataPdtValue['option_products_html']}}</p>
                                                                                </div>
                                                                            </div>

                                                                        </li>
                                                                        <li class="col-md-2 text-center"
                                                                            style="color: #000;font-size: 16px;margin-left: -35px;">{{$dataPdtValue["product_price"]}}
                                                                            €
                                                                        </li>
                                                                        <li class="col-md-2 text-center"
                                                                            style="color: #000;font-size: 16px;">
                                                                            {{$dataPdtValue["qty"]}}
                                                                        </li>
                                                                        <li class="col-md-2 text-center"
                                                                            style="color: #000;font-size: 16px;"><span
                                                                                    id="sub_cart_total">{{number_format($totalPriceProduct1*$dataPdtValue["qty"],2)}}</span>
                                                                            €
                                                                        </li>

                                                                    </div>
                                                                    <input type="hidden" name="product_id[]"
                                                                           value="{{$dataPdtValue['id']}}">
                                                                    <input type="hidden" name="product_name[]"
                                                                           value="{{$dataPdtValue['name']}}">
                                                                    <input type="hidden" name="product_option_id[]"
                                                                           value="{{$dataPdtValue['option_products']}}">
                                                                    <input type="hidden" name="product_option[]"
                                                                           value="{{@$dataPdtValue['option_products_html']}}">
                                                                    <input type="hidden" name="product_price[]"
                                                                           value="{{@$dataPdtValue['product_price']}}">
                                                                    <input type="hidden" name="product_vat[]"
                                                                           value="{{@$dataPdtValue['vat']}}">
                                                                    <input type="hidden" name="image[]"
                                                                           value="{{@$dataPdtValue['image']}}">
                                                                    <input type="hidden" name="qty[]"
                                                                           value="{{@$dataPdtValue["qty"]}}">
                                                                @endforeach
                                                            @endif


                                                            <div class="row col-md-12 ">
                                                                <li class="col-md-8">
                                                                    @if(Auth::check())
                                                                        @if(Auth::user()->user_type==2)
                                                                            <p> My wallet: €
                                                                                @if(@Auth::user()->wallet->price>0)
                                                                                    {{Auth::user()->wallet->price}}

                                                                                @else
                                                                                    0.00
                                                                                @endif

                                                                                <input type="hidden"
                                                                                       name="my_wallet_amount"
                                                                                       value="@if(@Auth::user()->wallet->price>0) {{Auth::user()->wallet->price}}@else 0 @endif"
                                                                                       id="my_wallet_amount">
                                                                            </p>
                                                                            <p style="margin-top: -10px;"><input
                                                                                        type="checkbox" id="my_wallet"
                                                                                        name="my_wallet" value="1"
                                                                                        onclick=" return my_wallest()"><label
                                                                                        for="my_wallet"
                                                                                        style="cursor: pointer;">Use
                                                                                    credits from my wallet</label></p>
                                                                        @endif
                                                                    @endif
                                                                </li>
                                                                <div class="col-md-4"
                                                                     style="border-left: 1px solid #000">
                                                                    <div class="pull-right">


                                                                        <li style="margin-top: -16px;">Vat: <span
                                                                                    class="sub_total">
              <?php  $GrandVat = $vatPDT + $vatApp; ?>
                                                                                <input type="hidden" name="grand_vat"
                                                                                       value="{{number_format($GrandVat,2)}}">
                                                                                {{number_format($GrandVat,2)}}</span> €
                                                                        </li>
                                                                        <li style="margin-top: -16px;">Subtotal: <span
                                                                                    class="sub_total">
               <?php  $subt = $PdtsubTotals + $subTotals; ?>

                                                                                {{number_format($subt,2)}}</span><input
                                                                                    type="hidden" name="sub_total"
                                                                                    value="{{number_format($subt,2)}}">
                                                                            €
                                                                        </li>
                                                                        {{-- <li style="margin-top: -16px;">Wallet: <span class="wallet">-60,00</span> €</li> --}}
                                                                        <li style="margin-top: -16px;" id="total_li">
                                                                            Total: <span class="total">


<?php  $tot = $PdtTotal + $appTotal; ?>
                                                                                {{number_format($tot,2)}}
                                                                                <input type="hidden"
                                                                                       name="total_with_vat"
                                                                                       id="total_with_vat"
                                                                                       value="{{number_format($tot,2)}}">


            </span> €
                                                                        </li>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="">
                                                    <h4 style="font-size: 30px;font-weight: bold;padding-top: 10px;">
                                                        Payment method</h4>
                                                    <li>
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th style="font-size: 12px;width: 100px;"><img
                                                                            src="{{url('public/image/mony_transfer.png')}}"
                                                                            alt=""></th>
                                                                <th style="font-size: 12px;width: 100px;"><img
                                                                            src="{{url('public/image/homerun1492764401logo.png')}}">
                                                                    <br>
                                                                    <span>Mollie payment</span>
                                                                </th>

                                                            </tr>

                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td><input type="radio" name="payment_method" value="1">
                                                                </td>
                                                                <td><input type="radio" name="payment_method" value="2">
                                                                </td>
                                                            </tr>

                                                            </tbody>
                                                        </table>
                                                    </li>
                                                    <li style="margin-top: 10px;">
                                                        <button type="submit" class="btn btn-sm"
                                                                style="color: white;padding-left: 10px;background-color: #52d862;cursor: pointer;">
                                                            <i class=""
                                                               style="padding: 4px 22px;background-color: white;color:black">Place
                                                                orders</i><i class="fa  fa-check"
                                                                             style="padding: 2px 16px"></i></button>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                    {!! Form::close() !!}
                </div>

                </article><!-- /article -->

                </main></div>
        </div>


        </div>
        <style type="text/css" media="screen">
        </style>
        <script>

            function isPassword() {
                if ($('input.is_acc').is(':checked')) {
                    $("#make_password").show();


                } else {
                    $("#make_password").hide();

                }
            }


            var update_succ = $('.update-suc');

            function updateQty(id) {
                var product_id = id;
                var qty = $("#qty_" + id).val();


                if (product_id == null) {
                    alert('Warning!Please select a option product');
                    return false;
                }
                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                });
                $.ajax({
                    url: "{{url('update-cart')}}",
                    type: "GET",
                    cache: false,
                    dataType: 'json',
                    data: {'product_id': product_id, 'qty': qty},

                    success: function (data) {

                        if (data.success == true) {

                            update_succ.slideDown();
                            update_succ.delay(6000).slideUp(300);
                            location.reload();
                        } else if (data.success == false) {

                        }
                    },
                    error: function (data) {


                    }
                });
                return false;
            }

            function precise_round(num, decimals) {
                return Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
            }

            function countryAccVat() {
                var countryId = $('#s_country').val();
                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                });
                $.ajax({
                    url: "{{url('check-vat-acc-Country')}}",
                    type: "GET",
                    cache: false,
                    dataType: 'json',
                    data: {'countryId': countryId},

                    success: function (data) {

                        if (data.success == true) {

                            $("#vat_number").val(data.vat_number);
                            $("#vat").html(data.code);
                            $("#vat2").html(data.vat_number);
                            var subt = $(".sub_total").html();
                            var with_vat = (Number(subt) * Number(data.vat_number) / 100);

                            $("#vat_total_amount").val(with_vat);
                            $(".vat3").html(precise_round(with_vat, 2));
                            var gtot = (Number(with_vat) + Number(subt));
                            var ttt = precise_round(gtot, 2);
                            $(".total").html(ttt);
                            $("#total_with_vat").val(ttt);

                        } else if (data.success == false) {

                        }
                    },
                    error: function (data) {


                    }
                });
                return false;

            }


        </script>
        @section('js')
            <script type="text/javascript">
                $(document).ready(function () {
                    var x_timer;
                    $("#email").keyup(function (e) {


                        clearTimeout(x_timer);
                        var user_name = $(this).val();
                        x_timer = setTimeout(function () {
                            check_username_ajax(user_name);
                        }, 1000);
                    });

                    function check_username_ajax(username) {

                        $.get('{{url("email-checker")}}', {'email': username}, function (data) {
                            if (data == 1) {
                                $("#userresult").html("E-mail already taken for another client").css('color', 'red');
                            } else {
                                $("#userresult").html("E-mail is accepted").css('color', 'green');
                            }

                        });
                    }
                });
            </script>

            <script type='text/javascript' src='{{url("public/js/main.min.js")}}'></script>
@endsection

@else

@endif
@endsection