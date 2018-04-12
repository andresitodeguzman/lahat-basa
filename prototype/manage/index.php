<!DOCTYPE html>
<html>
<head>
	<title>Manage (Prototype)</title>
	<?php
		require_once("../_system/styles.php");
	?>
    <style>
	    .nav-wrapper{
	        padding-left:1%;
	        padding-right: 3%;
	    }
	    .title {
	        padding-left: 1%;
	        font-size: 18pt;
	    }
    </style>
</head>
<body class="grey lighten-4">
	<div class="navbar-fixed">
        <nav class="blue-grey darken-3">
            <div class="nav-wrapper">
            <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
                <a class="title" href="#"><b>All Wet</b> Manager</a>
            </div>
        </nav>
    </div>
    <ul class="sidenav" id="snav">
        <li>
            <div class="user-view">
                <div class="background blue-grey darken-2">
                    <!--img src="/assets/imgs/sidenavbg.jpg"-->
                </div>
                <a href="app/profile.php">
                    <span class="white-text name">
                        <b>All Wet</b> Manager
                    </span>
                </a>
                <a href="/app">
                    <span class="white-text email">
                        ID: 12345
                    </span>
                </a>
            </div>
        </li>
        <li><a href="#" id="ordersButton"><i class="material-icons">list</i> Current Orders</a></li>
        <li><a href="#" id="teamButton"><i class="material-icons">people</i> Delivery Team</a></li>
        <li class="divider"></li>
        <li><a href="#" id="reportButton"><i class="material-icons">insert_chart</i> Sales Report</a></li>
        <li class="divider"></li>
        <li><a href="/authentication/logout.php"><i class="material-icons">person</i> Log-out</a></li>
    </ul>


    <div class="activity col s12" id="orders">
		<div class="container">
			<h3 class="blue-grey-text text-darken-2">
				Current Orders
			</h3>
			<br>
			
			<div class="card">
				<div class="card-img">
					<img src="https://maps.googleapis.com/maps/api/staticmap?center=14.322856,120.959199&zoom=17&size=800x300&markers=color:blue%7C14.322856,120.959199&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
				</div>
				<div class="card-content">
					<h5 class="blue-grey-text">Gregoria Montoya Hall, DLSU-D</h5>
					<p>
						- 3 pcs. 3 Gallons<br>
						- 2 pcs. 10 Gallons
					</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text">Delivered</a>
				</div>
			</div>

			<div class="card">
				<div class="card-img">
					<img src="https://maps.googleapis.com/maps/api/staticmap?center=14.320946,120.962915&zoom=17&size=800x300&markers=color:blue%7C14.320946,120.962915&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
				</div>
				<div class="card-content">
					<h5 class="blue-grey-text">3rd Floor, Paulo Campos Hall, DLSU-D</h5>
					<p>
						- 2 pcs. 10 Gallons<br>
						- 3 pcs. 3 Gallons
					</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text">Delivered</a>
				</div>
			</div>

			<div class="card">
				<div class="card-img">
					<img src="https://maps.googleapis.com/maps/api/staticmap?center=14.326718,120.957512&zoom=17&size=800x300&markers=color:blue%7C14.326718,120.957512&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
				</div>
				<div class="card-content">
					<h5 class="blue-grey-text">Ugnayang La Salle, DLSU-D</h5>
					<p>
						- 2 pcs. 10 Gallons
					</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text">Delivered</a>
				</div>
			</div>
			<br><br><br><br>
		</div>    	
    </div>

    <div class="activity col s12" id="team">
		<div class="container">
			<h3 class="blue-grey-text text-darken-2">
				Delivery Team
			</h3><br>

			<div class="card">
				<div class="card-content">
					<h5>Juan dela Cruz</h5>
					<p>09123456789</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text"> Call</a>
				</div>
			</div>

			<div class="card">
				<div class="card-content">
					<h5>Juan dela Cruz</h5>
					<p>09123456789</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text"> Call</a>
				</div>
			</div>

			<div class="card">
				<div class="card-content">
					<h5>Juan dela Cruz</h5>
					<p>09123456789</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text"> Call</a>
				</div>
			</div>

			<div class="card">
				<div class="card-content">
					<h5>Juan dela Cruz</h5>
					<p>09123456789</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text"> Call</a>
				</div>
			</div>

			<div class="card">
				<div class="card-content">
					<h5>Juan dela Cruz</h5>
					<p>09123456789</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text"> Call</a>
				</div>
			</div>

			<div class="card">
				<div class="card-content">
					<h5>Juan dela Cruz</h5>
					<p>09123456789</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text"> Call</a>
				</div>
			</div>

			<div class="card">
				<div class="card-content">
					<h5>Juan dela Cruz</h5>
					<p>09123456789</p>
				</div>
				<div class="card-action">
					<a class="blue-grey-text"> Call</a>
				</div>
			</div>
			<br><br><br><br>
		</div>    	
    </div>

    <div class="activity col s12" id="report">
		<div class="container">
			<h3 class="blue-grey-text text-darken-2">
				Sales Report
			</h3>
			<br>
			<div class="card blue-grey darken-3">
				<div class="card-content">
					<center>
						<h3 class="white-text">PHP 5,335.00</h3>
						<h5 class="white-text">Today's Earning</h5>
					</center>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col s6">

					<div class="card">
						<div class="card-content">
							<h4 class="blue-grey-text text-darken-2">500</h4>
							<p>
								Items Sold This Week
							</p>
						</div>
					</div>

				</div>
				<div class="col s6">
					<div class="card">
						<div class="card-content">
							<h4 class="blue-grey-text text-darken-2">27</h4>
							<p>
								New Customers This Month
							</p>
						</div>
					</div>
				</div>

			</div>
			<br><br><br><br>
		</div>    	
    </div>

</body>
</html>
<script type="text/javascript">
	$(document).ready(()=>{
		$("meta[name='theme-color']").attr("content", "#37474f");
		$('.sidenav').sidenav();
		clear();
		$("#orders").fadeIn();
	});

	function clear(){
		$(".activity").hide();
		$(".sidenav").sidenav('close');
	}

	$("#ordersButton").click(()=>{
		clear();
		$("#orders").fadeIn();
	});

	$("#teamButton").click(()=>{
		clear();		
		$("#team").fadeIn();
	});

	$("#reportButton").click(()=>{
		clear();
		$("#report").fadeIn();
	});
</script>