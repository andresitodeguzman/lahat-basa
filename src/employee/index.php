<?php
/**
 * All Wet
 * 2018
 * 
 * Employee
 * Index
 */
require_once("../_system/config.php");
?>
<!Doctype html>
<html>
<head>
  <title>All Wet - Employee</title>
  <?php require_once("../_system/head.php"); ?>
	<script type="text/javascript" src="/employee/_app.js"></script>
</head>
<body class="grey lighten-4">

    <!--splashscreen-->
    <div class="splashscreen valign-wrapper blue-grey darken-3" id="splashscreen">
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
                    <b>All Wet</b> Employee
                </h4>
            </center>
        </h3>
    </div>
    <!--.splashscreen-->

    <!-- sideNav -->
	<ul class="sidenav" id="snav">
            <li>
            <div class="user-view">
                <div class="background blue-grey darken-2">
                    <!--img src="/assets/imgs/sidenavbg.jpg"-->
                </div>
                <a href="/app">
                    <span class="white-text name">
                        <span id="empName"><b>All Wet</b> Employee</span><br>
                        <span id="empUsername">@username</span>
                    </span>
                </a>
                <a href="/app">
                    <span class="white-text email">
                        <span id="sidenav_employee_id"></span>
                    </span>
                </a>
            </div>
        </li>


		</div>

        <li><a href="#" onclick="forDeliveryShow()"><i class="material-icons">view_list</i> For Delivery</a></li>
        <li><a href="#" onclick="productsShow()"><i class="material-icons">local_mall</i> Products</a></li>
        <li class="divider"></li>
        <li><a href="#" onclick="editAccountShow()"><i class="material-icons">info</i> Edit Account</a></li>
        <li class="divider"></li>
        <li><a href="/authenticate/logout.php"><i class="material-icons">person</i> Log-out</a></li>

    </ul>
    <!-- .sideNav-->

    <!-- forDeliveryActivity -->
    <div class="activity col s12" id="forDeliveryActivity">

        <!-- navbar -->
        <div class="navbar-fixed" id="navbar">
            <nav class="blue-grey darken-2 z-depth-2">
                <div class="nav-wrapper">
                    <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
                    <a class="title" href="#"><b>All Wet</b> Employee</a>
                    <div class="right">
                        <a href="#" onclick="setForDelivery()"><i class="material-icons white-text">refresh</i></a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- .navbar -->

        <div class="container">
            <h4 class="blue-grey-text text-darken-3">For Delivery</h4>
            <br>
            <div class="cards-container">
                <div id="forDeliveryList"></div>
            </div>        
            <br><br><br><br>
        </div>
    </div>
    <!-- forDeliveryActivity -->

    <!-- productsActivity -->
    <div class="activity col s12" id="productsActivity">

        <div class="navbar-fixed">
            <nav class="nav-extended blue-grey darken-2 z-depth-2">
                <div class="nav-wrapper">
                    <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
                    <a class="title" href="#"><b>All Wet</b> Products</a>
                    <div class="right">
                        <a href="#" onclick="setProducts()"><i class="material-icons white-text">refresh</i></a>
                    </div>
                </div>
                <div class="nav-content">
                    <ul class="tabs tabs-transparent" id="categoryTabs"></ul>
                </div>
             </nav>
        </div>
        <!-- .navbar -->
        
        <div class="container">
            <br><br><br><br>
            <div class="cards-container">
                <div id="productsList"></div>
            </div>
            <br><br><br>
        </div>

    </div>
    <!-- .productsActivity -->

    <!-- editAccountActivity -->
    <div class="activity col s12" id="editAccountActivity">

        <!-- navbar -->
        <div class="navbar-fixed" id="navbar">
            <nav class="blue-grey darken-2 z-depth-2">
                <div class="nav-wrapper">
                    <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
                    <a class="title" href="#"><b>All Wet</b> Employee</a>
                </div>
            </nav>
        </div>
        <!-- .navbar -->

        <div class="container">
            <h4 class="blue-grey-text text-darken-3">Edit Account</h4>
            <br>
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" id="nameField">
                    <label for="name" class="active">Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input type="text" id="usernameField">
                    <label for="username" class="active">Username</label>
                </div>
                <div class="input-field col s6">
                    <input type="password" id="passwordField">
                    <label for="password">Password</label>
                </div>
            </div>
            <br><br>
            <button class="btn btn-large blue-grey darken-2 waves-effect waves-light" onclick="editAccount()">Edit</button>
            <br><br><br><br><br>
        </div>
    </div>
    <!-- .editAccountActivity -->

    <!-- deliveryModeActivity -->
    <div class="col s12 blue-grey darken-4 activity" id="deliveryModeActivity" style="width:100%; height:auto;">
        <!-- navbar -->
        <div class="navbar-fixed" id="navbar">
            <nav class="blue-grey darken-4 z-depth-0">
                <div class="nav-wrapper">
                    <a class="title" href="#" style="padding-left:30px"><b>All Wet</b> Delivery</a>
                    <a href="#" onclick="forDeliveryShow()" class="right">
                        <i class="material-icons">close</i>
                    </a>
                </div>
            </nav>
        </div>
        <!-- .navbar -->
        <div class="container"><br>
            <div id="dmMapImage">
                <img src="https://maps.googleapis.com/maps/api/staticmap?center=14.322856,120.959199&zoom=17&size=800x300&markers=color:blue%7C14.322856,120.959199&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%" style="border-radius:15px">
            </div>            
            <br>
            <h4 class="white-text"><b id="dmAddress">Address</b></h4>
            <h5 class="grey-text text-lighten-2" id="dmCountPrice">
                0 items for PHP 0.00
            </h5>
            <br>
            <span class="grey-text text-lighten-2">
                <i class="material-icons">person</i> <span id="dmCustomerName">Customer name</span><br>
                <i class="material-icons">date_range</i> <span id="dmDateTime">Date and Time</span><br>
                <i class="material-icons">credit_card</i> <span id="dmPaymentMethod">Payment Method</span>
            </span>
            <br><br><br><br>
                <div class="row">
                    <div class="col s6" id="dmContactCustomer"></div>
                    <div class="col s6">
                        <a href="#dmTransItemsModal" data-target="dmTransItemsModal" class="btn btn-large btn-block blue darken-2 modal-trigger">Items</a><br>
                        <div id="dmCancelButton">
                            <a href="#" class="btn btn-large btn-block red lighten-2">Cancel</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12" id="dmMainAct"></div>
                </div>
            <br>
            <br>
        </div>

        <div class="modal modal-fixed-footer" id="dmTransItemsModal">
            <div class="modal-content">
                <h5 class="blue-grey-text text-darken-4">Items</h5><br>
                <ul class="collection" id="dmTransItem"></ul>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
            </div>
        </div>

    </div>
    <!-- .deliveryModeActivity -->

</body>
</html>