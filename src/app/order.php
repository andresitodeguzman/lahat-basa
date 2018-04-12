<?php
/**
 * All Wet
 * 2018
 * 
 * App
 * Order
 */

require_once("../_system/config.php");
?>
<!Doctype html>
<html>
    <head>
        <title>All Wet</title>
        <?php require_once("../_system/head.php"); ?>
        <script src="/app/_order.js"></script>
        <style>
            nav{
                padding-top: 10px;
                padding-right: 5%;
            }
            .materialize-textarea{
                color:white;
                font-size: 22pt !important;
            }
        </style>
    </head>
    <body class="blue darken-3">

        <!-- NAV -->
        <nav class="transparent z-depth-0">
            <a href="/app" class="right">
                <i class="material-icons">close</i>
            </a>
        </nav>
        <!-- .NAV -->

        <!-- locationLoaderActivity -->
        <div class="activity" id="locationLoaderActivity">
            <div class="container">
                <h3 class="white-text">
                    <i class="material-icons large">location_on</i><br><br>
                    <b>Please Wait</b><br>
                    We're Still<br>
                    Getting Your Location
                </h3>
                <p class="white-text">
                    Make sure that Location Services are on.<br>
                </p>
            </div><br><br><br>
        </div>
        <!-- .locationLoaderActivity -->

        <!-- locationErrorActivity -->
        <div class="activity" id="locationErrorActivity">
            <div class="container">
                <h3 class="white-text">
                    <i class="material-icons large">location_disabled</i><br><br>
                    <b>Location Permission Denied</b><br>
                    We cannot determine where you are
                </h3>
                <p class="white-text">
                    Allow us to know where we'll deliver your order
                </p>
            </div><br><br><br><br>
        </div>
        <!-- .locationErrorActivity -->

        <!-- locationProblemActivity -->
        <div class="activity" id="locationProblemActivity">
            <div class="container">
                <h3 class="white-text">
                    <i class="material-icons large">location_off</i><br>
                    <b>Location was not Found</b><br>
                    We don't know where you are
                </h3>
                <p class="white-text">
                    GPS or network signal might not be good
                </p>
            </div><br><br><br><br>
        </div>
        <!-- .locationProblemActivity -->

        <!-- locationServiceErrorActivity -->
        <div class="activity" id="locationServiceErrorActivity">
            <div class="container">
                <h3 class="white-text">
                    <i class="material-icons large">gps_not_fixed</i><br>
                    <b>Cannot Contact Google Maps</b><br>
                    Are you offline?
                </h3>
                <p class="white-text">
                    We got your coordinates but we cannot contact Google to know what street or place you're in.
                </p>
            </div><br><br><br><br>
        </div>
        <!-- .locationServiceErrorActivity -->

        <!-- locationActivity -->
        <div class="activity" id="locationActivity">
            <div class="container">
                <div id="locationResult"></div>
                <br><br>
                <div class="row">
                    <div class="col s6">
                        <a id="useLoc" class="btn btn-large btn-block waves-effect waves-light blue darken-4">
                            Yes! Deliver my order here!
                        </a>
                    </div>
                    <div class="col s6">
                        <a id="otherLoc" class="btn btn-large btn-block waves-effect waves-light blue darken-2">
                            No, Deliver my order somewhere
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a id="otherLoc" class="btn btn-large btn-block waves-effect waves-light blue">
                            I'll use my Saved Address Instead
                        </a>
                    </div>
                </div>
            </div><br><br><br><br>
        </div>
        <!-- .locationActivity -->

        <!-- enterAddressActivity -->
        <div class="activity" id="enterAddressActivity">
            <div class="container">
                <h3 class="white-text">Where do you want your order to be delivered?</h3>
                <br>
                <div class="input-field">
                    <textarea id="manualAddress" class="materialize-textarea"></textarea>
                </div><br>
                <br>
                <button id="submitManualLocation" class="btn btn-large btn-block blue darken-4 waves-effect waves-light">Ok, Done!</button>
            </div><br><br><br><br>
        </div>
        <!-- .enterAddressActivity -->

        <!-- orderActivity -->
        <div class="activity" id="orderActivity">
            <div class="container">
                <h3 class="white-text">What do you want to order?</h3><br>
            </div><br><br><br><br>
            <div class="fixed-action-btn">
                <a id="btnAdd" class="btn-floating btn-large white waves-effect waves-light" href="/app/order.php">
                    <i class="material-icons blue-text text-darken-3">arrow_forward</i>
                </a>
            </div>
        </div>
        <!-- .orderActivity -->

        <!-- paymentActivity -->
        <div class="activity" id="paymentActivity">
            <div class="container">
                <h3 class="white-text">
                    Choose your Payment Method
                </h3><br>
                <a class="btn btn-large blue darken-4 btn-block waves-effect waves-light">
                    Cash on Delivery
                </a><br><br>
                <a class="btn btn-large blue darken-2 btn-block waves-effect waves-light">
                    Pay with Credit Card
                </a>
            </div><br><br><br><br>
        </div>
        <!-- .paymentActivity -->

        <!-- completeActivity -->
        <div class="activity" id="completeActivity">
            <div class="container">
                <h3 class="white-text">
                    <br>
                    <i class="material-icons large">favorite</i><br>
                    Your order<br>
                    will be delivered shortly!
                </h3>
                <br><br>
                <a class="btn btn-large blue darken-4 btn-block waves-effect waves-light" href="/app">
                    Great! See my transactions
                </a><br><br>
            </div><br><br><br><br>
        </div>
        <!-- .completeActivity -->

    </body>
</html>