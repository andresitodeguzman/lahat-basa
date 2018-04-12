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
<!DOCTYPE html>
<html>
<head>
	<title>All Wet</title>
	<?php require_once("../_system/head.php"); ?>
	<script type="text/javascript" src="/app/_app.js"></script>
</head>
<body class="grey lighten-4">

    <!-- navbar -->
	<div class="navbar-fixed">
        <nav class="blue darken-3">
            <div class="nav-wrapper">
            <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
                <a class="title" href="#"><b>All Wet</b></a>
            </div>
        </nav>
    </div>
    <!-- .navbar -->

    <!-- sideNav -->
	<ul class="sidenav" id="snav">
            <li>
            <div class="user-view">
                <div class="background blue darken-2">
                    <!--img src="/assets/imgs/sidenavbg.jpg"-->
                </div>
                <a href="/app">
                    <span class="white-text name">
                        <b>All Wet Customer</b>
                    </span>
                </a>
                <a href="/app">
                    <span class="white-text email">
                        <span id="sidenav_customer_number"></span>
                    </span>
                </a>
            </div>
        </li>


		</div>

        <li><a href="#" onclick="orderShow()"><i class="material-icons">view_list</i> My Order</a></li>
        <li><a href="#" onclick="productsShow()"><i class="material-icons">local_mall</i> Products</a></li>
        <li class="divider"></li>
        <li><a href="/authenticate/logout.php"><i class="material-icons">person</i> Log-out</a></li>

    </ul>
    <!-- .sideNav-->

    <!-- myorderActivity -->
    <div class="activity col s12" id="myorderActivity">
        <div class="container">
            <h4 class="blue-text text-darken-3"><b>My Order</b></h4>
            <br>
            <div id="orderList"></div>
            <br><br><br><br>
        </div>
        <div class="fixed-action-btn">
            <a id="btnAdd" class="btn-floating btn-large blue darken-3 waves-effect waves-light btn-floating pulse" href="/app/order.php">
                <i class="material-icons">add</i>
            </a>
        </div>
    </div>
    <!-- myorderActivity -->

    <!-- productsActivity -->
    <div class="activity col s12" id="productsActivity">
        <div class="container">
            <h4 class="blue-text text-darken-3"><b>Products</b></h4>
            <br>
            <div class="cards-container">
                <div id="productsList"></div>
            </div>
            <br><br><br>
        </div>
    </div>
    <!-- .productsActivity -->

</body>
</html>
