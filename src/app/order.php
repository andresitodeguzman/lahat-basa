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

        <!--splashscreen-->
        <div class="splashscreen valign-wrapper blue darken-3" id="splashscreen">
            <h3 class="valign center-block white-text">
                <noscript>
                <b class="white-text">
                    <center>
                        <h4>Sorry!</h4>
                        <h5>This application requires Javascript to be turned on.</h5>
                    </center>
                </b>
            </noscript>
                <center>
                    <h4>
                        <b>All Wet</b> Order
                    </h4>
                </center>
            </h3>
        </div>
        <!--.splashscreen-->

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
                <br><br>
                <div class="row">
                    <div class="col s12">
                        <a id="otherLoc" class="btn btn-large btn-block waves-effect waves-light blue darken-4" onclick="otherLoc()">
                            I'll just type where
                        </a>
                    </div>
                </div>
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
                <br><br>
                <div class="row">
                    <div class="col s12">
                        <a id="otherLoc" class="btn btn-large btn-block waves-effect waves-light blue darken-4" onclick="otherLoc()">
                            I'll just type where
                        </a>
                    </div>
                </div>
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
                <br><br>
                <div class="row">
                    <div class="col s12">
                        <a id="otherLoc" class="btn btn-large btn-block waves-effect waves-light blue darken-4" onclick="otherLoc()">
                            I'll just type where
                        </a>
                    </div>
                </div>
            </div><br><br><br><br>
        </div>
        <!-- .locationServiceErrorActivity -->

        <!-- locationActivity -->
        <div class="activity" id="locationActivity">
            <div class="container">
                <div id="locationResult"></div>
                <br><br>
                <div class="row">
                    <div class="col s12">
                        <a id="useLoc" class="btn btn-large btn-block waves-effect waves-light blue darken-4" onclick="setOrderActivity()">
                            Yes! Deliver here!
                        </a>
                    </div><br><br>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a id="otherLoc" class="btn btn-large btn-block waves-effect waves-light blue darken-2" onclick="otherLoc()">
                            No, Somewhere Else
                        </a>
                    </div><br><br>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a id="savedLoc" class="btn btn-large btn-block waves-effect waves-light blue">
                            Use my Saved Address
                        </a>
                    </div>
                </div>
            </div><br><br><br><br>
        </div>
        <!-- .locationActivity -->

        <!-- enterAddressActivity -->
        <div class="activity" id="enterAddressActivity">
            <div class="container">
                <h3 class="white-text">Where Do You Want Your Order to be Delivered?</h3>
                <br>
                <div class="input-field">
                    <textarea id="manualAddress" class="materialize-textarea"></textarea>
                </div><br>
                <br>
                <button id="submitManualLocation" class="btn btn-large btn-block blue darken-4 waves-effect waves-light" onclick="processAddressCoordinates()">Ok, Done!</button>
            </div><br><br><br><br>
        </div>
        <!-- .enterAddressActivity -->

        <!-- orderActivity -->
        <div class="activity" id="orderActivity">
            <div class="container">
                <h3 class="white-text">What do you want to order?</h3><br>
                <ul class="tabs tabs-fixed-width z-depth-1" id="categoryTabs">
                    <li class="tab active blue-text text-darken-4">Please Wait</li>
                </ul><br>
                <div class="cards-container" id="productsList"></div>
            </div><br><br><br><br>
            <div class="fixed-action-btn">
                <a id="btnAdd" class="btn-floating btn-large blue lighten-4 waves-effect waves-light z-depth-5 hoverable" href="#" onclick="showRundown()">
                    <i class="material-icons blue-text text-darken-4">arrow_forward</i>
                </a>
            </div>
        </div>
        <!-- .orderActivity -->

        <!-- rundownActivity -->
        <div class="activity" id="rundownActivity">
            <div class="container">
                <h3 class="white-text">
                    Here is the Rundown of your Order <span id="totalAmountRundown"></span>
                </h3><br>
                <div id="rundownList" class="cards-container">
                    <div class="card">
                        <div class="card-content">
                            <center>Please Wait</center>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <a class="btn btn-large blue darken-4 btn-block waves-effect waves-light" onclick="showPaymentActivity()">
                        Proceed to Payment
                    </a><br><br>
                    <a class="btn btn-large blue darken-2 btn-block waves-effect waves-light" onclick="returnToOrderActivity()">
                        Go Back
                    </a>    
                </div>
            </div><br><br><br><br>
        </div>
        <!-- .rundownActivity -->

        <!-- paymentActivity -->
        <div class="activity" id="paymentActivity">
            <div class="container">
                <h3 class="white-text">
                    Choose your Payment Method
                </h3><br>
                <a class="btn btn-large blue darken-4 btn-block waves-effect waves-light" onclick="payWithCash()">
                    Cash on Delivery
                </a><br><br>
                <a class="btn btn-large blue darken-2 btn-block waves-effect waves-light" onclick="payWithCard()" id="payWithCardButton">
                    Pay with Credit Card
                </a><br><br><br><br>
                <a class="btn btn-large blue darken-1 btn-block waves-effect waves-light" onclick="showRundown()">
                    Go Back
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
                <p class="white-text">
                    Keep an eye on your phone, we might get in touch with you through text or call. 
                </p>
                <br><br>
                <a class="btn btn-large blue darken-4 btn-block waves-effect waves-light" href="/app">
                    Great! Return to Dashboard
                </a><br><br>
            </div><br><br><br><br>
        </div>
        <!-- .completeActivity -->

    </body>
</html>