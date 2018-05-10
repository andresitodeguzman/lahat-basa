<?php
session_start();
require_once("../_system/config.php");
?>
<!Doctype html>
<html>
<head>
	<title>All Wet - Employee Sign-In</title>
	<?php require_once("../_system/head.php") ?>
	<script src="/authenticate/_scripts/employee.js"></script>
</head>
<body class="blue-grey darken-3">	
	<div class="container">
		<br><br>
		<center>
			<h4 class="white-text"><b>All Wet</b> Employee</h4>
		</center>
		<br><br>
    <div class="container">
		<div class="card z-depth-4">
			
			<div class="card-content" id="loader">
				<center>
					<div class="preloader-wrapper big active">
						<div class="spinner-layer spinner-blue-only">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div><div class="gap-patch">
								<div class="circle"></div>
							</div><div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>
					</div>
				</center>
			</div>
			
			<div class="card-content" id="entry">
				<br>
				<div class="input-field">
					<input type="text" id="username">
					<label for="username">Username</label>
				</div>
				<div class="input-field">
					<input type="password" id="password">
					<label for="password">Password</label>
				</div>
			</div>
			<div class="card-action">
				<a href="#" onclick="signIn()" class="blue-grey-text text-darken-2">Sign-In</a>
			</div>
		</div>
    </div>
    <br><br><br><br><br>
	</div>
</body>
</html>