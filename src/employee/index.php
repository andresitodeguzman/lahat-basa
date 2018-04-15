<?php
/**
 * All Wet
 * 2018
 * 
 * App
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
    <div class="splashscreen valign-wrapper blue-grey-3" id="splashscreen">
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

    <!-- navbar -->
	<div class="navbar-fixed" id="navbar">
        <nav class="blue-grey darken-2">
            <div class="nav-wrapper">
            <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
                <a class="title" href="#"><b>All Wet</b> Employee</a>
            </div>
        </nav>
    </div>
    <!-- .navbar -->

    <!-- sideNav -->
	<ul class="sidenav" id="snav">
            <li>
            <div class="user-view">
                <div class="background blue-grey darken-2">
                    <!--img src="/assets/imgs/sidenavbg.jpg"-->
                </div>
                <a href="/app">
                    <span class="white-text name">
                        <b>All Wet Employee</b>
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
        <div class="container">
            <h4 class="blue-grey-text text-darken-3">For Delivery <a href="#" onclick="setForDelivery()"><i class="material-icons grey-text">refresh</i></a></h4>
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
        <div class="container">
            <h4 class="blue-grey-text text-darken-3">Products <a href="#" onclick="setProducts()"><i class="material-icons grey-text">refresh</i></a></h4>
            <br>
            <div class="cards-container">
                <div id="productsList"></div>
            </div>
            <br><br><br>
        </div>
    </div>
    <!-- .productsActivity -->

    <!-- editAccountActivity -->
    <div class="activity col s12" id="editAccountActivity">
        <div class="container">
            <h4 class="blue-grey-text text-darken-3">Edit Account</h4>
            <br>
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" id="nameField">
                    <label for="name">Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input type="text" id="usernameField">
                    <label for="username">Username</label>
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

</body>
</html>