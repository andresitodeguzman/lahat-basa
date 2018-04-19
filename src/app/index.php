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
						<b>All Wet</b>
					</h4>
				</center>
			</h3>
		</div>
		<!--.splashscreen-->

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
			<li><a href="#" onclick="editAccountShow()"><i class="material-icons">info</i> Edit Account</a></li>
			<li class="divider"></li>
			<li><a href="/authenticate/logout.php"><i class="material-icons">person</i> Log-out</a></li>

		</ul>
		<!-- .sideNav-->

		<!-- myorderActivity -->
		<div class="activity col s12" id="myorderActivity">

			<!-- navbar -->
			<div class="navbar-fixed" id="navbar">
				<nav class="blue darken-3 z-depth-2">
					<div class="nav-wrapper">
						<a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
						<a class="title" href="#"><b>All Wet</b></a>
						<div class="right">
							<a href="#" onclick="setMyOrders()"><i class="material-icons white-text">refresh</i></a>
						</div>
					</div>
				</nav>
			</div>
			<!-- .navbar -->

			<div class="container">
				<h4 class="blue-text text-darken-3">My Order</h4>
				<br>
				<div class="cards-container">
					<div id="orderList"></div>
				</div>
				<br><br><br><br>
			</div>
			<div class="fixed-action-btn">
				<a id="btnAdd" class="btn-floating btn-large blue darken-3 waves-effect waves-light btn-floating z-depth-3" href="/app/order.php">
                <i class="material-icons">add</i>
            </a>
			</div>
		</div>
		<!-- myorderActivity -->

		<!-- productsActivity -->
		<div class="activity col s12" id="productsActivity">

			<div class="navbar-fixed">
				<nav class="nav-extended blue darken-3 z-depth-2">
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
				<nav class="blue-grey darken-3 z-depth-2">
					<div class="nav-wrapper">
						<a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
						<a class="title" href="#"><b>All Wet</b></a>
					</div>
				</nav>
			</div>
			<!-- .navbar -->

			<div class="container">
				<br>
				<h4 class="blue-grey-text text-darken-3">Edit Account</h4>
				<br>
				<div class="row">
					<div class="input-field col s12">
						<input type="text" id="nameField">
						<label for="name">Name</label>
					</div>
					<div class="input-field col s12">
						<input type="text" id="addressField">
						<label for="address">Address</label>
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